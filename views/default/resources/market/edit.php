<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \ElggMarket::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\Exceptions\Http\EntityPermissionsException();
}

elgg_push_entity_breadcrumbs($entity);
elgg_push_breadcrumb(elgg_echo('edit'));

elgg_register_title_button('market', 'add', 'object', 'market');

$title = elgg_echo('market:edit');
$form_vars = [
	'enctype' => 'multipart/form-data',
	'prevent_double_submit' => false,
];

$body_vars = market_prepare_form_vars($entity);
$content = elgg_view_form('market/save', $form_vars, $body_vars);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'market/edit',
]);