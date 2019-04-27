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
			'value' => $entity->market_max ? $entity->market_max : 0,
			'#help' => elgg_echo('settings:market:max:posts:help'),
		],
		
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:adminonly'),
			'name' => 'params[market_adminonly]',
			'value' => $entity->market_adminonly,
			'options_values' => $no_yes,
		],
		
		[
			'#type' => 'text',
			'#label' => elgg_echo('settings:market:currency'),
			'name' => 'params[market_currency]',
			'value' => $entity->market_currency ? $entity->market_currency : '$',
		],
		
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:allowhtml'),
			'name' => 'params[market_allowhtml]',
			'value' => $entity->market_allowhtml,
			'options_values' => $yes_no,
		],
		
		[
			'#type' => 'number',
			'#label' => elgg_echo('settings:market:numchars'),
			'name' => 'params[market_numchars]',
			'value' => $entity->market_numchars ? $entity->market_numchars : 0,
			'#help' => elgg_echo('settings:market:numchars:help'),
		],
		
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:pmbutton'),
			'name' => 'params[market_pmbutton]',
			'value' => $entity->market_pmbutton,
			'options_values' => $no_yes,
		],
		
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:location'),
			'name' => 'params[location]',
			'value' => $entity->location,
			'options_values' => $no_yes,
		],
		
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:comments'),
			'name' => 'params[market_comments]',
			'value' => $entity->market_comments,
			'options_values' => $no_yes,
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
			'value' => $entity->market_categories,
		],
	],
]);

//Custom field
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('settings:market:custom'),
	'fields' => [
		[
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:custom:activate'),
			'name' => 'params[market_custom]',
			'value' => $entity->market_custom,
			'options_values' => $no_yes,
			'#help' => elgg_echo('settings:market:custom:help'),
		],
		
		[
			'#type' => 'tags',
			'#label' => elgg_echo('settings:market:custom:choices'),
			'name' => 'params[market_custom_choices]',
			'value' => $entity->market_custom_choices,
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
			'value' => $entity->market_expire,
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
			'#type' => 'select',
			'#label' => elgg_echo('settings:market:terms:enable'),
			'name' => 'params[market_terms_enable]',
			'value' => $entity->market_terms_enable,
			'options_values' => $no_yes,
		],
		
		[
			'#type' => 'longtext',
			'#label' => elgg_echo('settings:market:terms:text'),
			'name' => 'params[market_terms]',
			'value' => $entity->market_terms,
		],
	],
]);