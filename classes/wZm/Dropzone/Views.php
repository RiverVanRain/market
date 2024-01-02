<?php

namespace wZm\Dropzone;

use \Elgg\ViewsService;

class Views {
	
	/**
	 * Make an input/file into a dropzone
	 *
	 * @param string $event         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return mixed
	 */
	public static function fileToDropzone(\Elgg\Event $event) {
		$return_value = $event->getValue();
		
		$prevent_deadloop = isset($return_value['__Dropzone']);
		unset($return_value['__Dropzone']);
		
		if ($prevent_deadloop) {
			return $return_value;
		}
		
		$vars = $return_value;
		$vars['subtype'] = \wZm\Dropzone\TempUploadFile::SUBTYPE;
		$vars['multiple'] = (bool) elgg_extract('multiple', $return_value, false);
		if (!$vars['multiple']) {
			$vars['max'] = 1;
		}
		
		//Enable/disable Dropzone
		$vars['enable_dropzone'] = (bool) elgg_extract('enable_dropzone', $return_value, false);
		
		$return_value[ViewsService::OUTPUT_KEY] = elgg_view('input/dropzone', $vars);
		
		if ($vars['enable_dropzone'] == true) {
			return $return_value;
		}
	}
	
	/**
	 * Set a flag in input/dropzone to prevent deadloops with input/file
	 *
	 * @param string $event         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return mixed
	 */
	public static function preventDropzoneDeadloop(\Elgg\Event $event) {
		$return_value = $event->getValue();
		
		$return_value['__Dropzone'] = true;
		
		return $return_value;
	}
}
