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
$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'market', $user, true);

elgg_register_title_button('market', 'add', 'object', 'market');

$title = elgg_echo('collection:friends', [elgg_echo('collection:object:market')]);

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => \ElggMarket::SUBTYPE,
	'relationship' => 'friend',
	'relationship_guid' => (int) $user->guid,
	'relationship_join_on' => 'owner_guid',
	'full_view' => false,
	'pagination' => true,
	'no_results' => elgg_echo('market:none:found'),
	'list_type_toggle' => false,
]);

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => false,
]);

echo elgg_view_page($title, $layout);
