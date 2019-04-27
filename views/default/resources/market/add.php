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

$guid = elgg_extract('guid', $vars);
if (!$guid) {
	$guid = elgg_get_logged_in_user_guid();
}

elgg_entity_gatekeeper($guid);

$container = get_entity($guid);

if (!$container->canWriteToContainer(0, 'object', \ElggMarket::SUBTYPE)) {
	throw new \Elgg\EntityPermissionsException();
}

if (elgg_get_plugin_setting('market_adminonly', 'market') == 1) {
	elgg_admin_gatekeeper();
}

// How many classifieds can a user have
$marketmax = elgg_get_plugin_setting('market_max', 'market');

$marketactive = elgg_get_entities([
	'type' => 'object',
	'subtype' => \ElggMarket::SUBTYPE,
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'count' => true
]);

if ($marketmax != 0 && $marketactive >= $marketmax && !elgg_is_admin_logged_in()) {
	register_error(elgg_echo('market:tomany:text'));
	forward(REFERER);
}

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE, $container);
elgg_push_breadcrumb(elgg_echo('add:object:market'));
 
$title = elgg_echo('market:add:title');

$form_vars = [
	'name' => 'marketForm',
	'enctype' => 'multipart/form-data'
];
$body_vars = market_prepare_form_vars();
$content = elgg_view_form('market/save', $form_vars, $body_vars);

$params = [
	'content' => $content,
	'title' => $title,
];

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
