<?php
/**
 * @PACKAGE WP CONTEST
 */
/*
Plugin Name: WP Contest
Plugin URI: https://wordpresscontestplugin.com/
Description: The best plugin for growning and monitizing your contest
Version: 1.0.0
Author: &SONS Creative Development
Author URI: http://andsonsdesign.com
License: GPLv2 or later
Text Domain: wpc
Domain Path: /lang
*/


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
/*****************************************
This Plugin need WP version 4.0 or above.
*****************************************/
if ( version_compare( get_bloginfo('version'), '4.0', '<') )  {
    $message = "WordPress version is lower than 4.0.Need WordPress version 4.0 or higher.";
	die($message);
}

/*********
constants
**********/
define( 'WPC_PATH', plugin_dir_path(__FILE__)   );
define( 'WPC_URI', plugin_dir_url( __FILE__ )   );

/**************
Include Files
***************/
require(WPC_PATH.'/inc/acivation.php');
require(WPC_PATH.'/inc/helper_functions.php');
require(WPC_PATH.'/inc/enqueue.php');
require(WPC_PATH.'/inc/admin_pages.php');
require(WPC_PATH.'/inc/save_contest.php');
require(WPC_PATH.'/inc/edit_contest.php');
require(WPC_PATH.'/inc/general_settings_save.php');
require(WPC_PATH.'/inc/add_field_markup.php');
require(WPC_PATH.'/inc/wpc_add_field.php');
require(WPC_PATH.'/inc/save_addtional_fields.php');
require(WPC_PATH.'/inc/Upload_and_insert_entry.php');
require(WPC_PATH.'/inc/phase_two_criteria.php');
require(WPC_PATH.'/inc/wpc_notify_winners.php');
require(WPC_PATH.'/inc/wpc_admin_export.php');
require(WPC_PATH.'/inc/wpc_export_all.php');



require(WPC_PATH.'/shortcodes/phase_two_voting_ui.php');
require(WPC_PATH.'/shortcodes/wpc_entry_form.php');
require(WPC_PATH.'/shortcodes/wpc_judge_dashboard.php');
require(WPC_PATH.'/shortcodes/wpc_search_by_entry.php');
require(WPC_PATH.'/shortcodes/wpc_user_dsahboard.php');
require(WPC_PATH.'/shortcodes/wpc_contest.php');

/**************
Include Classes
***************/
require(WPC_PATH.'/classes/WPC_Validation.php');
require(WPC_PATH.'/classes/WPC_contest_settings.php');
require(WPC_PATH.'/classes/WPC_voting.php');

require(WPC_PATH.'/classes/WPC_phase_two_admin_page.php');
require(WPC_PATH.'/classes/WPC_save_fields_validation.php');
require(WPC_PATH.'/classes/WPC_save_additional_fields_admin.php');
require(WPC_PATH.'/classes/WPC_delete.php');
require(WPC_PATH.'/classes/WPC_Mark_as_winner.php');
require(WPC_PATH.'/classes/WPC_Admin_export_entry.php');
require(WPC_PATH.'/classes/WPCPageLister.php');



/*********
hooks
**********/
register_activation_hook( __FILE__, 'wpc_activation' );
add_action('init',  'wpc_upload_insert_entry');

add_action('wp_enqueue_scripts', 'wpc_front_end_enqueue');
add_action('admin_enqueue_scripts', 'wpc_back_end_enqueue');
add_action( 'admin_menu', 'wpc_adding_admin_pages' );
add_action( 'admin_post_wpc_save_contest', 'wpc_save_contest' );
add_action( 'admin_post_wpc_save_single_contest', 'wpc_save_single_contest' );
add_action( 'admin_post_wpc_save_general_settings', 'wpc_save_general_settings' );

add_action('wp_ajax_wpc_phase_two_voting', array('WPC_voting', 'wpc_phase_two_voting'));
add_action('wp_ajax_wpc_add_field', 'wpc_add_field');
add_action('admin_post_wpc_save_contest_addtional_fields', 'wpc_save_contest_addtional_fields');
add_action('admin_post_wpc_save_phase_two_criteria', 'wpc_save_phase_two_criteria');
add_action('wp_ajax_wpc_delete_entry', array('WPC_delete', 'wpc_delete_entry'));
add_action('wp_ajax_wpc_delete_contest', array('WPC_delete', 'wpc_delete_contest'));
add_action('wp_ajax_wpc_mark_as_winner', array('WPC_Mark_as_winner', 'wpc_mark_as_winner_method'));
add_action('wp_ajax_wpc_notify_winners', 'wpc_notify_winners');
add_action('wp_ajax_wpc_admin_export', 'wpc_admin_export');
add_action('wp_ajax_wpc_export_all', 'wpc_export_all');
add_action('wp', 'wpc_down_the_pdf');
add_action('wp_footer', 'wpc_download_pdf_file');
/*********
shortcodes
**********/
add_shortcode('wpc_entry_form', 'wpc_contests_enrtry_form');	
	
add_shortcode('wpc_voting_round','wpc_phase_two_voting_contest');	
add_shortcode('wpc_judge_dash','wpc_judge_dashboard');	
add_shortcode('wpc_search_by_entry','wpc_search_by_entry');	
add_shortcode('wpc_user_dash','wpc_user_dsahboard');	
add_shortcode('wpc_contest','wpc_contest_shortcode_function');	


