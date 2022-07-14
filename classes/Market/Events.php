<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market;

class Events {
	
	public static function deleteMarket(\Elgg\Event $event) {
		$entity = $event->getObject();
		if (!$entity instanceof \ElggMarket) {
			return;
		}
		
		if (!$entity->guid) {
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
	
	public static function deleteImage(\Elgg\Event $event) {
		$entity = $event->getObject();
		if (!$entity instanceof \ElggFile) {
			return;
		}
		
		if (!$entity->guid) {
			return;
		}
		
		$container = $entity->getContainerEntity();
		if (!$container instanceof \ElggMarket) {
			return;
		}
		
		remove_entity_relationship($entity->guid, 'attached', $container->guid);
	}
	
}
