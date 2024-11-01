<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: plugin functions 
*/
if(!function_exists('wpc_admin_export')){
function wpc_admin_export(){
	
		$data = $_POST['data'];
		
		$contest_id = sanitize_text_field(  $data['contest_id'] );
		$action = sanitize_text_field(  $data['action'] );
	 
		
		if(!check_ajax_referer('Delobj-nonce','security')){
			wp_send_json('failed');
			return;
		}
		
		if(!current_user_can('manage_options')){

			wp_send_json('failed');
			return;

		}
		
		$WPC_Admin_export_entry = new WPC_Admin_export_entry($contest_id);
				
		$csv_table = $WPC_Admin_export_entry->WPC_get_entry_table($action);	
		if($csv_table){
			wp_send_json($csv_table);
		}else{
			wp_send_json('failed');
		}
	wp_send_json('failed');
	die();
}
}