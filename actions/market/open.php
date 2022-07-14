<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
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
	} else {
		return elgg_error_response(elgg_echo('market:none:found'));
	}
}
