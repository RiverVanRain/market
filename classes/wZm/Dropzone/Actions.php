<?php

namespace wZm\Dropzone;

use Elgg\Hook;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Actions {
	
	/**
	 * Load uploaded file in the system for further use
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return void
	 */
	public static function prepareFiles(Hook $hook) {
		
		$file_fields = (array) get_input('dropzone_fields');
		if (empty($file_fields)) {
			return;
		}
		
		$filebag = _elgg_services()->request->files;
		
		// check all dropzone fields
		foreach ($file_fields as $field_name) {
			
			$file_guids = (array) get_input($field_name);
			if (empty($file_guids)) {
				// try inputname without trailing []
				$field_name = rtrim(rtrim($field_name, ']'), '[');
				
				$file_guids = (array) get_input($field_name);
				if (empty($file_guids)) {
					continue;
				}
			}
			
			$files = [];
			
			// fake uploaded file into PHP/Elgg
			foreach ($file_guids as $guid) {
				
				$file = get_entity($guid);
				if (!($file instanceof \ElggFile)) {
					continue;
				}
				
				$tmp_filename = $file->getFilenameOnFilestore();
				if ($file instanceof \wZm\Dropzone\TempUploadFile) {
					$tmp_dir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
					$tmp_filename = tempnam($tmp_dir, 'dropzone_');
					copy($file->getFilenameOnFilestore(), $tmp_filename);
				}
				
				$files[] = [
					'name' => $file->getDisplayName(),
					'type' => $file->getMimeType(),
					'size'=> $file->getSize(),
					'tmp_name'=> $tmp_filename,
					'error'=> UPLOAD_ERR_OK,
				];
				
				if ($file instanceof \wZm\Dropzone\TempUploadFile) {
					$file->delete();
				}
			}
			
			if (empty($files)) {
				continue;
			}
			
			if (count($files) === 1) {
				$_FILES[$field_name] = $files[0];
				
				$uploaded_file = self::arrayToUploadedFile($files[0]);
				
				$filebag->set($field_name, $uploaded_file);
			} else {
				
				$uploaded_files = [];
				
				foreach ($files as $index => $file_data) {
					$uploaded_files[] = self::arrayToUploadedFile($file_data);
					
					$_FILES[$field_name]['error'][$index] = $file_data['error'];
					$_FILES[$field_name]['name'][$index] = $file_data['name'];
					$_FILES[$field_name]['size'][$index] = $file_data['size'];
					$_FILES[$field_name]['tmp_name'][$index] = $file_data['tmp_name'];
					$_FILES[$field_name]['type'][$index] = $file_data['type'];
				}
				
				$filebag->set($field_name, $uploaded_files);
			}
		}
	}
	
	/**
	 * convert $_FILES array to UploadedFile
	 *
	 * @param array $file_data file information array
	 *
	 * @return false|\Symfony\Component\HttpFoundation\File\UploadedFile
	 */
	protected static function arrayToUploadedFile($file_data) {
		
		if (!is_array($file_data)) {
			return false;
		}
		
		$req_fields = ['error', 'name', 'size', 'tmp_name', 'type'];
		$keys = array_keys($file_data);
		sort($keys);
		
		if ($keys !== $req_fields) {
			return false;
		}
		
		return new UploadedFile(
			$file_data['tmp_name'],
			$file_data['name'],
			$file_data['type'],
			$file_data['size'],
			$file_data['error'],
			true
		);
	}
}
