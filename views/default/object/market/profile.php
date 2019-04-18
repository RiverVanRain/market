<?php
$entity = elgg_extract('entity', $vars);
if (!elgg_instanceof($entity, 'object', 'market')) {
	return;
}

$currency = elgg_get_plugin_setting('market_currency', 'market');
$tu = $entity->time_updated;

?>

<div class="cart-profile-header">
<?php
if($entity->status == "sold"){ echo "<blockquote><center><b>The Item has been marked as SOLD by the owner</b></center></blockquote>"; }

?>
	<div class="cart-profile-details">
		<?php
		echo elgg_view('object/market/meta', $vars);
		?>
	</div>
	<?php
	$entity_body = '';

	$entity_body .= "<div class='mbm mts'><span class='market_pricetag'><b>" . elgg_echo('market:price') . "</b> {$currency} {$entity->price}</span></div>";

	$thumbnail = elgg_view('output/img', array(
					'src' => "market/image/{$entity->guid}/1/large/{$tu}.jpg",
					'class' => 'elgg-photo',
					'alt' => $entity->guid,
					));
	$img = elgg_view('output/url', array(
					'href' => "market/image/{$entity->guid}/1/master/{$tu}.jpg",
					'text' => $thumbnail,
					'class' => "elgg-lightbox-photo elgg-lightbox",
					'rel' => 'market-gallery',
					));

	$obs_img = elgg_view('output/img', array(
				'src' => "market/image/{$entity->guid}/1/large/{$tu}",
				'class' => 'elgg-photo',
				'alt' => $entity->guid,
				));

	$images = unserialize($entity->images);
	if (is_array($images)) {
		$entity_images = '';
		foreach ($images as $key => $value) {
			if ($value) {
				$entity_img = elgg_view('output/img', array(
								'src' => "market/image/{$entity->guid}/$key/small/{$tu}.jpg",
								'class' => 'elgg-photo',
								'alt' => $entity->guid,
								));
				$entity_images .= elgg_view('output/url', array(
								'href' => "market/image/{$entity->guid}/$key/master/{$tu}.jpg",
								'text' => $entity_img,
								'class' => "elgg-lightbox-photo elgg-lightbox",
								'rel' => 'market-gallery',
								'data-colorboxOpts' => "{slideshow: true, rel: 'group'}",
								));
			}
		}
	}
	if ($entity_images) {
		$entity_body .= "<div>$entity_images</div>";
	}
	if (elgg_get_plugin_setting('market_allowhtml', 'market') != 'yes') {
		$entity_body .= elgg_autop(parse_urls(strip_tags($entity->description)));
	} else {
		$entity_body .= elgg_view('output/longtext', array('value' => $entity->description));
	}

	if (elgg_get_plugin_setting('market_pmbutton', 'market') == 'yes') {
		if ($entity->owner_guid != elgg_get_logged_in_user_guid() && $entity->status != "sold") {
			$entity_body .= elgg_view('output/url', array(
							'class' => 'elgg-button elgg-button-action mtm',
							'href' => "messages/compose?send_to={$entity->owner_guid}",
							'text' => elgg_echo('market:pmbuttontext'),
							));
		}
	}
	
	$elgg_ts = time();
	$elgg_token = generate_action_token($elgg_ts);
	
	if ($entity->owner_guid == elgg_get_logged_in_user_guid()) {
		if($entity->status != "sold"){
			$href = "action/market/sold?guid={$entity->guid}&__elgg_ts=".$elgg_ts."&__elgg_token=".$elgg_token;
			$text = elgg_echo('Mark as Sold');
		} else {
			$href = "action/market/open?guid={$entity->guid}&__elgg_ts=".$elgg_ts."&__elgg_token=".$elgg_token;
			$text = elgg_echo('Open for '.$entity->market_type);
		}
			$entity_body .= elgg_view('output/url', array(
				'class' => 'elgg-button elgg-button-action mtm',
				'href' => $href,
				'text' => $text,
			));
	}

	echo elgg_view_image_block($img, $entity_body, array('class' => 'market-image-block'));
	?>
</div>