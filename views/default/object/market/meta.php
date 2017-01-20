<?php

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars, false);

if (!elgg_instanceof($entity, 'object', 'market')) {
	return;
}

$currency = elgg_get_plugin_setting('market_currency', 'market');
$excerpt = elgg_get_excerpt($entity->description);

$owner = $entity->getOwnerEntity();
$container = $entity->getContainerEntity();
$vars['owner_url'] = "market/owned/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

$meta[] = $by_line;
$meta[] = '<strong>'.elgg_echo('market:category').'</strong>: ' .elgg_echo("market:category:{$entity->marketcategory}");
$meta[] = '<strong>'.elgg_echo('market:type') .'</strong>: ' .elgg_echo("market:type:{$entity->market_type}");

if ((elgg_get_plugin_setting('market_custom', 'market') == 'yes') && $entity->custom) {
$meta[] = '<strong>'.elgg_echo('market:custom:text') .'</strong>: ' .elgg_echo($entity->custom);
}

if ((elgg_get_plugin_setting('location', 'market') == 'yes') && $entity->location) {
	$meta[] = '<strong>'.elgg_echo('market:location') .'</strong>: ' .elgg_view('output/location', [
		'value' => $entity->location,
	]);
}

$meta[] = '<strong>'.elgg_echo('market:price') .'</strong>: ' .$currency .$entity->price;

$meta[] = elgg_format_element('div', [
	'class' => 'market-accepts'
		], elgg_view('object/market/meta/accepts', $vars));
		
if ($entity->tags && $full) {
$meta[] = elgg_view('output/tags', [
		'tags' => $entity->tags,
	]);
}
	
echo implode('', array_map(function($elem) {
			return "<div class=\"market-meta\">$elem</div>";
		}, $meta));

		
if ($entity->description && !$full) {
	echo elgg_view('output/longtext', [
		'value' => $excerpt,
	]);
}