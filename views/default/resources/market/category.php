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
$selected_cat = elgg_extract('cat', $vars);

$namevalue_pairs = array();
$namevalue_pairs[] = array('name' => 'marketcategory', 'value' => $selected_cat, 'operand' => '=');

elgg_register_title_button();

$title = elgg_echo('market:category:title', array(elgg_echo("market:category:{$selected_cat}")));

$options = array(
	'types' => 'object',
	'subtypes' => 'market',
	'full_view' => false,
	'pagination' => true,
	'list_type_toggle' => false,
	'item_class' => 'market-item-list',
	'no_results' => elgg_echo('market:none:found'),
	'metadata_name_value_pairs' => $namevalue_pairs,
);

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
elgg_push_breadcrumb(elgg_echo("market:category:{$selected_cat}"), "market/category/{$selected_cat}");

$content = elgg_list_entities($options);

if (elgg_is_xhr()) {
	echo $content;
} else {
	$layout = elgg_view_layout('content', [
		'title' => $title,
		'content' => $content,
		'filter' => elgg_view('filters/market/category', [
			'filter_context' => $selected_cat,
		])
	]);
	echo elgg_view_page($title, $layout);
}