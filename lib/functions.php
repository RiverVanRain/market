<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
 
function market_prepare_form_vars($post = null) {

	// input names => defaults
	$values = [
		'title' => null,
		'description' => null,
		'access_id' => ACCESS_DEFAULT,
		'tags' => null,
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $post,
		'comments_on' => 'Off',
		'price' => null,
		'marketcategory' => null,
		'market_type' => null,
		'location' => null,
		'custom' => null,
	];

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}
	}

	if (elgg_is_sticky_form('market')) {
		$sticky_values = elgg_get_sticky_values('market');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('market');

	return $values;
}

function format_from_bytes($size, $precision = 2) {
	$size = (int) $size;
	if ($size < 0) {
		return false;
	}
	
	$precision = (int) $precision;
	if ($precision < 0) {
		$precision = 2;
	}

	return round($size/1048576, $precision);
}