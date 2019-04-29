<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain, Rohit Gupta
 * @copyright slyhne 2010-2015, wZm 2017
 * @link https://wzm.me
 * @version 3.0
 */
namespace Market;

use \Elgg\ViewsService;

class Views {
	
	public static function fileToDropzone($hook, $type, $return_value, $params) {
		
		$prevent_deadloop = isset($return_value['__hypeDropzone']);
		unset($return_value['__hypeDropzone']);
		
		if ($prevent_deadloop) {
			return $return_value;
		}
		
		$vars = $return_value;
		$vars['subtype'] = \TempUploadFile::SUBTYPE;
		$vars['multiple'] = (bool) elgg_extract('multiple', $return_value, false);
		if (!$vars['multiple']) {
			$vars['max'] = 1;
		}
		
		//Enable/disable Dropzone
		$vars['enable_dropzone'] = (bool) elgg_extract('enable_dropzone', $return_value, true);
		if ($vars['enable_dropzone'] == false) {
			return;
		}
		
		$return_value[ViewsService::OUTPUT_KEY] = elgg_view('input/dropzone', $vars);
		
		return $return_value;
	}
	
	public static function fileSetCustomIconSizes($hook, $type, $return, $params) {

		$entity_subtype = elgg_extract('entity_subtype', $params);
		if ($entity_subtype !== 'file') {
			return;
		}

		$return['small'] = [
			'w' => 60,
			'h' => 60,
			'square' => true,
			'upscale' => true,
		];
		$return['medium'] = [
			'w' => 153,
			'h' => 153,
			'square' => true,
			'upscale' => true,
		];
		$return['large'] = [
			'w' => 600,
			'h' => 600,
			'upscale' => false,
		];
		
		return $return;
	}
	
	public static function fileSetIconFile($hook, $type, $icon, $params) {

		$entity = elgg_extract('entity', $params);
		$size = elgg_extract('size', $params, 'large');

		if (!($entity instanceof \ElggFile)) {
			return;
		}
		
		switch ($size) {
			case 'small' :
				$filename_prefix = 'thumb';
				$metadata_name = 'thumbnail';
				break;

			case 'medium' :
				$filename_prefix = 'smallthumb';
				$metadata_name = 'smallthumb';
				break;

			default :
				$filename_prefix = "{$size}thumb";
				$metadata_name = $filename_prefix;
				break;
		}

		$icon->owner_guid = $entity->owner_guid;
		if (isset($entity->$metadata_name)) {
			$icon->setFilename($entity->$metadata_name);
		} else {
			$filename = pathinfo($entity->getFilenameOnFilestore(), PATHINFO_FILENAME);
			$filename = "file/{$filename_prefix}{$filename}.jpg";
			$icon->setFilename($filename);
		}
		
		return $icon;
	}
	
}
