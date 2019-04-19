<?php

return [
	'actions' => [
		'market/sold' => [],
		'market/open' => [],
		'market/save' => [],
		'market/delete' => [],
		'market/delete_img' => [],
	],
	'routes' => [
		'all:object:market' => [
			'path' => '/market/all',
			'resource' => 'market/all',
		],
		'typeall:object:market' => [
			'path' => '/market/all/{type}',
			'resource' => 'market/all',
		],
		'category:object:market' => [
			'path' => '/market/category/{cat}',
			'resource' => 'market/category',
		],
		'add:object:market' => [
			'path' => '/market/add/{container_guid}',
			'resource' => 'market/add',
		],
		'edit:object:market' => [
			'path' => '/market/edit/{guid}',
			'resource' => 'market/edit',
		],
		'view:object:market' => [
			'path' => '/market/view/{guid}/{title}',
			'resource' => 'market/view',
		],
		'owned:object:market' => [
			'path' => '/market/owned/{username}',
			'resource' => 'market/owned',
		],
		'group:object:market' => [
			'path' => '/market/group/{group_guid}/{subpage}/{lower}/{upper}',
			'resource' => 'market/group',
		],
		'image:object:market' => [
			'path' => '/market/image/{guid}/{imagenum}/{size}/{tu}',
			'resource' => 'market/image',
		],
		'terms:object:market' => [
			'path' => '/market/terms',
			'resource' => 'market/terms',
		],
	],
];
