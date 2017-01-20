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
$selected_category = get_input('cat');

$categories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));

if (!empty($categories)) {
	$url = elgg_get_site_url() . 'market/category/';
	echo "<ul>";
	foreach ($categories as $category) {
		echo "<li>";
		$selected = '';
		if ($selected_category == $category) {
			$selected = 'selected';
		}
		echo elgg_view('output/url', array(
					'href' => $url . $category,
					'text' => elgg_echo("market:category:$category"),
					'class' => "market-category-menu-item $selected",
					'is_trusted' => true,
					));
		echo "</li>";
	}
	echo "</ul>";
}

