<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$post = get_entity($vars['guid']);
$vars['entity'] = $post;

// Get plugin settings
$currency = elgg_get_plugin_setting('market_currency', 'market');
$numchars = elgg_get_plugin_setting('market_numchars', 'market');
$marketcategories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));
$custom_choices = string_to_tag_array(elgg_get_plugin_setting('market_custom_choices', 'market'));

//title
echo elgg_view_field([
	'#label' => elgg_echo('title'),
	'#type' => 'text',
	'name' => 'title',
	'required' => true,
	'autofocus' => true,
	'value' => elgg_extract('title', $vars),
]);
	
//categories
if (!empty($marketcategories)) {
	$options = [];
	$options[''] = elgg_echo('market:choose');
	foreach ($marketcategories as $option) {
		$options[$option] = urldecode($option);
	}		
	unset($options['all']);
	
	echo elgg_view_field([
		'#label' => elgg_echo('market:categories:choose'),
		'#type' => 'select',
		'name' => 'marketcategory',
		'value' => elgg_extract('marketcategory', $vars),
		'options_values' => $options,
	]);
	
}

//types
$types = ['buy', 'sell', 'swap', 'free'];
$options = [];
$options[''] = elgg_echo('market:choose');
foreach ($types as $type) {
	$options[$type] = elgg_echo("market:type:{$type}");
}

echo elgg_view_field([
	'#label' => elgg_echo('market:type:choose'),
	'#type' => 'select',
	'name' => 'market_type',
	'id' => 'market-type',
	'value' => elgg_extract('market_type', $vars),
	'options_values' => $options,
	'required' => true,
]);

//custom choices
if ((bool) elgg_get_plugin_setting('market_custom', 'market') && !empty($custom_choices)) {
	$custom_options = [];
	$custom_options[''] = elgg_echo('market:choose');
	foreach ($custom_choices as $custom_choice) {
		$custom_options[$custom_choice] = urldecode($custom_choice);
	}		
	
	echo elgg_view_field([
		'#label' => elgg_echo('market:custom:select'),
		'#type' => 'select',
		'name' => 'custom',
		'value' => elgg_extract('custom', $vars),
		'options_values' => $custom_options,
	]);
}

//location
if ((bool) elgg_get_plugin_setting('location', 'market')) {
	echo elgg_view_field([
		'#label' => elgg_echo('market:location'),
		'#type' => 'location',
		'name' => 'location',
		'value' => elgg_extract('location', $vars),
		'#help' => elgg_echo('market:location:help'),
	]);
}

//description
if (!(bool) elgg_get_plugin_setting('market_allowhtml', 'market')) {
	$data_limit = $numchars;
	
	$indicator = elgg_format_element('span', ['data-counter-indicator' => true, 'class' => 'market_charleft'], $numchars);
	$counter = elgg_format_element('div', ['data-counter' => true, 'class' => 'market_characters_remaining'], $indicator . elgg_echo('market:charleft'));
	
	if($numchars == 0){
		$counter = false;
		$data_limit = false;
	}
	
	echo elgg_view_field([
		'#label' => elgg_echo('market:text'),
		'#type' => 'plaintext',
		'name' => 'description',
		'id' => 'plaintext-description',
		'data-limit' => $data_limit,
		'required' => true,
		'value' => elgg_extract('description', $vars),
		'#help' => $counter,
	]);
} else {
	echo elgg_view_field([
		'#label' => elgg_echo('market:text'),
		'#type' => 'longtext',
		'name' => 'description',
		'required' => true,
		'value' => elgg_extract('description', $vars),
	]);
}

//price
echo elgg_view_field([
	'#label' => elgg_echo('market:price'),
	'#type' => 'number',
	'step' => '0.01',
	'name' => 'price',
	'id' => 'market-price',
	'value' => elgg_extract('price', $vars),
	'#help' => elgg_echo('market:price:help', [$currency]),
]);

//tags
echo elgg_view_field([
	'#label' => elgg_echo('tags'),
	'#type' => 'tags',
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
	'#help' => elgg_echo('market:tags:help'),
]);

//comments
if ((bool) elgg_get_plugin_setting('market_comments', 'market')) {
	echo elgg_view_field([
		'#label' => elgg_echo('comments'),
		'#type' => 'select',
		'name' => 'comments_on',
		'value' => elgg_extract('comments_on', $vars),
		'options_values' => [
			'On' => elgg_echo('on'),
			'Off' => elgg_echo('off')
		],
	]);
}

//cover
$icon_input = '';
if ($post) {
	$icon_label = elgg_echo('market:icon:upload:edit');
	
	if ($post->icontime) {
		$icon_input = elgg_format_element('div', [], elgg_view('output/img', [
			'src' => $post->getIconURL(),
		]));
	}
} else {
	$icon_label = elgg_echo('market:icon:upload:new');
}

echo elgg_view_field([
	'#label' => $icon_label,
	'#type' => 'file',
	'name' => 'icon',
	'id' => 'market_icon',
	'enable_dropzone' => false,
	'accept' => 'image/*',
	'#help' => $icon_input,
]);

//attached images
echo elgg_view_field([
	'#label' => elgg_echo('market:upload'),
	'#type' => 'dropzone',
	'name' => 'upload_guids',
	'accept' => "image/*",
	'max' => 25,
	'multiple' => true,
	'action' => elgg_normalize_url('action/dropzone/upload'),
	'subtype' => 'file',
	'container_guid' => elgg_get_logged_in_user_guid(),
]);

// Option to delete uploded image
if($post instanceof \ElggMarket){
	$options = [
		'relationship' => 'attached',
		'relationship_guid' => $post->guid,
		'inverse_relationship' => true,
		'metadata_name_value_pairs' => [
			'name' => 'simpletype', 'value' => 'image',
		],
		'limit' => 0,
	];
	$images = elgg_get_entities($options);
	if(count((array)$images) > 0){
		echo '<div class="elgg-dropzone-preview dz-processing dz-image-preview dz-success dz-complete elgg-dropzone-success">'; 
		foreach ($images as $image) {
			$image_params = [
				'alt' => $image->getDisplayName(),
				'src' => $image->getIconURL(['size' => 'small']),
				'class' => 'elgg-photo',
			];
			$icon = elgg_view('output/img', $image_params);
			
			$thumbnail = elgg_format_element('div', ['class' => 'elgg-dropzone-thumbnail'], $icon);
			
			$file_name = elgg_format_element('span', ['class' => 'elgg-dropzone-filename-str'], $image->getDisplayName());
			$filename = elgg_format_element('div', ['class' => 'elgg-dropzone-filename'], $file_name);
				
			$remove_icon = elgg_format_element('span', ['class' => 'elgg-icon elgg-icon-trash far fa-trash-alt']);
			$controls = elgg_format_element('div', ['class' => 'elgg-dropzone-controls'], elgg_view('output/url', [
				'href' => elgg_generate_action_url('entity/delete', [
					'guid' => $image->guid,
				]),
				'text' => $remove_icon,
				'class' => 'elgg-dropzone-remove-icon noajax',
				'title' => elgg_echo('remove'),
			]));
			
			echo elgg_format_element('div', ['class' => 'elgg-dropzone-item-props'], $thumbnail . $filename . $controls);
		}
		echo '</div>';
	}
}

//access level
echo elgg_view_field([
	'#label' => elgg_echo('access'),
	'#type' => 'access',
	'name' => 'access_id',
	'value' => elgg_extract('access_id', $vars),
	'entity' => elgg_extract('entity', $vars),
	'entity_type' => 'object',
	'entity_subtype' => \ElggMarket::SUBTYPE,
]);

//terms
if ((bool) elgg_get_plugin_setting('market_terms_enable', 'market')) {
	$termslink = elgg_view('output/url', [
		'href' => 'market/terms',
		'text' => elgg_echo('market:terms:title'),
		'class' => 'elgg-lightbox',
		'data-colorbox-opts' => json_encode([
			'width' => '1000px',
			'height' => '98%',
			'maxWidth' => '98%',
		]),
		'deps' => ['elgg/lightbox'],
	]);

	echo elgg_view_field([
		'#label' => elgg_echo('market:accept:terms', [$termslink]),
		'#type' => 'checkbox',
		'name' => 'accept_terms',
		'required' => true,
	]);
}

//hiddens
$fields = [
	[
		'#type' => 'hidden',
		'name' => 'container_guid',
		'value' => elgg_get_page_owner_guid(),
	],
	[
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => elgg_extract('guid', $vars),
	],
];

foreach ($fields as $field) {
	echo elgg_view_field($field);
}

$footer = elgg_view('input/submit', [
	'value' => elgg_echo('save'),
	'name' => 'save',
]);

elgg_set_form_footer($footer);