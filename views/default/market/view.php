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
if (is_array($vars['posts']) && sizeof($vars['posts']) > 0) {
	foreach($vars['posts'] as $post) {
		echo elgg_view_entity($post);	
	}
}


