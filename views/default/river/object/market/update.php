<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$item = elgg_extract('item', $vars);
if (!$item instanceof \ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
if (!$object instanceof \ElggMarket) {
	return;
}

$vars['message'] = elgg_view('object/market/meta', ['entity' => $object]);

echo elgg_view('river/elements/layout', $vars);
