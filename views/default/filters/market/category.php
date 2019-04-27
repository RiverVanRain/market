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
$filter_context = elgg_extract('filter_context', $vars);

$tabs = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));

foreach ($tabs as $tab) {
	elgg_register_menu_item('filter', [
		'name' => $tab,
		'text' => $tab,
		'href' => 'market/category/' . urlencode($tab),
		'selected' => $tab == $filter_context,
	]);
}

echo elgg_view_menu('filter', [
	'sort_by' => 'priority',
]);
