<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$categories = elgg_string_to_array(elgg_get_plugin_setting('market_categories', 'market', ''));

if (!empty($categories)) {
	echo elgg_view_module('info', elgg_echo('market:categories'), elgg_view('market/categories'));
}

echo elgg_view('page/elements/comments_block', [
	'subtypes' => \ElggMarket::SUBTYPE,
	'container_guid' => elgg_get_page_owner_guid(),
]);

echo elgg_view('page/elements/tagcloud_block', [
	'subtypes' => \ElggMarket::SUBTYPE,
	'container_guid' => elgg_get_page_owner_guid(),
]);