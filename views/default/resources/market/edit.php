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

$vars['entity'] = $entity;

elgg_push_entity_breadcrumbs($entity);

elgg_register_title_button('add', 'object', 'market');

$form_vars = [
	'enctype' => 'multipart/form-data',
	'sticky_enabled' => true,
];

$content = elgg_view_form('market/save', $form_vars, [
	'entity' => $entity
]);

echo elgg_view_page(elgg_echo('market:edit'), [
	'content' => $content,
	'filter_id' => 'market/edit',
]);