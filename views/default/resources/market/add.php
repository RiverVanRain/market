<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

$guid = (int) elgg_extract('guid', $vars);
if (!$guid) {
	$guid = elgg_get_logged_in_user_guid();
}

elgg_entity_gatekeeper($guid);

$container = get_entity($guid);

if (!$container->canWriteToContainer(0, 'object', \ElggMarket::SUBTYPE)) {
	throw new \Elgg\Exceptions\Http\EntityPermissionsException();
}

if ((bool) elgg_get_plugin_setting('market_adminonly', 'market')) {
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
	throw new \Elgg\Exceptions\Http\EntityPermissionsException(elgg_echo('market:tomany:text'));
}

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE, $container);
elgg_push_breadcrumb(elgg_echo('add:object:market'));
 
$title = elgg_echo('market:add:title');

$form_vars = [
	'enctype' => 'multipart/form-data',
	'prevent_double_submit' => false,
];
$body_vars = market_prepare_form_vars();
$content = elgg_view_form('market/save', $form_vars, $body_vars);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'market/edit',
]);
