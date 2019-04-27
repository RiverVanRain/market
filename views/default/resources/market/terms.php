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
elgg_gatekeeper();

if (elgg_get_plugin_setting('market_terms_enable', 'market') == 0) {
	forward(REFERER);
}

$title = elgg_echo('market:terms:title');

$terms = elgg_get_plugin_setting('market_terms', 'market');

$content = elgg_format_element('div', ['class' => 'ui-front'], elgg_view('output/longtext', [
	'value' => $terms,
]));

if (elgg_is_xhr()) {
	$title = elgg_format_element('h3', ['class' => 'modal-title'], $title);
	echo elgg_format_element('div', ['class' => 'modal-header'], $title);
	echo $content;
}

else {
	elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);
	
	elgg_register_title_button('market', 'add', 'object', 'market');

	$layout = elgg_view_layout('content', [
		'title' => $title,
		'content' => $content,
		'filter' => false,
	]);
	
	echo elgg_view_page($title, $layout);
}