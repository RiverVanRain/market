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

elgg_register_title_button('market', 'add', 'object', 'market');

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

$category = $entity->marketcategory;

if($category){
	elgg_push_breadcrumb(urldecode($category), elgg_generate_url('category:object:market', [
		'category' => urlencode($category),
	]));
}

elgg_push_breadcrumb($entity->getDisplayName(), $entity->getURL());

$content = elgg_view_entity($entity, [
	'full_view' => true,
	'show_responses' => true,
]);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => 'market/view',
	'entity' => $entity,
], 'default', [
	'entity' => $entity,
]);
