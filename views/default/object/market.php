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

$entity = elgg_extract('entity', $vars);

if (!elgg_instanceof($entity, 'object', 'market')) {
	return;
}

$full = elgg_extract('full_view', $vars);
if ($full) {
	$fullview_icon = elgg_view_entity_icon(get_entity($entity->owner_guid), 'small');
	echo elgg_view('object/elements/summary', [
		'icon' => $fullview_icon,
		'entity' => $entity,
	]);
	echo "<p>".elgg_view('object/market/profile', $vars)."</p>";
	return;
}

$currency = elgg_get_plugin_setting('market_currency', 'market');

$tu = $entity->time_updated;

$title = elgg_view('output/url', [
	'text' => $entity->getDisplayName(),
	'href' => $entity->getURL(),
		]);

// if (!elgg_in_context('widgets')) {
// 	$metadata = elgg_view_menu('entity', [
// 		'entity' => $entity,
// 		'sort_by' => 'priority',
// 		'class' => 'elgg-menu-hz',
// 		'handler' => 'market',
// 	]);
// }

$subtitle = elgg_view('object/market/meta', $vars);

if (elgg_in_context('gallery')) {
	$icon = elgg_view_entity_icon($entity, 'large');
	echo elgg_view_module('aside', $title, $icon . $subtitle, [
		// 'footer' => $metadata
	]);
} else {

	$icon = elgg_view_entity_icon($entity, 'medium');
	$summary = elgg_view('object/elements/summary', [
		'entity' => $entity,
		'title' => $title,
		'subtitle' => $subtitle,
		// 'metadata' => $metadata,
		'content' => $description,
	]);
	
	$img = elgg_view('output/img', array(
				'src' => "market/image/{$entity->guid}/1/medium/{$tu}",
				'class' => 'market-image-list',
				'alt' => $entity->guid,
				));
	$market_img = elgg_view('output/url', array(
			'href' => "market/view/{$entity->guid}/" . elgg_get_friendly_title($entity->title),
			'text' => $img,
			));

	if ($full) {
		echo elgg_view('object/elements/full', [
			'icon' => $icon,
			'entity' => $entity,
			'summary' => $summary,
		]);
	} else {
		echo elgg_view_image_block($market_img, $summary);
	}
}