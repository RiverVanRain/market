<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
namespace Market;

use Elgg\Includer;
use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * Get plugin root
	 * @return string
	 */
	protected function getRoot() {
		return $this->plugin->getPath();
	}

	/**
	 * Executed during 'plugin_boot:before', 'system' event
	 *
	 * Allows the plugin to require additional files, as well as configure services prior to booting the plugin
	 *
	 * @return void
	 */
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/lib/functions.php');
	}
	
	/**
	 * Executed during 'plugin_boot:before', 'system' event
	 *
	 * Allows the plugin to register handlers for 'plugin_boot', 'system' and 'init', 'system' events,
	 * as well as implement boot time logic
	 *
	 * @return void
	 */
	public function boot() {

	}

	/**
	 * Executed during 'init', 'system' event
	 *
	 * Allows the plugin to implement business logic and register all other handlers
	 *
	 * @return void
	 */
	public function init() {
		$hooks = $this->elgg()->hooks;
		
		//Sidebar
		if(elgg_in_context('market')){
			elgg_extend_view('page/elements/sidebar', 'market/sidebar', 100);
		}

		//JS
		elgg_require_js('market');
		
		//Icons
		if (!elgg_is_active_plugin('file')) {
			$hooks->registerHandler('entity:icon:sizes', 'object', [Icons::class, 'setIconSizes']);
			$hooks->registerHandler('entity:icon:file', 'object', [Icons::class, 'setIconFile']);
		}
		
		if ((bool) elgg_get_plugin_setting('enable_groups', 'market')) {
			$this->elgg()->group_tools->register('market');
		}
	}
	
	/**
	 * Executed during 'ready', 'system' event
	 *
	 * Allows the plugin to implement logic after all plugins are initialized
	 *
	 * @return void
	 */
	public function ready() {

	}

	/**
	 * Executed during 'shutdown', 'system' event
	 *
	 * Allows the plugin to implement logic during shutdown
	 *
	 * @return void
	 */
	public function shutdown() {

	}
	
	/**
	 * Executed when plugin is activated, after 'activate', 'plugin' event and before activate.php is included
	 *
	 * @return void
	 */
	public function activate() {

	}

	/**
	 * Executed when plugin is deactivated, after 'deactivate', 'plugin' event and before deactivate.php is included
	 *
	 * @return void
	 */
	public function deactivate() {

	}

	/**
	 * Registered as handler for 'upgrade', 'system' event
	 *
	 * Allows the plugin to implement logic during system upgrade
	 *
	 * @return void
	 */
	public function upgrade() {

	}

}