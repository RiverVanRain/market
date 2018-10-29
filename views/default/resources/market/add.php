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

if (elgg_get_plugin_setting('market_adminonly', 'market') == 'yes') {
	elgg_admin_gatekeeper();
}

// How many classifieds can a user have
$marketmax = elgg_get_plugin_setting('market_max', 'market');
if(!$marketmax) {
	$marketmax = 0;
}

$marketactive = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'market',
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'count' => true
			));

$title = elgg_echo('market:add:title');

// Show form, or error if users has used his quota
if ($marketmax == 0 || elgg_is_admin_logged_in()) {
	$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
	$body_vars = market_prepare_form_vars(NULL);
	$content = elgg_view_form("market/save", $form_vars, $body_vars);
} elseif ($marketmax > $marketactive) {
	$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
	$body_vars = market_prepare_form_vars(NULL);
	$content = elgg_view_form("market/save", $form_vars, $body_vars);
} else {
	$content = elgg_view("market/error");
}

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
elgg_push_breadcrumb(elgg_echo('market:add'));

$params = array(
		'content' => $content,
		'title' => $title,
		);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
