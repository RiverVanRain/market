<?php

namespace wZm\Dropzone;

use Elgg\Request;
use ElggFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Market\MarketFile;

class DropzoneService {

	/**
	 * dropzone/upload action handler
	 *
	 * @param Request $request Request
	 *
	 * @return array
	 */
	public function handleUploads(Request $request) {

		$subtype = $request->getParam('subtype');
		if (!$subtype) {
			$subtype = 'market_file';
		}

		$uploads = $this->saveUploadedFiles('dropzone', [
			'owner_guid' => $request->getParam('owner_guid') ? : elgg_get_logged_in_user_guid(),
			'container_guid' => $request->getParam('container_guid') ? : ELGG_ENTITIES_ANY_VALUE,
			'subtype' => $subtype,
			'access_id' => ACCESS_PRIVATE,
			'origin' => $request->getParam('origin', 'dropzone'),
		]);

		$output = [];

		foreach ($uploads as $upload) {

			$messages = [];
			$success = true;

			if (isset($upload->error)) {
				$messages[] = $upload->error;
				$success = false;
				$guid = false;
			} else {
				$file = $upload->file;
				$guid = $file->guid;
				$html = elgg_view('input/hidden', [
					'name' => $request->getParam('input_name', 'guids[]'),
					'value' => $file->guid,
				]);
			}

			$file_output = [
				'messages' => $messages,
				'success' => $success,
				'guid' => $guid,
				'html' => $html,
			];

			$output[] = elgg_trigger_event_results('upload:after', 'dropzone', [
				'upload' => $upload,
			], $file_output);
		}

		return $output;
	}

	/**
	 * Returns an array of uploaded file objects regardless of upload status/errors
	 *
	 * @param string $input_name Form input name
	 *
	 * @return UploadedFile[]
	 */
	protected function getUploadedFiles($input_name) {
		$file_bag = _elgg_services()->request->files;
		if (!$file_bag->has($input_name)) {
			return [];
		}

		$files = $file_bag->get($input_name);
		if (!$files) {
			return [];
		}
		if (!is_array($files)) {
			$files = [$files];
		}

		return $files;
	}

	/**
	 * Save uploaded files
	 *
	 * @param string $input_name Form input name
	 * @param array  $attributes File attributes
	 *
	 * @return MarketFile[]
	 */
	protected function saveUploadedFiles(string $input_name, array $attributes = []) {

		$files = [];

		$uploaded_files = $this->getUploadedFiles($input_name);

		$subtype = elgg_extract('subtype', $attributes, 'market_file', false);
		unset($attributes['subtype']);

		$class = elgg_get_entity_class('object', $subtype);
		if (!$class || !class_exists($class) || !is_subclass_of($class, MarketFile::class)) {
			$class = MarketFile::class;
		}

		foreach ($uploaded_files as $upload) {
			if (!$upload->isValid()) {
				$error = new \stdClass();
				$error->error = elgg_get_friendly_upload_error($upload->getError());
				if ($upload->getError() === UPLOAD_ERR_INI_SIZE || $upload->getError() === UPLOAD_ERR_FORM_SIZE) {
					// Get post_max_size and upload_max_filesize
					$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
					$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');
					
					// Determine the correct value
					$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;
					
					$files_upload_max_size = (int) format_from_bytes($max_upload);
					
					$error->error .= '<br />' . elgg_echo('theme:files:upload_limit', [$files_upload_max_size]);
				}
				$files[] = $error;
				continue;
			}

			$file = new $class();
			/* @var $file MarketFile */
			$file->setSubtype($subtype);
			foreach ($attributes as $key => $value) {
				$file->$key = $value;
			}

			$old_filestorename = '';
			if ($file->exists()) {
				$old_filestorename = $file->getFilenameOnFilestore();
			}

			$originalfilename = $upload->getClientOriginalName();
			$file->originalfilename = $originalfilename;
			if (empty($file->title)) {
				$file->title = htmlspecialchars($file->originalfilename, ENT_QUOTES, 'UTF-8');
			}

			$file->upload_time = time();
			$prefix = $file->filestore_prefix ? : 'file';
			$prefix = trim($prefix, '/');
			$filename = elgg_strtolower("$prefix/{$file->upload_time}{$file->originalfilename}");
			$file->setFilename($filename);
			$file->filestore_prefix = $prefix;

			$hook_params = [
				'file' => $file,
				'upload' => $upload,
			];

			$uploaded = _elgg_services()->events->triggerResults('upload', 'file', $hook_params);
			if ($uploaded !== true && $uploaded !== false) {
				$filestorename = $file->getFilenameOnFilestore();
				try {
					$uploaded = $upload->move(pathinfo($filestorename, PATHINFO_DIRNAME), pathinfo($filestorename, PATHINFO_BASENAME));
				} catch (FileException $ex) {
					elgg_log($ex->getMessage(), 'ERROR');
					$uploaded = false;
				}
			}

			if (!$uploaded) {
				$error = new \stdClass();
				$error->error = elgg_echo('dropzone:file_not_entity');
				$files[] = $error;
				continue;
			}

			if ($old_filestorename && $old_filestorename != $file->getFilenameOnFilestore()) {
				// remove old file
				unlink($old_filestorename);
			}
			$mime_type = elgg()->mimetype->getMimeType($file->getFilenameOnFilestore(), $upload->getClientMimeType());
			if($mime_type == 'image/vnd.djvu' || $mime_type == 'image/vnd.djvu+multipage'){
				$file->setMimeType('application/x-ext-djvu');
			}
			else {
				$file->setMimeType($mime_type);
			}
			$file->simpletype = elgg()->mimetype->getSimpleType($mime_type);
			_elgg_services()->events->triggerAfter('upload', 'file', $file);

			if (!$file->save() || !$file->exists()) {
				$file->delete();
				$error = new \stdClass();
				$error->error = elgg_echo('dropzone:file_not_entity');
				$files[] = $error;
				continue;
			}

			if (($file->getMimeType() == 'image/jpeg' || $file->getMimeType() == 'image/png' || $file->getMimeType() == 'image/gif') && $file->saveIconFromElggFile($file)) {
				$file->thumbnail = $file->getIcon('small')->getFilename();
				$file->smallthumb = $file->getIcon('medium')->getFilename();
				$file->largethumb = $file->getIcon('large')->getFilename();
			}

			$success = new \stdClass();
			$success->file = $file;
			$files[] = $success;
		}

		return $files;
	}

}
