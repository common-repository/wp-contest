<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: plugin functions 
*/
if(!function_exists('wpc_change_mail_from')){
function wpc_change_mail_from( $name )
{
    return  apply_filters( 'wpc_winner_notification_form', get_bloginfo( 'name' ) );
}
} 

if(!function_exists('wpc_notify_winners')){
function wpc_notify_winners(){
		$data = $_POST['data'];
		$security = $_POST['security'];
		$subject = sanitize_text_field( $data['subject'] );
		$message = sanitize_text_field( $data['message'] );
		$contest_id = sanitize_text_field( $data['contest_id'] );
		
		if( !current_user_can('manage_options') ){
		wp_send_json('failed');
			return;
		}
		
		if(!check_ajax_referer('delete-contest-nonce','security')){
		wp_send_json('failed');
			return;
		}
		
		
		
		if(!$subject || $subject == ''){
			wp_send_json('<span style="color:red;">Please add message subject.</span>');
		}
		if(!$message || $message == ''){
			wp_send_json('<span style="color:red;">Please add message.</span>');
		}
		if(!in_array( $contest_id,  wpc_get_all_contest_id())){
			wp_send_json('<span style="color:red;">No Contest Found.</span>');
		}
		$winners_option_key = 'wpc_winner_list_'.$contest_id; 
		if(!get_option( $winners_option_key )){
			wp_send_json('<span style="color:red;">No Winner Found.</span>');
		}
		$winners_entry_array = get_option( $winners_option_key );
		
		
		
		if(count($winners_entry_array) == 1 ){
			wp_send_json('<span style="color:red;">No Winner Found.</span>');
		}
		$users = array();
		foreach($winners_entry_array as $entry_id ){
			if( $entry_id != 0 ){
					 $entry_values = wpc_get_entry($entry_id);
						
					 $user_id = $entry_values['user_id'];
					if(!in_array(get_userdata($user_id)->user_email, $users)){
					$users[] =  get_userdata($user_id)->user_email;
					}
			}
		}
		add_filter( 'wp_mail_from_name', 'wpc_change_mail_from' );
		$to = implode(",", $users);
		
		
		$headers = array('Content-Type: text/html; charset=UTF-8');
		 
		wp_mail( $to, $subject, $message, $headers );
		
		
		
		
		
		
		wp_send_json('<span style="color:green;">Notified Winners Successsully </span>');
		
		die();
}
}