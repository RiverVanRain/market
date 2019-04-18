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
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'market');

$entity = get_entity($guid);

elgg_set_page_owner_guid($entity->container_guid);

$category = $entity->marketcategory;

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
if($category){
elgg_push_breadcrumb(elgg_echo("market:category:{$category}"), "market/category/{$category}");
}
elgg_push_breadcrumb($entity->getDisplayName(), $entity->getURL());

$title = $entity->getDisplayName();

elgg_push_context('market/view');

$content = elgg_view_entity($entity, [
	'full_view' => true,
		]);
		
if (elgg_get_plugin_setting('market_comments', 'market') == 'yes') {
	$content .= elgg_view_comments($entity);
}

if (elgg_is_xhr()) {
	echo $content;
} else {
	$layout = elgg_view_layout('content', [
		'title' => $title,
		'content' => $content,
		'filter' => false,
	]);
	echo elgg_view_page($title, $layout);
}