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
use Market\Cron;
use Market\Hooks;
use Market\Menus;
use Market\Notifications;

function market_init() {

	// Menus
	elgg_register_plugin_hook_handler('register', 'menu:site', [Menus::class, 'marketSiteMenu']);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', [Menus::class, 'marketOwnerBlock']);
	
    //Sidebar
	if(elgg_in_context('market')){
		elgg_extend_view('page/elements/sidebar', 'market/sidebar', 100);
	}
	
	//Groups
	elgg()->group_tools->register('market', [
		'default_on' => true,
		'label' => elgg_echo('market:enablemarket'),
	]);

	//CSS
	elgg_extend_view('elgg.css', 'market/css.css');

	//JS
	elgg_require_js('market');
	
	//Hooks
	elgg_register_event_handler('delete', 'object', [Hooks::class, 'deleteMarket']);

	//Notifications
	elgg_register_notification_event('object', 'market', ['create']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:swap', [Notifications::class, 'createMarket']);

	//Cron job
	elgg_register_plugin_hook_handler('cron', 'daily', [Cron::class, 'marketCronDaily']);
	
	//Likes
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:market', 'Elgg\Values::getTrue');
}

return function() {
	elgg_register_event_handler('init', 'system', 'market_init');
};