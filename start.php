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

	elgg_register_library('market', elgg_get_plugins_path() . 'market/lib/market.php');
	
	elgg_register_page_handler('market','market_page_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'market_entity_url_handler');
	
	elgg_register_entity_type('object', 'market');

	$item = new ElggMenuItem('market', elgg_echo('market:title'), 'market/all');
	elgg_register_menu_item('site', $item);

	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'market_owner_block_menu');
	elgg_extend_view('page/elements/sidebar', 'market/sidebar', 100);
	
	//Groups
	add_group_tool_option('market', elgg_echo('market:enablemarket'), true);
	elgg_extend_view('groups/tool_latest', 'market/group_module');

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

	//Actions
	elgg_register_action('market/save', __DIR__ . '/actions/save.php');
	elgg_register_action('market/delete', __DIR__ . '/actions/delete.php');
	elgg_register_action('market/delete_img', __DIR__ . '/actions/delete_img.php');
	
	//Likes
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:market', 'Elgg\Values::getTrue');
}

function market_page_handler($segments, $identifier) {
	$page = array_shift($segments);

	switch ($page) {
		default :
		case 'all' :
			echo elgg_view('resources/market/all', [
				'type' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;
			
		case 'category' :
			echo elgg_view('resources/market/category', [
				'cat' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;

		case 'add' :
			echo elgg_view('resources/market/add', [
				'container_guid' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;

		case 'edit' :
			echo elgg_view('resources/market/edit', [
				'guid' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;
		
		case 'owned':
		    echo elgg_view('resources/market/owned', [
				'username' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;
			
		case 'group':
		    echo elgg_view('resources/market/group', [
				'group_guid' => $segments[0],
				'subpage' => $segments[1],
				'lower' => $segments[2],
				'upper' => $segments[3],
				'identifier' => $identifier,
			]);
			return true;

		case 'view' :
			echo elgg_view('resources/market/view', [
				'guid' => $segments[0],
				'identifier' => $identifier,
			]);
			return true;
			
		case 'image':
		    echo elgg_view('resources/market/image', [
				'guid' => $segments[0],
				'imagenum' => $segments[1],
				'size' => $segments[2],
				'tu' => $segments[3],
				'identifier' => $identifier,
			]);
			return true;
			
		case 'terms' :
			echo elgg_view('resources/market/terms', [
				'identifier' => $identifier,
			]);
			return true;
	}

	return false;
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
	elgg_load_library('market');

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
