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

class Hooks {
	
	public static function deleteMarket($event, $type, \ElggObject $entity) {
		if (!$entity instanceof \ElggMarket) {
			return;
		}
		
		if (!$entity->guid) {
			return;
		}
		
		if (!$entity->canEdit()) {
			return;
		}
		
		$options = [
			'relationship' => 'attached',
			'relationship_guid' => $entity->guid,
			'inverse_relationship' => true,
			'metadata_name_value_pairs' => [
				'name' => 'simpletype', 'value' => 'image',
			],
			'limit' => 0,
		];
		$files = elgg_get_entities($options);
		
		if(empty($files)){
			return;
		}
		
		foreach ($files as $file) {
			$file->delete();
		}
	}
	
	public static function deleteImage($event, $type, \ElggObject $entity) {
		if (!$entity instanceof \ElggFile) {
			return;
		}
		
		if (!$entity->guid) {
			return;
		}
		
		if (!$entity->canEdit()) {
			return;
		}
		
		$container = get_entity($entity->container_guid);
		if (!$container instanceof \ElggUser || !$container instanceof \ElggGroup) {
			return;
		}
		
		remove_entity_relationship($entity->guid, 'attached', $container->guid);
	}
	
}
