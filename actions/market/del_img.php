<?php 

$guid = get_input('guid');

$image = get_entity($guid);

if (!$image instanceof ElggFile || !$image->canEdit()) {
	register_error(elgg_echo('market:image:invalid'));
}

$entity = get_entity($image->container_guid);

if($image->delete()){
  remove_entity_relationship($image->guid, 'attached', $entity->guid);
  system_message(elgg_echo('market:image:deleted'));
}

// if the deleted image is the cover image then replace the image
if($entity->cover_img == $guid){
  $options = [
  	'relationship' => 'attached',
  	'relationship_guid' => $entity->guid,
  	'inverse_relationship' => true,
  	'metadata_name_value_pairs' => [
  		'name' => 'simpletype', 'value' => 'image',
  	],
  	'limit' => 1,
  ];
  $images = elgg_get_entities($options);
  $entity->cover_img = $images[0]->guid;
  $entity->save();
}

forward(REFERRER);
 ?>