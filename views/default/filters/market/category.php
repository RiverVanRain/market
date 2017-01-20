<?php

$filter_context = elgg_extract('filter_context', $vars);

$tabs = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));

$url = elgg_get_site_url() . 'market/category/';

foreach ($tabs as $tab) {
	elgg_register_menu_item('filter', [
		'name' => $tab,
		'text' => elgg_echo("market:category:$tab"),
		'href' => $url.$tab,
		'selected' => $tab == $filter_context,
	]);
}

echo elgg_view_menu('filter', [
	'sort_by' => 'priority',
]);
