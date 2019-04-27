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

use ElggMenuItem;

/**
 * @access private
 */
class Menus {
	
	public static function marketSiteMenu($hook, $type, $return, $params) {
		$return[] = \ElggMenuItem::factory([
			'name' => elgg_echo('market:title'),
			'text' => elgg_echo('market:title'),
			'href' => 'market',
			'icon' => 'credit-card',
		]);
		
		return $return;
	}
	
	public static function marketOwnerBlock($hook, $type, $return, $params) {
		$entity = elgg_extract('entity', $params);
		
		if ($entity instanceof \ElggUser) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'market',
				'text' => elgg_echo('market'),
				'href' => "market/owner/{$entity->username}",
			]);
		}
		
		if ($entity instanceof \ElggGroup) {
			if ($entity->market_enable == 'yes') {
				$return[] = \ElggMenuItem::factory([
					'name' => 'market',
					'text' => elgg_echo('market:group'),
					'href' => "market/group/{$entity->guid}/all",
				]);
			}
		}
		
		return $return;
	}
	
}
