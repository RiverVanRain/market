<?php 

$guid = get_input('guid');
$image = get_entity($guid);

if (!$image instanceof ElggFile || !$image->canEdit()) {
	register_error(elgg_echo('market:image:invalid'));
}

$entity = get_entity($image->container_guid);

$entity->cover_img = $image->guid;
if($entity->save()){
  system_message('market:icon:upload:update');
}

forward(REFERRER);
 ?>