<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \ElggMarket) {
	return;
}

//cover icon
$cover_icon = elgg_view('output/url', [
	'text' => elgg_view('output/img', [
		'alt' => $entity->getDisplayName(),
		'src' => $entity->getIconURL(['size' => 'medium']),
	]),
	'href' => $entity->getIconURL(['size' => 'large']),
	'class' => 'elgg-lightbox-photo',
]);

//metadata
$meta = '';

//category
if ($entity->marketcategory){
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:category'));
	$meta .= elgg_format_element('div', [], $label . elgg_view('output/url', [
		'text' => urldecode($entity->marketcategory),
		'href' => elgg_generate_url('category:object:market', [
			'category' => urlencode($entity->marketcategory),
		]),
	]));
}

//type
$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:type'));
$meta .= elgg_format_element('div', [], $label . elgg_echo("market:type:{$entity->market_type}"));
	
//custom choices
if ((bool) elgg_get_plugin_setting('market_custom', 'market') && $entity->custom) {
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:custom:text'));
	$meta .= elgg_format_element('div', [], $label . urldecode($entity->custom));
}

//location
if ((bool) elgg_get_plugin_setting('location', 'market') && $entity->location) {
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:location'));
	$meta .= elgg_format_element('div', [], $label . elgg_view('output/location', [
		'value' => $entity->location,
	]));
}

//price
$currency = elgg_get_plugin_setting('market_currency', 'market');
$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:price'));
$meta .= elgg_format_element('div', [], $label . $currency . $entity->price);

echo elgg_view_image_block($cover_icon, $meta, []);
