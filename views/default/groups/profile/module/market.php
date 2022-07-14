<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$params = [
	'entity_type' => 'object',
	'entity_subtype' => \ElggMarket::SUBTYPE,
	'no_results' => elgg_echo('market:none'),
];
$params = $params + $vars;

echo elgg_view('groups/profile/module', $params);