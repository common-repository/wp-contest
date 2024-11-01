<?php /*  * 	@PACKAGE WP CONTEST*	USE: Save general settings*/if(!function_exists('wpc_save_general_settings')){	function wpc_save_general_settings(){				if(!current_user_can('manage_options')){			wp_die('You are not allowed to edit this page.');		}		check_admin_referer('wpc_save_general_settings_verify');		$upload_size = absint( sanitize_text_field( $_POST['upload_size'] ) );		$max_num_files = absint(  sanitize_text_field( $_POST['max_num_files'] ) );		$file_types =  explode(',',  sanitize_text_field( $_POST['file_types'] ) );		$payment_mode =  sanitize_text_field( $_POST['payment_mode'] );		$sandbox_client_id =  sanitize_text_field( $_POST['sandbox_client_id'] );		$sandbox_secret_key =  sanitize_text_field( $_POST['sandbox_secret_key'] );		$live_client_id =  sanitize_text_field( $_POST['live_client_id'] );		$live_secret_key =  sanitize_text_field( $_POST['live_secret_key'] );		$success_payment_page =  sanitize_text_field( $_POST['success_payment_page'] );		$failed_payment_page =  sanitize_text_field( $_POST['failed_payment_page'] );		$general_settings = array(			'upload_size' => $upload_size,			'max_num_files' => $max_num_files,			'file_types' => $file_types,			'payment_mode' => $payment_mode,			'sandbox_client_id' => $sandbox_client_id,			'sandbox_secret_key' => $sandbox_secret_key,			'live_client_id' => $live_client_id,			'live_secret_key' => $live_secret_key,			'success_payment_page' => $success_payment_page,			'failed_payment_page' => $failed_payment_page								);			  // echo '<pre>';	  // var_dump($_POST);	   // echo '</pre>';	  // die();		update_option( 'wpc_general_settings', $general_settings );		wp_redirect( esc_url_raw( get_admin_url().'admin.php?page=wpc_general_settings&status=1' ) );		exit();					}}