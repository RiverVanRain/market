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
$selected_category = get_input('category');

$categories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));

if (empty($categories)) {
	echo elgg_echo('market:none:found');
}

echo '<ul class="elgg-menu elgg-menu-page market-category-menu">';
	
foreach ($categories as $category) {
	$class = '';
	if ($selected_category == urlencode($category) || $selected_category == $category) {
		$class = 'selected';
	}
	echo elgg_format_element('li', [], elgg_view('output/url', [
		'href' => 'market/category/' . urlencode($category),
		'text' => $category,
		'class' => $class,
	]));
}

echo '</ul>';
