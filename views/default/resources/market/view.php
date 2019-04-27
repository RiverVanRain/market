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
$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', \ElggMarket::SUBTYPE);

$entity = get_entity($guid);

elgg_set_page_owner_guid($entity->container_guid);

elgg_register_title_button('market', 'add', 'object', 'market');

elgg_push_collection_breadcrumbs('object', \ElggMarket::SUBTYPE);

$category = $entity->marketcategory;

if($category){
	$name = urldecode($category);
	$link = urlencode($category);
	elgg_push_breadcrumb($name, "market/category/{$link}");
}

elgg_push_breadcrumb($entity->getDisplayName(), $entity->getURL());

$title = $entity->getDisplayName();

elgg_push_context('market/view');

$content = elgg_view_entity($entity, [
	'full_view' => true,
]);

if ($entity->comments_on == 'On') {
	$content .= elgg_view_comments($entity);
}

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => false,
]);

echo elgg_view_page($title, $layout);