<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE TO DELETE ENTRY
*/
if(!class_exists('WPC_delete')){
	class WPC_delete{
		
		function wpc_delete_entry(){
			global $wpdb;
			$data = $_POST['data'];
			$security = $_POST['security'];
			$entry_id = sanitize_text_field( $data['entry_id'] );
			
			if(!check_ajax_referer('Delobj-nonce','security')){
				wp_send_json('failed');
				return;
			}
			
			if(!current_user_can('manage_options') ){
				wp_send_json('failed');
				return;
			}
			
			$entry_table = $wpdb->prefix . 'wpc_entry';
			$table_pc_phase_one_votiong = $wpdb->prefix . 'wpc_phase_one_votiong';
			$table_pc_phase_two_votiong = $wpdb->prefix . 'wpc_phase_two_votiong';
			
			$wpdb->delete( $entry_table, array( 'id' => $entry_id ), array( '%d' ) );
			$wpdb->delete( $table_pc_phase_one_votiong, array( 'entry_id' => $entry_id ), array( '%d' ) );
			$wpdb->delete( $table_pc_phase_two_votiong, array( 'entry_id' => $entry_id ), array( '%d' ) );
			
			
			
			
			wp_send_json('success');
			die();
		}
		
		function wpc_delete_contest(){
			global $wpdb;
			$pc_contests = $wpdb->prefix . 'wpc_contests';
			$pc_entry = $wpdb->prefix . 'wpc_entry';
			$pc_phase_one_votiong = $wpdb->prefix . 'wpc_phase_one_votiong';
			$pc_phase_two_votiong = $wpdb->prefix . 'wpc_phase_two_votiong';
		//DELETE from tablename WHERE id IN (1,2,3,...,254);
			$data = $_POST['data'];
			$security = $_POST['security'];
			$contest_id = sanitize_text_field( $data['contest_id'] );
			
			if(!check_ajax_referer('delete-contest-nonce','security')){
				wp_send_json('failed');
				return;
			}
			
			if(!current_user_can('manage_options') ){
				wp_send_json('failed');
				return;
			}
			
			$all_entries = wpc_get_entryids_by_contest_id($contest_id);
			if(wpc_if_contest_exist($contest_id)){
				$wpdb->delete( $pc_contests, array( 'id' => $contest_id ));
				$wpdb->delete( $pc_entry, array( 'contest_id' => $contest_id ));
				if(count($all_entries) > 0 ){
					$wpdb->query("DELETE FROM $pc_phase_one_votiong  WHERE entry_id IN (".implode(",", $all_entries).") ");
					$wpdb->query("DELETE FROM  $pc_phase_two_votiong  WHERE entry_id IN (".implode(",", $all_entries).") ");
				}
				wp_send_json('success');
			}
			
			
			wp_send_json('failed');
		}
		
		
	}
}