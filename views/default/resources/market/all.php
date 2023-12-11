<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$selected_type = elgg_extract('subpage', $vars);

$namevalue_pairs = [];
$namevalue_pairs[] = ['name' => 'market_type', 'value' => $selected_type, 'operand' => '='];
$namevalue_pairs[] = ['name' => 'status', 'value' => 'open', 'operand' => '='];

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

elgg_register_title_button('add', 'object', 'market');

$options = [
	'types' => 'object',
	'subtypes' => \ElggMarket::SUBTYPE,
	'full_view' => false,
	'pagination' => true,
	'list_type_toggle' => false,
	'item_class' => 'market-item-list',
	'no_results' => elgg_echo('market:none:found'),
	'metadata_name_value_pairs' => [
		'name' => 'status',
		'value' => 'open',
		'operand' => '=',
	],
];

// Get a list of market posts in a specific category
if (!$selected_type || $selected_type == 'all') {
	$title = elgg_echo('market:type:all');
	$filter_context = 'all';
} else {
	elgg_push_breadcrumb(elgg_echo("market:type:{$selected_type}"), "market/all/{$selected_type}");
	$title = elgg_echo("market:type:{$selected_type}");
	$options['metadata_name_value_pairs'] = $namevalue_pairs;
	$filter_context = $selected_type;
}

$content = elgg_list_entities($options);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'market/all',
	'filter_value' => $filter_context,
]);
