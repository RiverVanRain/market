<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2k17
 * @link https://wzm.me
 * @version 2.2
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init','system','market_init');

function market_init() {

	require_once __DIR__ . '/lib/market.php';
	
	elgg_register_plugin_hook_handler('entity:url', 'object', 'market_entity_url_handler');
	
	elgg_register_entity_type('object', 'market');

	elgg_register_menu_item('site', array(
					'name' => elgg_echo('market:title'),
					'text' => elgg_echo('market:title'),
					'href' => 'market/all',
					'icon' => 'credit-card',
	));

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'market_owner_block_menu');
	elgg_extend_view('page/elements/sidebar', 'market/sidebar', 100);
	
	//Groups
	elgg()->group_tools->register('market', [
		'default_on' => true,
		'label' => elgg_echo('market:enablemarket'),
	]);

	//CSS
	elgg_extend_view('elgg.css', 'market/css');

	//JS
	elgg_require_js('market');

	//Widget
	elgg_register_widget_type('market', elgg_echo('market:widget'), elgg_echo('market:widget:description'));

	//Notifications
	elgg_register_notification_event('object', 'market', array('create'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'market_notify_message');

	//Cron job
	elgg_register_plugin_hook_handler('cron', 'daily', 'market_expire_cron_hook');
	
	//Likes
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:market', 'Elgg\Values::getTrue');
}

function market_entity_url_handler($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);
	if (elgg_instanceof($entity, 'object', 'market')) {
		$friendly = elgg_get_friendly_title($entity->title);
		return elgg_normalize_url("market/view/$entity->guid/$friendly");
	}
}

function market_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "market/owned/{$params['entity']->username}";
		$item = new ElggMenuItem('market', elgg_echo('market'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->market_enable != "no") {
			$url = "market/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('market', elgg_echo('market:group'), $url);
			$return[] = $item;
		}
	}
	return $return;

}

// Cron function to delete old market posts
function market_expire_cron_hook($hook, $entity_type, $returnvalue, $params) {

	$market_ttl = elgg_get_plugin_setting('market_expire','market');
	if ($market_ttl == 0) {
		return true;
	}
	$time_limit = strtotime("-$market_ttl months");

	$ret = elgg_set_ignore_access(TRUE);
	
	$entities = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => 'market',
					'created_time_upper' => $time_limit,
					));

	foreach ($entities as $entity) {
		$date = date('j/n-Y', $entity->time_created);
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		notify_user($owner->guid,
				elgg_get_site_entity()->guid,
				elgg_echo('market:expire:subject', array(), $owner->language),
				elgg_echo('market:expire:body', array($owner->name, $title, $date, $market_ttl), $owner->language),
				array(
				'object' => $entity,
				'action' => 'delete',
			   ),
				'site');
		// Delete market post incl. pictures
		market_delete_post($entity);
	}
	
	$ret = elgg_set_ignore_access(FALSE);
	
}

function market_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (elgg_instanceof($entity, 'object', 'market')) {
		$description = elgg_get_excerpt($entity->description);
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$market_type = elgg_echo("market:type:{$entity->market_type}");

		return elgg_echo('market:notification', array(
			$owner->name,
			$market_type,
			$title,
			$description,
			$entity->getURL()
		));
	}
	return null;
}
