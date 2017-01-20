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
$entity = elgg_extract('entity', $vars);
$filter_context = elgg_extract('filter_context', $vars, 'edit');
$guid = $entity->guid;

$tabs = array(
		'edit' => array(
			'text' => elgg_echo('market:edit'),
			'title' => elgg_echo('market:edit:title'),
			'href' => (isset($vars['edit_link'])) ? $vars['edit_link'] : "market/edit/$guid",
			'selected' => ($filter_context == 'edit'),
			'priority' => 100,
		),
);

foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}

echo elgg_view_menu('filter', [
	'sort_by' => 'priority',
	'entity' => $entity,
	'filter_context' => $filter_context,
]);
