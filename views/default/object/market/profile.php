<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \ElggMarket) {
	return;
}

//summary
echo elgg_view('object/market/meta', $vars);

//images
$attachments = $entity->formatAttachments();

if ($attachments) {
	echo elgg_format_element('div', ['class' => 'mtm'], $attachments);
}

//buttons
$mark_status = false;

if ($entity->owner_guid == elgg_get_logged_in_user_guid() || $entity->canEdit()) {
	if($entity->status != 'sold'){
		$href = elgg_generate_action_url('market/sold', [
			'guid' => $entity->guid,
		]);
		$text = elgg_echo('market:mark:sold');
	}
	else {
		$href = elgg_generate_action_url('market/open', [
			'guid' => $entity->guid,
		]);
		$text = elgg_echo('market:mark:open', [$entity->market_type]);
	}
	
	$mark_status = elgg_view('output/url', [
		'class' => 'elgg-button elgg-button-action mrs',
		'href' => $href,
		'text' => $text,
		'is_action' => true,
	]);
}

$send_message = false;

if ((bool) elgg_get_plugin_setting('market_pmbutton', 'market')) {
	if ($entity->owner_guid != elgg_get_logged_in_user_guid() && $entity->status != 'sold' && elgg_is_active_plugin('messages')) {
		$send_message = elgg_view('output/url', [
			'href' => elgg_generate_url('add:object:messages', [
				'guid' => $entity->owner_guid,
			]),
			'text' => elgg_echo('market:pmbuttontext'),
			'class' => 'elgg-button elgg-button-action',
		]);
	}
}

echo elgg_format_element('div', ['class' => 'market-buttons'], $mark_status . $send_message);

//description
if (!(bool) elgg_get_plugin_setting('market_allowhtml', 'market')) {
	$description = elgg_html_decode($entity->description);
} else {
	$description = elgg_view('output/longtext', [
		'value' => $entity->description
	]);
}

echo elgg_format_element('div', ['class' => 'market-description'], $description);
