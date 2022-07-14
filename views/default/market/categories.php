<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$selected_category = get_input('category');

$categories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));

$ul = '';
$li = '';
foreach ($categories as $category) {
	$class = '';
	if ($selected_category == urlencode($category) || $selected_category == $category) {
		$class = 'selected';
	}
	$li .= elgg_format_element('li', [], elgg_view('output/url', [
		'href' => elgg_generate_url('category:object:market', [
			'category' => urlencode($category),
		]),
		'text' => $category,
		'class' => $class,
	]));
}

$ul = elgg_format_element('ul', ['class' => 'elgg-menu elgg-menu-page market-category-menu'], $li);

echo $ul;