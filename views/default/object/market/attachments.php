<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$entity = elgg_extract('entity', $vars);

// Show images first
$options = [
	'relationship' => 'attached',
	'relationship_guid' => $entity->guid,
	'inverse_relationship' => true,
	'metadata_name_value_pairs' => [
		'name' => 'simpletype', 'value' => 'image',
	],
	'count' => true,
	'limit' => 0,
];
$count = elgg_get_entities($options);

$image_guids = [ELGG_ENTITIES_NO_VALUE];

if ($count) {
	unset($options['count']);
	$images = elgg_get_entities($options);

	echo '<ul class="market-attachments" rel="market-popup-'.$entity->guid.'">';
	
	$image_size = elgg_get_plugin_setting('image_size', 'market');
	
	foreach ($images as $image) {
		$image_guids[] = $image->guid;
		echo '<li class="elgg-item">';
		$image_params = [
			'alt' => $image->getDisplayName(),
			'src' => $image->getIconURL(['size' => $image_size]),
		];
		$icon = elgg_view('output/img', $image_params);
		echo elgg_view('output/url', [
			'text' => $icon,
			'href' => $image->getIconURL('large'),
			'class' => 'elgg-lightbox-photo',
			'rel' => 'market-gallery',
		]);
		echo '</li>';
	}
	echo '</ul>';
}

elgg_pop_context();
