<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

$defaults = [
	'type' => 'object',
	'subtype' => 'market',
	'full_view' => false,
	'distinct' => false,
	'pagination' => false,
];

$options = (array) elgg_extract('options', $vars, []);
$options = array_merge($defaults, $options);

if ($status = elgg_extract('status', $vars)) {
	$options['metadata_name_value_pairs']['status'] = $status;
}

echo elgg_list_entities($options);
