<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: Save contest addition fields
*/
if(!function_exists('wpc_save_contest_addtional_fields')){
function wpc_save_contest_addtional_fields(){
	if(!current_user_can('manage_options')){

		wp_die('You are not allowed to edit this page.');

	}
	check_admin_referer('wpc_save_contest_addtional_fields_verify');
	$contest_id = sanitize_text_field( $_POST['contest_id'] );
	$fileds_ids = $_POST['field_id'];
	if(!isset($_POST['field_id'])){
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'wpc_contests';
		 $wpdb->update( 
				$table_name, 
				array( 
					'additional_fields' => ''
				), 
				array( 'id' => (int)$contest_id ), 
				array( '%s' ), 
				array( '%d' ) 
			);
		wp_redirect( esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.$contest_id.'&fields_saving_error='.urlencode('No Field Found to Save')));

		exit();
	}
	
	$save_fields = new WPC_save_fields_validation($fileds_ids, $contest_id);
	
	if(!$save_fields->validation()){
		wp_redirect( esc_url_raw( get_admin_url().'admin.php?page=wpc_contests&contest_id='.$contest_id.'&fields_saving_error='.urlencode($save_fields->error() ) ) );

		exit();
	}
	
	$saving = new WPC_save_additional_fields_admin($fileds_ids, $contest_id);
	
	if($saving->saving() == true ){
		wp_redirect( esc_url_raw( get_admin_url().'admin.php?page=wpc_contests&contest_id='.$contest_id.'&fields_saving_success=1') );
		exit();
	}else{
		wp_redirect( esc_url_raw( get_admin_url().'admin.php?page=wpc_contests&contest_id='.$contest_id.'&fields_saving_error='.urlencode('Some Error Was Found') ) );

		exit();
	}
	
	
}
}