<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: plugin functions 
*/
if(!function_exists('wpc_export_all')){
function wpc_export_all(){
	
	$data = $_POST['data'];
	
	$contest_id = sanitize_text_field( $data['contest_id'] );
	$category = sanitize_text_field( $data['category'] );
	$all_entries_id = wpc_get_all_paid_entry_id_by_contest_id($contest_id);
	
	if(!check_ajax_referer('export-nonce','security')){
		wp_send_json('failed');
		
	}
	
	if( !is_user_logged_in() ){
		wp_send_json('failed');
	}
	
	
	if(count($all_entries_id) == 0 ){
		wp_send_json('failed');
		
	}
	
	$entries_to_export = wpc_filter_current_category_entries($all_entries_id, $category);
	
	
	if(count($entries_to_export) == 0){
		wp_send_json('failed');
	}
	if( wpc_entries_eligible_for_phase_two($contest_id) ){
			$photos_of_phase_two = wpc_entries_eligible_for_phase_two($contest_id);
		}else{
			$photos_of_phase_two = array();
		}
	$pop_all_export_table = '<table style="display:none;" class="pop_all_export_table" >
				  <tr>
					<th>Submission ID</th>
					<th>Submitted By</th> 
					<th>Location</th>
					<th>Photo Title</th>
					<th>Category</th>
					<th>Score</th>
					<th>Submitted On</th>
					<th>Photo URL</th>
					<th>Contestant Email</th>
					<th>Contestant Phone</th>
				  </tr>';
	  
	
		foreach($entries_to_export as $entry_id){
		$entry_values = wpc_get_entry($entry_id);
		$entry_meta = unserialize( $entry_values['entry_meta'] );
		$img_src = wpc_upload_dir_url().$entry_meta['image'];
		if( wpc_get_score($entry_id) && (wpc_get_score($entry_id) !== 0) ){
			$score = wpc_get_score($entry_id);
			$scoreAttr = $score;
		}else{
			$score = "Not Scoreed Yet";
			$scoreAttr = 0;
		}
		
		if(in_array($entry_id, $photos_of_phase_two)){
			$status = 'Phase Two';
		}elseif(wpc_if_out_of_contest($entry_id)){
			$status = 'Out Of Contest';
		}else{
			$status = 'Phase One';
		}
		$status = 'Phase One';
		if($status == 'Out Of Contest'){ $status_class=" out_of_contest "; }else{ $status_class= ''; }
		$phone = get_user_meta( $entry_values['user_id'], 'billing_phone', true ) ? get_user_meta( $entry_values['user_id'], 'billing_phone', true ) : ' ';
		$pop_all_export_table .=	 '<tr>
					<td>'.$entry_id.'</td>
					<td>'. get_user_by('id', $entry_values['user_id'])->display_name.'</td>
					<td>'.$entry_meta['description'].'</td>
					<td>'.$entry_meta['title'].'</td>
					<td>'.$entry_meta['category'].'</td>
					<td>'.$score.'</td>
					<td>'.$entry_values['entry_time'].'</td>
					<td>'.esc_url_raw( $img_src ).'</td>
					<td>'.get_user_by('id', $entry_values['user_id'])->user_email.'</td>
					<td>'.$phone.'</td>
				</tr>';
		
	}
	
	$pop_all_export_table .=	'</tbody></table>';	
	wp_send_json($pop_all_export_table);
	
	
	
	die();
}
}