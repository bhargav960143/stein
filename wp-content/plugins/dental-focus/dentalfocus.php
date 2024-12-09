<?php
/**
 * Plugin Name: SCI Membership
 * Plugin URI: https://www.trentiums.com
 * Description: This plugin is use for dental doctors for website and blog features, provide various package like dental focus, <strong>dental testimonial</strong>, <strong>dental team</strong>, <strong>dental portfolio</strong>, <strong>dental banner</strong>, <strong>dental treatment</strong>, <strong>dental settings</strong>, <strong>dental social media</strong> and easy to use functionality, manage all settings from admin side. Provide quality of work and explore new way to keep in touch with digital world and technologies.
 * Version: 1.1
 * Author: Trentium Team
 * Author URI: https://www.trentiums.com
 * License: GPL2
 */

/*
	Plugin Configuration
*/
define('TRENTIUM_CONTACT_FORM_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('TRENTIUM_PLUGIN_VERSION', "0.0.1");
include 'include/config.php';
include 'include/db-function.php';
include 'include/sortcode.php';
include 'dentalfocusmanager.php';
/*
	Add hook in plugin activation time.
	Add plugin configuration at activation time.

	Function parameter detail.

	Assign current file path
	1) __FILE__ 					: C:\xampp\htdocs\blog\wp-content\plugins\SCI Membership\config.php
	2) dentalfocus_register_setup	: Function name you want to execute at activation time.
*/
register_activation_hook(__FILE__, 'dentalfocus_active_plugin');
/*
	Add hook in plugin uninstall time.
	Remove plugin from plugins folder

	Function parameter detail.

	Assign current file path
	1) __FILE__ 					: C:\xampp\htdocs\blog\wp-content\plugins\SCI Membership\config.php
	2) dentalfocus_deactive_plugin	: Function name you want to execute at deactivation time. 
*/
register_uninstall_hook(__FILE__, 'dentalfocus_uninstall_plugin');
?>