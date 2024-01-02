<?php

namespace Market\Forms;

/**
 * Prepare the fields for the market/save form
 *
 * @since 5.0
 */
class PrepareFields {
	
	/**
	 * Prepare fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'market/save'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		// input names => defaults
		$values = [
			'title' => null,
			'description' => null,
			'access_id' => ACCESS_DEFAULT,
			'tags' => null,
			'container_guid' => null,
			'guid' => null,
			'comments_on' => 'Off',
			'price' => null,
			'marketcategory' => null,
			'market_type' => null,
			'location' => null,
			'custom' => null,
		];
		
		$market = elgg_extract('entity', $vars);
		if ($market instanceof \ElggMarket) {
			// load current market values
			foreach (array_keys($values) as $field) {
				if (isset($market->$field)) {
					$values[$field] = $market->$field;
				}
			}
		}
		
		return array_merge($values, $vars);
	}
}
