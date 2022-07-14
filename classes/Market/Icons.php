<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market;

class Icons {
	
	public static function setIconSizes(\Elgg\Hook $hook) {
	
		if ($hook->getParam('entity_subtype') !== 'file') {
			return;
		}
	
		$return = $hook->getValue();
		
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
	
	public static function setIconFile(\Elgg\Hook $hook) {
	
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggFile) {
			return;
		}
		
		$size = $hook->getParam('size', 'large');
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
	
		$icon = $hook->getValue();
		
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
