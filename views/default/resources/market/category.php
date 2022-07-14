<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$selected_category = elgg_extract('category', $vars);

elgg_register_title_button('market', 'add', 'object', 'market');

$title = urldecode($selected_category);

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

elgg_push_breadcrumb($title, elgg_generate_url('category:object:market', [
	'category' => urlencode($selected_category),
]));

$options = [
	'types' => 'object',
	'subtypes' => \ElggMarket::SUBTYPE,
	'full_view' => false,
	'pagination' => true,
	'list_type_toggle' => false,
	'item_class' => 'market-item-list',
	'no_results' => elgg_echo('market:none:found'),
	'metadata_name_value_pairs' => [
		'name' => 'marketcategory',
		'value' => $selected_category,
		'operand' => '=',
	],
];

$content = elgg_list_entities($options);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'market/category',
	'filter_value' => $selected_category,
]);
