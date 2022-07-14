<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new \Elgg\Exceptions\Http\EntityNotFoundException();
}

$selected_type = elgg_extract('subpage', $vars);

$namevalue_pairs = [];
$namevalue_pairs[] = ['name' => 'market_type', 'value' => $selected_type, 'operand' => '='];
$namevalue_pairs[] = ['name' => 'status', 'value' => 'open', 'operand' => '='];

elgg_push_collection_breadcrumbs('object', 'market', $user);

elgg_register_title_button('market', 'add', 'object', 'market');

$title = elgg_echo('collection:object:market:owner', [$user->getDisplayName()]);

$options = [
	'type' => 'object',
	'subtype' => \ElggMarket::SUBTYPE,
	'owner_guid' => (int) $user->guid,
	'full_view' => false,
	'pagination' => true,
	'no_results' => elgg_echo('market:none:found'),
	'list_type_toggle' => false,
	'item_class' => 'market-item-list',
	'metadata_name_value_pairs' => [
		'name' => 'status',
		'value' => 'open',
		'operand' => '=',
	],
];

// Get a list of market posts in a specific category
if (!$selected_type || $selected_type == 'all') {
	$filter_context = 'all';
} else {
	elgg_push_breadcrumb(elgg_echo("market:type:{$selected_type}"), "market/owner/{$username}/{$selected_type}");
	$title .= ' - ' . elgg_echo("market:type:{$selected_type}");
	$options['metadata_name_value_pairs'] = $namevalue_pairs;
	$filter_context = $selected_type;
}

$content = elgg_list_entities($options);

echo elgg_view_page($title, [
	'content' => $content,
	'filter_id' => 'market/owner',
	'filter_value' => $filter_context,
	'filter_entity' => $user,
]);

