<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE TO DELETE ENTRY
*/
if(!class_exists('WPC_Mark_as_winner')){
	class WPC_Mark_as_winner{
		
		public function wpc_mark_as_winner_method(){
			$data = $_POST['data'];
			$security = $_POST['security'];
			$contest_id = sanitize_text_field( $data['contest_id'] );
			$entry_id = sanitize_text_field( $data['entry_id'] );
			$action = sanitize_text_field( $data['action'] );
		//wp_send_json($contest_id);
			if(!check_ajax_referer('delete-contest-nonce','security')){
				wp_send_json('failed');
				return;
			}
			
			if(!current_user_can('manage_options') ){
				wp_send_json('failed');
				return;
			}
			
			
			
			$all_entries = wpc_get_entryids_by_contest_id($contest_id);
			
			if( wpc_if_contest_exist($contest_id) && in_array( $entry_id, $all_entries)  && in_array( $action, array('add', 'remove')) ){
			//init  winner list option in not exist
				
				if(!get_option( 'wpc_winner_list_'.$contest_id )){

					add_option( 'wpc_winner_list_'.$contest_id, array(0));

				}
				$winner_list = get_option( 'wpc_winner_list_'.$contest_id );
			//add to winner list 
				if($action == 'add'){
					if(!in_array($entry_id, $winner_list)){
						$winner_list[] = $entry_id;
						update_option( 'wpc_winner_list_'.$contest_id, $winner_list );
						wp_send_json('add_success');
					}
				}
				
			//remove from winner list 
				if($action == 'remove'){
					if(in_array($entry_id, $winner_list)){
						$key = array_search($entry_id,$winner_list);
						unset($winner_list[$key]);
						update_option( 'wpc_winner_list_'.$contest_id, $winner_list );
						
						wp_send_json('remove_success');
					}
				}
				
				
				
				
				
				
			}
			
			
			
			
			
			
			
			wp_send_json('failed');
		}
		
	}
}