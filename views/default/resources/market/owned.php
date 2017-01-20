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
$owner_name = elgg_extract('username', $vars);
$owner = get_user_by_username($owner_name);

if (!$owner) {
	forward('', '404');
}

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
elgg_push_breadcrumb($owner->name, $owner->getUrl());

elgg_register_title_button();

//set market title
if ($owner->guid == elgg_get_logged_in_user_guid()) {
	$title = elgg_echo('market:mine:title');
} else {
	$title = sprintf(elgg_echo('market:user:title'),$owner->name);
}
		
// Get a list of market posts
$content = elgg_list_entities(array(
				'type' => 'object',
				'subtype' => 'market',
				'owner_guid' => $owner->guid,
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
