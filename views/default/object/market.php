<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2017
 * @link https://wzm.me
 * @version 3.0
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
}

else {
	// brief view
	$params = [
		'content' => elgg_view('object/market/meta', $vars),
		'icon' => elgg_view_entity_icon(get_entity($entity->owner_guid), 'small'),
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}