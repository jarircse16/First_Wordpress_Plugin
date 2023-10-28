<?php
/*
Plugin Name: Jarir's First Plugin
Plugin URI:
Description: This plugin does things you never thought were possible.
Author: Jarir Ahmed
Version: 1.0
Author URI:

Copyright 2023  Jarir Ahmed

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $wp_version;

if (!version_compare($wp_version, "3.0", ">=")) {
    die("You need at least version 3.0 of WordPress to use the copyright plugin.");
}

function add_copyright() {
    $copyright_message = "Copyright " . date("Y") . " Jarir Productions, All Rights Reserved";
    echo $copyright_message;
}
add_action("wp_footer", "add_copyright");

function my_plugin_activate() {
    // Specify the path to the log file in the current directory of the plugin
    $log_file = plugin_dir_path(__FILE__) . 'activation_log.txt';
    // Log the activation message to the specified log file
    $message = "My plugin activated\n";
    file_put_contents($log_file, $message, FILE_APPEND);
}

register_activation_hook(__FILE__, "my_plugin_activate");

function my_plugin_deactivate() {
    // Specify the path to the log file in the current directory of the plugin
    $log_file = plugin_dir_path(__FILE__) . 'activation_log.txt';
    // Log the deactivation message to the specified log file
    $message = "My plugin DE-activated\n";
    file_put_contents($log_file, $message, FILE_APPEND);
}

register_deactivation_hook(__FILE__, "my_plugin_deactivate");

function cc_comment() // Send the comment notification via email.
{
	global $_REQUEST;

	$to = "drew@falkonproductions.com";
	$subject = "New comment posted @ yourblog " . $_REQUEST['subject'];
	$message = "Message from: " . $_REQUEST['name'] . " at email: " . $_REQUEST['email'] . ": \n" . $_REQUEST['comments'];
	mail($to,$subject,$message);
}

add_action('comment_post','cc_comment');

function cwmp_add_content_watermark( $content )
{

	// in case we want to add to earlier versions
	if (  is_feed() )
	{
		return $content .
		"Created by Jarir Productions, copyright  " .
		date("Y") .
		" all rights reserved.";
	}

	return $content;
}

add_filter("the_content","cwmp_add_content_watermark");
