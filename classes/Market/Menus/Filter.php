<?php

namespace Market\Menus;

/**
 * Hook callbacks for menus
 *
 * @since 4.0
 * @internal
 */
class Filter {

	public static function allRegister(\Elgg\Hook $hook) {
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('market:type:all'),
			'href' => elgg_generate_url('collection:object:market:all', [
				'subpage' => 'all',
			]),
		]);
		
		if (elgg_is_logged_in()) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'mine',
				'text' => elgg_echo('market:type:mine'),
				'href' => elgg_generate_url('collection:object:market:owner', [
					'username' => elgg_get_logged_in_user_entity()->username,
				]),
			]);
		}
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'buy',
			'text' => elgg_echo('market:type:buy'),
			'href' => elgg_generate_url('collection:object:market:all', [
				'subpage' => 'buy',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'sell',
			'text' => elgg_echo('market:type:sell'),
			'href' => elgg_generate_url('collection:object:market:all', [
				'subpage' => 'sell',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'swap',
			'text' => elgg_echo('market:type:swap'),
			'href' => elgg_generate_url('collection:object:market:all', [
				'subpage' => 'swap',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'free',
			'text' => elgg_echo('market:type:free'),
			'href' => elgg_generate_url('collection:object:market:all', [
				'subpage' => 'free',
			]),
		]);
		return $return;
	}
	
	public static function ownerRegister(\Elgg\Hook $hook) {
		$entity = $hook->getParam('filter_entity');
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('market:type:all'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
				'subpage' => 'all',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'buy',
			'text' => elgg_echo('market:type:buy'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
				'subpage' => 'buy',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'sell',
			'text' => elgg_echo('market:type:sell'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
				'subpage' => 'sell',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'swap',
			'text' => elgg_echo('market:type:swap'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
				'subpage' => 'swap',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'free',
			'text' => elgg_echo('market:type:free'),
			'href' => elgg_generate_url('collection:object:market:owner', [
				'username' => $entity->username,
				'subpage' => 'free',
			]),
		]);
		
		return $return;
	}
	
	public static function groupRegister(\Elgg\Hook $hook) {
		$entity = $hook->getParam('filter_entity');
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		if (!(bool) elgg_get_plugin_setting('enable_groups', 'market')) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('market:type:all'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
				'subpage' => 'all',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'buy',
			'text' => elgg_echo('market:type:buy'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
				'subpage' => 'buy',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'sell',
			'text' => elgg_echo('market:type:sell'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
				'subpage' => 'sell',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'swap',
			'text' => elgg_echo('market:type:swap'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
				'subpage' => 'swap',
			]),
		]);
		$return[] = \ElggMenuItem::factory([
			'name' => 'free',
			'text' => elgg_echo('market:type:free'),
			'href' => elgg_generate_url('collection:object:market:group', [
				'guid' => $entity->guid,
				'subpage' => 'free',
			]),
		]);
		
		return $return;
	}
	
	public static function categoryRegister(\Elgg\Hook $hook) {
		$return = $hook->getValue();
		
		$tabs = elgg_string_to_array(elgg_get_plugin_setting('market_categories', 'market', ''));

		foreach ($tabs as $tab) {
			$return[] = \ElggMenuItem::factory([
				'name' => $tab,
				'text' => $tab,
				'href' => elgg_generate_url('category:object:market', [
					'category' => urlencode($tab),
				]),
			]);
		}
		
		return $return;
	}
}
