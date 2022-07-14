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

if (elgg_extract('full_view', $vars)) {
	$body = elgg_view('object/market/profile', $vars);

	$params = [
		'icon' => elgg_view_entity_icon(get_entity($entity->owner_guid), 'small'),
		'body' => $body,
		'show_summary' => true,
		'show_navigation' => true,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
} else {
	// brief view
	$params = [
		'content' => elgg_view('object/market/meta', $vars),
		'icon' => elgg_view_entity_icon(get_entity($entity->owner_guid), 'small'),
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}