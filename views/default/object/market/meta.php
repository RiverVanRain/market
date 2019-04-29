<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2k17
 * @link https://wzm.me
 * @version 3.0
 */
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \ElggMarket) {
	return;
}

//cover icon
if($entity->cover_img == null){
	$cov_img = $entity;
} else {
	$cov_img = get_entity($entity->cover_img);
}
$image_params = [
	'alt' => $entity->getDisplayName(),
	'src' => $cov_img->getIconURL(['size' => 'medium']),
];

$image = elgg_view('output/img', $image_params);
$cover_icon = elgg_view('output/url', [
	'text' => $image,
	'href' => $cov_img->getIconURL(['size' => 'large']),
	'class' => 'elgg-lightbox-photo',
]);

//metadata
$meta = '';

//category
if ($entity->marketcategory){
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:category'));
	$href = urlencode($entity->marketcategory);
	$meta .= elgg_format_element('div', [], $label . elgg_view('output/url', [
		'text' => urldecode($entity->marketcategory),
		'href' => "market/category/{$href}",
	]));
}

//type
$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:type'));
$meta .= elgg_format_element('div', [], $label . elgg_echo("market:type:{$entity->market_type}"));
	
//custom choices
if ((elgg_get_plugin_setting('market_custom', 'market') == 1) && $entity->custom) {
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:custom:text'));
	$meta .= elgg_format_element('div', [], $label . urldecode($entity->custom));
}

//location
if ((elgg_get_plugin_setting('location', 'market') == 1) && $entity->location) {
	$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:location'));
	$meta .= elgg_format_element('div', [], $label . elgg_view('output/location', [
		'value' => $entity->location,
	]));
}

//price
$currency = elgg_get_plugin_setting('market_currency', 'market');
$label = elgg_format_element('strong', ['class' => 'mrs'], elgg_echo('market:price'));
$meta .= elgg_format_element('div', [], $label . $currency . $entity->price);
	
//tags
if ($entity->tags) {
	$meta .= elgg_format_element('div', [], elgg_view('output/tags', [
		'tags' => $entity->tags,
	]));
}

echo elgg_view_image_block($cover_icon, $meta, []);
