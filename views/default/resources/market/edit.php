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
$entity = get_entity($guid);

if (!$entity || !elgg_instanceof($entity, 'object', 'market')) {
	forward('', '404');
}

if (!$entity->canEdit()) {
	register_error(elgg_echo('noaccess'));
	forward('', '403');
}

elgg_push_breadcrumb(elgg_echo('market:title'), 'market/all');
elgg_push_breadcrumb($entity->title, $entity->getURL());
elgg_push_breadcrumb(elgg_echo('market:edit'));

$title = elgg_echo('market:edit');
$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
$body_vars = market_prepare_form_vars($entity);
$content = elgg_view_form("market/save", $form_vars, $body_vars);

$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => elgg_view('filters/market/edit', [
			'filter_context' => 'edit',
			'entity' => $entity,
		]),
		);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
