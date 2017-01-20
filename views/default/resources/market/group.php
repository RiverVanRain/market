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

elgg_group_gatekeeper();

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('', '404');
}

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
elgg_push_breadcrumb($owner->name, $owner->getUrl());

elgg_register_title_button('market', 'add', 'object', 'market');

$title = sprintf(elgg_echo('market:user:title'),$owner->name);

$content = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'market',
		'container_guid' => $owner->guid,
		'full_view' => false,
		'pagination' => true,
		'no_results' => elgg_echo('market:none:found'),
		'list_type_toggle' => false,
	));

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
