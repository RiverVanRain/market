<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain, Rohit Gupta
 * @copyright slyhne 2010-2015, wZm 2017
 * @link https://wzm.me
 * @version 3.0
 */

$object = $vars['item']->getObjectEntity();

$vars['message'] = elgg_view('object/market/meta', ['entity' => $object]);

echo elgg_view('river/elements/layout', $vars);
