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

echo elgg_echo('market:tomany:text');

echo elgg_view('output/url', array(
		'href' => "market/terms",
		'text' => elgg_echo('market:terms:title'),
		'class' => "elgg-lightbox",
	));