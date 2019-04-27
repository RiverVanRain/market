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
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

elgg_push_entity_breadcrumbs($entity);
elgg_push_breadcrumb(elgg_echo('edit'));

elgg_register_title_button('market', 'add', 'object', 'market');

$title = elgg_echo('market:edit');
$form_vars = [
	'name' => 'marketForm',
	'enctype' => 'multipart/form-data'
];

$body_vars = market_prepare_form_vars($entity);
$content = elgg_view_form('market/save', $form_vars, $body_vars);

$params = [
	'content' => $content,
	'title' => $title,
];

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);