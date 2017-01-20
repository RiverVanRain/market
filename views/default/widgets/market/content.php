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
 
$widget = elgg_extract('entity', $vars);

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'market',
	'owner_guid' => $widget->owner_guid,
	'limit' => $widget->num_display,
	'pagination' => false,
	'distinct' => false,
]);

if (empty($content)) {
	echo elgg_echo('market:none:found');
	return;
}

echo $content;

$more_link = elgg_view('output/url', [
	'href' => 'market/owned/' . $widget->getOwnerEntity()->username,
	'text' => elgg_echo('market:widget:viewall'),
	'is_trusted' => true,
]);
echo "<div class=\"elgg-widget-more\">$more_link</div>";
