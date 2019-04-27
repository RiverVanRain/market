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

class Notifications {
	
	public static function createMarket($hook, $type, $return_value, $params) {
		if (!($return_value instanceof \Elgg\Notifications\Notification)) {
			return;
		}
		
		$event = elgg_extract('event', $params);
		$recipient = elgg_extract('recipient', $params);
		$language = elgg_extract('language', $params);
		
		if (!($event instanceof \Elgg\Notifications\Event) || !($recipient instanceof \ElggUser)) {
			return;
		}
		
		$actor = $event->getActor();
		$market = $event->getObject();
		$market_type = elgg_echo("market:type:{$market->market_type}");
		
		$return_value->subject = elgg_echo('market:notify:subject:created', [], $language);
		$return_value->summary = elgg_echo('market:notify:summary:created', [], $language);
		$return_value->body = elgg_echo('market:notify:body:created', [
			$recipient->name,
			$market_type,
			$market->title,
			$market->description,
			$market->getURL(),
		], $language);
		
		return $return_value;
	}

}
