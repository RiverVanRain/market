<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$username = elgg_extract('username', $vars);

$user = elgg_get_user_by_username($username);
if (!$user) {
	throw new \Elgg\Exceptions\Http\EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'market', $user, true);

elgg_register_title_button('add', 'object', 'market');

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

echo elgg_view_page($title, [
	'content' => $content,
]);
