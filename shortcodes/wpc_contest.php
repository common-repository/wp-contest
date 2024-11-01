<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: plugin function 
*/
if(!function_exists('wpc_contest_shortcode_function')){
function wpc_contest_shortcode_function($atts, $content = null){
	extract(shortcode_atts(array(
			'contest_id'=>'0',
			
	),$atts,'wpc_contest'));
	$contest_id = sanitize_text_field( $contest_id );
	$all_contest_id = wpc_get_all_contest_id();
	if(!count($all_contest_id)){

		return 'No Contest Found';

	}
	
	if(!in_array( $contest_id, $all_contest_id)){

		 return 'No Contest Found';

	}
	
	$all_entries_id = wpc_get_all_paid_entry_id_by_contest_id($contest_id);
	if(!$all_entries_id){
		 return 'No Entry Found of This Contest';
	}
	$output = '<table class="pc_entry_list">
					<tr>
						<th>'.__('ENRTRY', 'wpc').'</th>
						<th>'.__('TITLE', 'wpc').'</th> 
						<th>'.__('CATEGORY', 'wpc').'</th>
						<th>'.__('DESCRIPTION', 'wpc').'</th>
						
						<th>'.__('CONTESTANT', 'wpc').'</th>
						<th>'.__('DATE', 'wpc').'</th>
						
					  </tr>';
	foreach($all_entries_id as $entry_id){
					$entry_values = wpc_get_entry($entry_id);
					$entry_meta = unserialize( $entry_values['entry_meta'] );
					 $img_src = wpc_upload_dir_url().$entry_meta['image'];
					 $title = $entry_meta['title'];
					 $category = $entry_meta['category']; 
					 $description = $entry_meta['description']; 
					 $uploader_obj = get_user_by('id', $entry_values['user_id']);
					 $uploaded_by = ( $uploader_obj->first_name && $uploader_obj->last_name ) ? $uploader_obj->first_name.' '.$uploader_obj->last_name : $uploader_obj->display_name;
					 
		$output .= 			  '<tr>
						<td>
							<a  href="'.esc_url_raw( $img_src ).'" data-lightbox="pop_entry_set" data-title="'.$title.'">
							<img  src="'.esc_url_raw ( $img_src ).'" alt="" />
							</a>
						</td>
						<td>'.$title.'</td> 
						<td>'.$category.'</td>
						<td>'.$description.'</td>
						
						<td>'.$uploaded_by.'</td>
						<td>'.$entry_values['entry_time'].'</td>
					  </tr>';
	}				  
	
	$output .=			'</table>';
	
	
	return $output;
	
}
}