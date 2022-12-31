<?php

/**
 * Dev
 *
 * @package     Refreshed
 * @author      c1llo
 * @copyright   2023 c1llo
 * @license     MIT
 *
 * @wordpress-plugin
 * Plugin Name:  Refreshed
 * Description:  A better editing & development experience with the Refreshed plugin.
    This plugin automatically refreshes the browser whenever a page or post is updated.
 * Version:     0.1.0
 * Author:     c1llo
 * License:     MIT
 */

if (!defined('ABSPATH')) exit;
if ( ! defined( 'REFRESHED_PLUGIN_DIR' ) )	define( 'REFRESHED_PLUGIN_DIR'	, plugin_dir_path( __FILE__ ) );
if ( ! defined( 'REFRESHED_DIR_URL' ) )	define( 'REFRESHED_DIR_URL'	, plugin_dir_url( __FILE__ ) );

require_once(REFRESHED_PLUGIN_DIR . 'vendor/autoload.php');
require_once(REFRESHED_PLUGIN_DIR . 'admin.php');
require_once(REFRESHED_PLUGIN_DIR . 'functions.php');

/**
 * Add settings link on plugin page
 */
function refreshed_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'tools.php?page=refreshed' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'refreshed_add_plugin_page_settings_link');