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
$guid = $vars['guid'];
$size =  $vars['size'];
$class = $vars['class'];
$imagenum = $vars['imagenum'];
$tu = $vars['tu'];

echo elgg_view('output/img', array(
		'src' => elgg_get_site_url() . "market/image/{$guid}/{$imagenum}/{$size}/{$tu}",
		'class' => "elgg-photo $class",
		'alt' => $imagenum,
	));