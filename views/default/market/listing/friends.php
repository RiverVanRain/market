<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'relationship' => 'market',
	'relationship_guid' => (int) $entity->guid,
	'relationship_join_on' => 'owner_guid',
];

echo elgg_view('market/listing/all', $vars);
