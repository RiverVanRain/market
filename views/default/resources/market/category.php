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
$selected_category = elgg_extract('category', $vars);

elgg_register_title_button('market', 'add', 'object', 'market');

$title = urldecode($selected_category);

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

$category = urlencode($selected_category);
elgg_push_breadcrumb($title, "market/category/{$category}");

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

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => elgg_view('filters/market/category', [
		'filter_context' => $selected_category,
	])
]);

echo elgg_view_page($title, $layout);