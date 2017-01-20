<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2k17
 * @link https://wzm.me
 * @version 2.2
 */
echo elgg_view_module('aside', elgg_echo('market:categories'), elgg_view('market/categories'));

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => 'market',
	'owner_guid' => elgg_get_page_owner_guid(),
));

echo elgg_view('page/elements/tagcloud_block', array(
	'subtypes' => 'market',
	'owner_guid' => elgg_get_page_owner_guid(),
));

