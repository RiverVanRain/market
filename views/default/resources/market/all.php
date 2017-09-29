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
$selected_type = elgg_extract('type', $vars);

$namevalue_pairs = array();
$namevalue_pairs[] = array('name' => 'market_type', 'value' => $selected_type, 'operand' => '=');
$namevalue_pairs[] = array('name' => 'status', 'value' => 'open', 'operand' => '=');

elgg_register_title_button();


$options = array(
	'types' => 'object',
	'subtypes' => 'market',
	'full_view' => false,
	'pagination' => true,
	'list_type_toggle' => false,
	'item_class' => 'market-item-list',
	'no_results' => elgg_echo('market:none:found'),
	'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'open', 'operand' => '='),
);

// Get a list of market posts in a specific category
if (!$selected_type || $selected_type == 'all') {
	$title = elgg_echo('market:type:all');
	$filter_context = 'all';
	$content = elgg_list_entities_from_metadata($options);
} else {
	$title = elgg_echo("market:type:{$selected_type}");
	elgg_push_breadcrumb(elgg_echo('market:title'), "market/all");
	elgg_push_breadcrumb(elgg_echo("market:type:{$selected_type}"), "market/all/{$selected_type}");
	$options['metadata_name_value_pairs'] = $namevalue_pairs;
	$filter_context = $selected_type;
	$content = elgg_list_entities_from_metadata($options);
}

if (elgg_is_xhr()) {
	echo $content;
} else {
	$layout = elgg_view_layout('content', [
		'title' => $title,
		'content' => $content,
		'filter' => elgg_view('filters/market/all', [
			'filter_context' => $filter_context,
		])
	]);
	echo elgg_view_page($title, $layout);
}