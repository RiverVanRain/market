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
	
	$container = get_entity($post->container_guid);

	// Delete the market post
	$post->status = 'sold';
	$post->save();
	
	// Success message
	system_message(elgg_echo("Item marked as sold!"));
	
		if (elgg_instanceof($container, 'group')) {
			forward("market/group/$container->guid/all");
		} else {
			forward("market/view/$guid/$container->title");
		}
} else {
	register_error(elgg_echo('market:none:found'));
}

forward(REFERER);