<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */

return [
	'plugin' => [
		'name' => 'Market',
		'version' => '5.1.0',
	],
	
	'bootstrap' => \Market\Bootstrap::class,
	
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'market',
			'class' => 'ElggMarket',
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'market_file',
			'class' => \Market\MarketFile::class,
			'capabilities' => [
				'commentable' => false,
				'searchable' => false,
				'likable' => false,
			],
		],
		//Dropzone
		[
			'type' => 'object',
			'subtype' => 'temp_file_upload',
			'class' => \wZm\Dropzone\TempUploadFile::class,
			'capabilities' => [
				'commentable' => false,
				'searchable' => false,
				'likable' => false,
			],
		],
	],
	
	'actions' => [
		'market/sold' => [],
		'market/open' => [],
		'market/save' => [],
		//Dropzone
		'dropzone/upload' => [
			'controller' => \wZm\Dropzone\UploadAction::class,
		],
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
			'required_plugins' => [
				'friends',
			],
		],
		'collection:object:market:group' => [
			'path' => '/market/group/{guid}/{subpage?}',
			'resource' => 'market/group',
			'defaults' => [
				'subpage' => 'all',
			],
			'required_plugins' => [
				'groups',
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
			'middleware' => [
				\Elgg\Router\Middleware\AjaxGatekeeper::class,
			],
		],
	],
	
	'events' => [
		'container_logic_check' => [
			'object' => [
				\Market\GroupToolContainerLogicCheck::class => [],
			],
		],
		'delete' => [
			'object' => [
				'\Market\Events::deleteMarket' => ['priority' => 600],
				'\Market\Events::deleteImage' => ['priority' => 600],
			],
		],
		'form:prepare:fields' => [
			'market/save' => [
				\Market\Forms\PrepareFields::class => [],
			],
		],
		'register' => [
			'menu:owner_block' => [
				'\Market\Menus\OwnerBlock::registerUserItem' => [],
				'\Market\Menus\OwnerBlock::registerGroupItem' => [],
			],
			'menu:site' => [
				'\Market\Menus\Site::register' => [],
			],
			'menu:filter:market/all' => [
				'\Market\Menus\Filter::allRegister' => [],
			],
			'menu:filter:market/owner' => [
				'\Market\Menus\Filter::ownerRegister' => [],
			],
			'menu:filter:market/group' => [
				'\Market\Menus\Filter::groupRegister' => [],
			],
			'menu:filter:market/category' => [
				'\Market\Menus\Filter::categoryRegister' => [],
			],
			'menu:title:object:market' => [
				\Elgg\Notifications\RegisterSubscriptionMenuItemsHandler::class => [],
			],
		],
		'view_vars' => [
			'input/file' => [
				'\wZm\Dropzone\Views::fileToDropzone' => [],
			],
			'input/dropzone' => [
				'\wZm\Dropzone\Views::preventDropzoneDeadloop' => [],
			],
		],
		'action' => [
			'all' => [
				'\wZm\Dropzone\Actions::prepareFiles' => [],
			],
		],
		'cron' => [
			'daily' => [
				'\Market\Cron::marketCronDaily' => [],
				'\wZm\Dropzone\Cron::cleanupTempUploadedFiles' => [],
			],
		],
	],
	
	'notifications' => [
		'object' => [
			'market' => [
				'create' => \Market\Notifications\CreateMarketEventHandler::class,
			],
		],
	],
	
	'views' => [
		'default' => [
			'dropzone/lib.js' => __DIR__ . '/vendor/npm-asset/dropzone/dist/min/dropzone-amd-module.min.js',
			'css/dropzone/stylesheet' => __DIR__ . '/views/default/dropzone/dropzone.css',
		],
	],
	
	'view_extensions' => [
		'elgg.css' => [
			'market/css.css' => [],
			'css/dropzone/stylesheet' => [],
		],
		'admin.css' => [
			'css/dropzone/stylesheet' => [],
		],
	],
	
	'widgets' => [
		'market' => [
			'context' => ['profile', 'dashboard', 'groups'],
		],
	],
	
	'settings' => [
		'market_max' => 0,
		'market_adminonly' => false,
		'enable_groups' => true,
		'market_currency' => '$',
		'market_allowhtml' => true,
		'market_numchars' => 0,
		'market_pmbutton' => false,
		'location' => false,
		'market_comments' => false,
		'image_size' => 'medium',
		'market_custom' => false,
		'market_expire' => '0',
		'market_terms_enable' => false,
	],
];
