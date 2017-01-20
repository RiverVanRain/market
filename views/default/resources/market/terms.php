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
elgg_gatekeeper();

$title = elgg_echo('market:terms:title');

// How long does a classifieds live
$market_expire = elgg_get_plugin_setting('market_expire', 'market');

$result = '<div><h3>'.$title.'</h3></div>';

$result .= '<div>'. elgg_echo('market:terms', array($market_expire)) .'</div>';

$content = elgg_format_element('div', ['class' => 'ui-front'], $result);

if (elgg_is_xhr()) {
	echo $content;
} else {
	$layout = elgg_view_layout('one_content', [
		'title' => $title,
		'content' => $content,
		'filter' => false,
	]);
	echo elgg_view_page($title, $layout);
}