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

use ElggMarket;

class Cron {
	
	public static function marketCronDaily($hook, $entity, $return, $params) {
		
		$market_ttl = elgg_get_plugin_setting('market_expire', 'market');
		if ($market_ttl == 0) {
			return true;
		}
		$time_limit = strtotime("-$market_ttl months");
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
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
		elgg_set_ignore_access($ia);
	}
	
}
