<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
$entity = elgg_extract('entity', $vars);

$yes_no = [
    1 => elgg_echo('option:yes'),
	0 => elgg_echo('option:no'),
];

$no_yes = array_reverse($yes_no);

//Basic Configuration
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:basic:config'),
	'fields' => [
		[
			'#type' => 'number',
			'#label' => elgg_echo('settings:market:max:posts'),
			'name' => 'params[market_max]',
			'value' => $entity->market_max ? : 0,
			'#help' => elgg_echo('settings:market:max:posts:help'),
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'name' => 'params[market_adminonly]',
			'checked' => (bool) $entity->market_adminonly,
			'#label' => elgg_echo('settings:market:adminonly'),
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'name' => 'params[enable_groups]',
			'checked' => (bool) $entity->enable_groups,
			'#label' => elgg_echo('settings:market:enable_groups'),
		],
		
		[
			'#type' => 'text',
			'#label' => elgg_echo('settings:market:currency'),
			'name' => 'params[market_currency]',
			'value' => $entity->market_currency ? : '$',
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:allowhtml'),
			'name' => 'params[market_allowhtml]',
			'checked' => (bool) $entity->market_allowhtml,
		],
		
		[
			'#type' => 'number',
			'#label' => elgg_echo('settings:market:numchars'),
			'name' => 'params[market_numchars]',
			'value' => $entity->market_numchars ? : 0,
			'#help' => elgg_echo('settings:market:numchars:help'),
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:pmbutton'),
			'name' => 'params[market_pmbutton]',
			'checked' => (bool) $entity->market_pmbutton,
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:location'),
			'name' => 'params[location]',
			'checked' => (bool) $entity->location,
		],
		
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:comments'),
			'name' => 'params[market_comments]',
			'checked' => (bool) $entity->market_comments,
		],
	],
]);

//Categories
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:categories'),
	'fields' => [
		[
			'#type' => 'tags',
			'#help' => elgg_echo('settings:market:categories:help'),
			'name' => 'params[market_categories]',
			'value' => $entity->market_categories ? : '',
		],
	],
]);

//Image View Type
$image_size = [
	'tiny' => elgg_echo('settings:market:image_size:tiny'),
	'small' => elgg_echo('settings:market:image_size:small'),
	'medium' => elgg_echo('settings:market:image_size:medium'),
	'large' => elgg_echo('settings:market:image_size:large'),
	'master' => elgg_echo('settings:market:image_size:master'),
];
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:image_size'),
	'fields' => [
		[
			'#type' => 'select',
			'name' => 'params[image_size]',
			'value' => $entity->image_size ? : 'medium',
			'options_values' => $image_size,
		],
	],
]);

//Custom field
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:custom'),
	'fields' => [
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:custom:activate'),
			'name' => 'params[market_custom]',
			'checked' => (bool) $entity->market_custom,
			'#help' => elgg_echo('settings:market:custom:help'),
		],
		
		[
			'#type' => 'tags',
			'#label' => elgg_echo('settings:market:custom:choices'),
			'name' => 'params[market_custom_choices]',
			'value' => $entity->market_custom_choices ? : '',
			'#help' => elgg_echo('settings:market:custom:choices:help'),
		],
	],
]);

//Cron settings
$month = elgg_echo('settings:market:expire:month');
$months = elgg_echo('settings:market:expire:months');

echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:expire'),
	'fields' => [
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:expire:date'),
			'name' => 'params[market_expire]',
			'value' => $entity->market_expire ? : '0',
			'options_values' => [
				'0' => elgg_echo('disable'),
				'1' => "1 $month",
				'2' => "2 $months",
				'3' => "3 $months",
				'4' => "4 $months",
				'5' => "5 $months",
				'10' => "10 $months",
				'12' => "12 $months",
			],
		],
	],
]);

//Terms
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:terms'),
	'fields' => [
		[
			'#type' => 'checkbox',
			'switch' => true,
			'#label' => elgg_echo('settings:market:terms:enable'),
			'name' => 'params[market_terms_enable]',
			'checked' => (bool) $entity->market_terms_enable,
		],
		
		[
			'#type' => 'longtext',
			'#label' => elgg_echo('settings:market:terms:text'),
			'name' => 'params[market_terms]',
			'value' => $entity->market_terms ? : '',
		],
	],
]);