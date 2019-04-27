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
$selected_type = elgg_extract('subpage', $vars);

$namevalue_pairs = [];
$namevalue_pairs[] = ['name' => 'market_type', 'value' => $selected_type, 'operand' => '='];
$namevalue_pairs[] = ['name' => 'status', 'value' => 'open', 'operand' => '='];

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

elgg_register_title_button('market', 'add', 'object', 'market');

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
} 

else {
	elgg_push_breadcrumb(elgg_echo("market:type:{$selected_type}"), "market/all/{$selected_type}");
	$title = elgg_echo("market:type:{$selected_type}");
	$options['metadata_name_value_pairs'] = $namevalue_pairs;
	$filter_context = $selected_type;
}

$content = elgg_list_entities($options);

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => elgg_view('filters/market/all', [
		'filter_context' => $filter_context,
	])
]);

echo elgg_view_page($title, $layout);