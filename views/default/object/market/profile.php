<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2017
 * @link https://wzm.me
 * @version 3.0
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
if ($entity->owner_guid == elgg_get_logged_in_user_guid() || $entity->canEdit()) {
	if($entity->status != 'sold'){
		$href = 'action/market/sold?guid=' . $entity->guid;
		$text = elgg_echo('market:mark:sold');
	}
	else {
		$href = 'action/market/open?guid=' . $entity->guid;
		$text = elgg_echo('market:mark:open', [$entity->market_type]);
	}
	
	$mark_status = elgg_view('output/url', [
		'class' => 'elgg-button elgg-button-action mrs',
		'href' => $href,
		'text' => $text,
		'is_action' => true,
	]);
}

if (elgg_get_plugin_setting('market_pmbutton', 'market') == 1) {
	if ($entity->owner_guid != elgg_get_logged_in_user_guid() && $entity->status != 'sold' && elgg_is_active_plugin('messages')) {
		$send_message = elgg_view('output/url', [
			'class' => 'elgg-button elgg-button-action',
			'href' => "messages/add?send_to={$entity->owner_guid}",
			'text' => elgg_echo('market:pmbuttontext'),
		]);
	}
}

echo elgg_format_element('div', ['class' => 'mtm'], $mark_status . $send_message);

//description
if (elgg_get_plugin_setting('market_allowhtml', 'market') == 0) {
	$description = elgg_autop(parse_urls(strip_tags($entity->description)));
}
else {
	$description = elgg_view('output/longtext', [
		'value' => $entity->description
	]);
}

echo elgg_format_element('div', ['class' => 'mtm'], $description);
