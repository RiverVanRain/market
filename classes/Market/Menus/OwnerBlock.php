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
class OwnerBlock {

	/**
	 * Register user item to menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:owner_block'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function registerUserItem(\Elgg\Event $event) {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'market',
			'text' => elgg_echo('collection:object:market'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
			]),
		]);
				
		return $return;
	}

	/**
	 * Register group item to menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:owner_block'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function registerGroupItem(\Elgg\Event $event) {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		if (!$entity->isToolEnabled('market')) {
			return;
		}
		
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'market',
			'text' => elgg_echo('collection:object:market:group'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
			]),
		]);

		return $return;
	}
}
