<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
 
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display ?: 4;

$options = [
	'type' => 'object',
	'subtype' => \ElggMarket::SUBTYPE,
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
];

$owner = $widget->getOwnerEntity();
if ($owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
} else {
	$options['container_guid'] = $widget->owner_guid;
}

$content = elgg_list_entities($options);

if (empty($content)) {
	echo elgg_echo('market:none:found');
	return;
}

echo $content;

if ($owner instanceof \ElggGroup) {
	$url = elgg_generate_url('collection:object:market:group', ['guid' => $owner->guid]);
} else {
	$url = elgg_generate_url('collection:object:market:owner', ['username' => $owner->username]);
}

echo elgg_format_element('div', ['class' => 'elgg-widget-more'], elgg_view_url($url, elgg_echo('market:widget:viewall')));
