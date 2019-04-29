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
require_once(__DIR__ . '/lib/functions.php');

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'market',
			'class' => 'ElggMarket',
			'searchable' => true,
		],
	],
	'actions' => [
		'market/sold' => [],
		'market/open' => [],
		'market/save' => [],
		'market/del_img' => [],
		'market/change_cover' => [],
	],
	'routes' => [
		'default:object:market' => [
			'path' => '/market',
			'resource' => 'market/all',
		],
		'collection:object:market:all' => [
			'path' => '/market/all/{subpage?}',
			'resource' => 'market/all',
		],
		'view:object:market' => [
			'path' => '/market/view/{guid}/{title?}',
			'resource' => 'market/view',
		],
		'collection:object:market:owner' => [
			'path' => '/market/owner/{username}/{subpage?}',
			'resource' => 'market/owner',
			'defaults' => [
				'subpage' => 'all',
			],
		],
		'collection:object:market:friends' => [
			'path' => '/market/friends/{username?}',
			'resource' => 'market/friends',
		],
		'collection:object:market:group' => [
			'path' => '/market/group/{guid}/{subpage?}',
			'resource' => 'market/group',
			'defaults' => [
				'subpage' => 'all',
			],
		],
		'category:object:market' => [
			'path' => '/market/category/{category}',
			'resource' => 'market/category',
		],
		'add:object:market' => [
			'path' => '/market/add/{guid}',
			'resource' => 'market/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'edit:object:market' => [
			'path' => '/market/edit/{guid}',
			'resource' => 'market/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'terms:object:market' => [
			'path' => '/market/terms',
			'resource' => 'market/terms',
		],
	],
	'widgets' => [
		'market' => [
			'context' => ['profile', 'dashboard'],
		],
	],
];
