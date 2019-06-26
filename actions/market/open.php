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
$guid = (int) get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if ($entity instanceof \ElggMarket && $entity->canEdit()) {
		$entity->status = 'open';
		$entity->save();
		
		elgg_create_river_item([
			'view' => 'river/object/market/update',
			'action_type' => 'open',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $guid,
		]);
		
		return elgg_ok_response('', elgg_echo('market:action:open'));
	} 
	
	else {
		return elgg_error_response(elgg_echo('market:none:found'));
	}
}
