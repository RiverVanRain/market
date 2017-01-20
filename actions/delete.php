<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Get input data
$guid = (int) get_input('guid');
		
// Make sure we actually have permission to edit
$post = get_entity($guid);
if (elgg_instanceof($post, 'object', 'market') && $post->canEdit()) {
	
	elgg_load_library('market');
	
	$container = get_entity($post->container_guid);

	// Delete the market post
	$return = market_delete_post($post);
	if ($return) {
		// Success message
		system_message(elgg_echo("market:deleted"));
		if (elgg_instanceof($container, 'group')) {
			forward("market/group/$container->guid/all");
		} else {
			forward("market/owned/$container->username");
		}
	} else {
		// Error message
		register_error(elgg_echo("market:notdeleted"));
	}
} else {
	register_error(elgg_echo('market:none:found'));
}

forward(REFERER);