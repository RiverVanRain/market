<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

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