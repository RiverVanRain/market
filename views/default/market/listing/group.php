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
	'container_guids' => (int) $entity->guid,
	'preload_containers' => false,
];

echo elgg_view('market/listing/all', $vars);
