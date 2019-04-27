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
$guid = elgg_extract('guid', $vars);
$filter_context = elgg_extract('filter_context', $vars);

$tabs = [
	'all' => "market/group/$guid/all",
	'buy' => "market/group/$guid/buy", 
	'sell' => "market/group/$guid/sell", 
	'swap' => "market/group/$guid/swap", 
	'free' => "market/group/$guid/free", 
];

foreach ($tabs as $tab => $url) {
	elgg_register_menu_item('filter', [
		'name' => $tab,
		'text' => elgg_echo("market:type:$tab"),
		'href' => $url,
		'selected' => $tab == $filter_context,
	]);
}

echo elgg_view_menu('filter', [
	'sort_by' => 'priority',
]);
