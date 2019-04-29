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
// start a new sticky form session in case of failure
elgg_make_sticky_form('market');

$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = (int) get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if ($entity instanceof \ElggMarket && $entity->canEdit()) {
		$post = $entity;
	} else {
		return elgg_error_response(elgg_echo('market:error:post_not_found'));
	}
}

else {
	$post = new \ElggMarket();
	$new_post = true;
}

// set defaults and required values.
$values = [
	'title' => '',
	'description' => '',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'Off',
	'tags' => '',
	'marketcategory' => '',
	'market_type' => '',
	'location' => '',
	'custom' => '',
	'price' => '',
	'container_guid' => (int) get_input('container_guid'),
];

// fail if a required entity isn't set
$required = ['title', 'description', 'market_type'];

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'title') {
		$value = elgg_get_title_input();
	} else {
		$value = get_input($name, $default);
	}

	if (in_array($name, $required) && empty($value)) {
		return elgg_error_response(elgg_echo("market:error:missing:{$name}"));
	}

	switch ($name) {
		case 'tags':
			$values[$name] = string_to_tag_array($value);
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				$container = get_entity($value);
				if ($container && $container->canWriteToContainer(0, 'object', \ElggMarket::SUBTYPE)) {
					$values[$name] = $value;
				} else {
					return elgg_error_response(elgg_echo('market:error:cannot_write_to_container'));
				}
			} else {
				unset($values[$name]);
			}
			break;

		default:
			$values[$name] = $value;
			break;
	}
}

// assign values to the entity
foreach ($values as $name => $value) {
	$post->$name = $value;
}

if (!$post->save()) {
	return elgg_error_response(elgg_echo('market:error:cannot_save'));
}

// handle icon upload
$post->saveIconFromUploadedFile('icon');

$upload_guids = (array) get_input('upload_guids', []);
if ($upload_guids) {
	foreach ($upload_guids as $upload_guid) {
		$upload = get_entity($upload_guid);
		if (!$upload instanceof ElggFile || !$upload->canEdit()) {
			continue;
		}
		$upload->origin = 'market';
		$upload->container_guid = $post->container_guid;
		$upload->access_id = $post->access_id;
		if ($upload->save()) {
			$uploads[] = $upload;
			add_entity_relationship($upload->guid, 'attached', $post->guid);
		}
	}
}

// remove sticky form entries
elgg_clear_sticky_form('market');

if ($new_post) {
	$post->status = 'open';
	
	elgg_create_river_item([
		'view' => 'river/object/market/create',
		'action_type' => 'create',
		'subject_guid' => $user->guid,
		'object_guid' => $post->guid,
	]);

	elgg_trigger_event('publish', 'object', $post);
}

else {
	elgg_create_river_item([
		'view' => 'river/object/market/update',
		'action_type' => 'update',
		'subject_guid' => $user->guid,
		'object_guid' => $post->guid,
	]);			
}

return elgg_ok_response('', elgg_echo('market:posted'), $post->getURL());