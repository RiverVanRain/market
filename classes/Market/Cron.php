<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market;

use ElggMarket;
use Elgg\Hook;

class Cron {
	
	public static function marketCronDaily(Hook $hook) {
		
		echo "Starting delete expired Market ads processing" . PHP_EOL;
		elgg_log("Starting delete expired Market ads processing", 'NOTICE');
		
		// ignore access
		elgg_call(ELGG_IGNORE_ACCESS, function() {
			$market_ttl = elgg_get_plugin_setting('market_expire', 'market');
			if ($market_ttl == 0) {
				return true;
			}
			$time_limit = strtotime("-$market_ttl months");
			
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => ElggMarket::SUBTYPE,
				'limit' => false,
				'created_time_upper' => $time_limit,
				'batch' => true,
				'batch_inc_offset' => false,
			]);
			
			foreach ($entities as $entity) {
				$date = date('j/n-Y', $entity->time_created);
				$title = $entity->title;
				$owner = $entity->getOwnerEntity();
				
				$subject = elgg_echo('market:expire:subject', [], $owner->language);
				$body = elgg_echo('market:expire:body', [$owner->name, $title, $date, $market_ttl], $owner->language);
				
				notify_user(
					$owner->guid,
					elgg_get_site_entity()->guid,
					$subject,
					$body,
					[
						'object' => $entity,
						'action' => 'delete',
					],
					'site'
				);
				
				$entity->delete;
			}
			
			// restore access
		});
		
		echo "Finished delete expired Market ads processing" . PHP_EOL;
		elgg_log("Finished delete expired Market ads processing", 'NOTICE');
	}
	
}
