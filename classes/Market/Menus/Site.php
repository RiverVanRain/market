<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market\Menus;

/**
 * Hook callbacks for menus
 *
 * @since 4.0
 *
 * @internal
 */
class Site {

	/**
	 * Register item to menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return \Elgg\Menu\MenuItems
	 */
	public static function register(\Elgg\Event $event) {
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'market',
			'icon' => 'credit-card',
			'text' => elgg_echo('collection:object:market'),
			'href' => elgg_generate_url('default:object:market'),
		]);
		
		return $return;
	}
}
