<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
elgg_gatekeeper();

if (!(bool) elgg_get_plugin_setting('market_terms_enable', 'market')) {
	return;
}

$title = elgg_format_element('h3', ['class' => 'modal-title'], elgg_echo('market:terms:title'));
echo elgg_format_element('div', ['class' => 'modal-header'], $title);

echo elgg_format_element('div', ['class' => 'ui-front'], elgg_view('output/longtext', [
	'value' => elgg_get_plugin_setting('market_terms', 'market'),
]));
