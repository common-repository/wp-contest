<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE TO DELETE ENTRY
*/
if(!class_exists('WPC_Admin_export_entry')){
	class WPC_Admin_export_entry{
		private $_contest_id = null;
		
		public function __construct($contest_id){
			$this->_contest_id = $contest_id;
			
		}
		
		public function WPC_get_entry_table($action){
			$contest_id = $this->_contest_id;
			$all_entries_id = wpc_get_all_paid_entry_id_by_contest_id($contest_id);
			if($action == 'winners_only'){
				
				$winners = get_option( 'wpc_winner_list_'.$contest_id );
				$all_entries_id = array_intersect($winners, $all_entries_id);
			}
			if(!$all_entries_id){ return false; }
			$table = '
			<table style="display:none" class="pop_generated_table_for_export" style="width:100%">
			<tr>
			<th>Photo ID</th>
			<th>Winner</th> 
			<th>Paid / Free</th>
			<th>Submitted Date / Time</th>
			<th>Contestant First Name</th>
			<th>Contestant Last Name</th>
			<th>Entry Title</th>
			<th>Entry Category</th>
			<th>Entry Description</th>
			<th>Link to entry</th>
			<th>Additional Fields</th>';
			if(WPC_get_judges_names()){
				foreach(WPC_get_judges_names() as $key => $val){
					$table .= "<th>".$val." score</th>";
				}
			}
			$table .=				'<th>Total Socre</th>
			</tr>
			';
			foreach($all_entries_id as $entry_id){
				$entry_values = wpc_get_entry($entry_id);
				$entry_meta = unserialize( $entry_values['entry_meta'] );
				$img_src = wpc_upload_dir_url().$entry_meta['image'];
				$title = $entry_meta['title'];
				$category = $entry_meta['category']; 
				$description = $entry_meta['description']; 
				if(get_option( 'wpc_winner_list_'.$contest_id )){  if(in_array($entry_id, get_option( 'wpc_winner_list_'.$contest_id ))){$winner = 'Y'; }else{ $winner = 'N'; }  }else{ $winner = 'N';} 
				$paid_or_free = $entry_values['payment'] == '1' ? 'Paid' : 'Not Paid';
				$first_name = get_userdata( $entry_values['user_id'] )->first_name ? get_userdata( $entry_values['user_id'] )->first_name : 'No First Name Found';
				$last_name = get_userdata( $entry_values['user_id'] )->last_name ? get_userdata( $entry_values['user_id'] )->last_name : 'No Last Name Found';
				$table .= '<tr> 
				<td>'.$entry_id.'</td>
				<td>'.$winner.'</td>
				<td>'.$paid_or_free.'</td>
				<td>'.$entry_values['entry_time'].'</td>
				<td>'.$first_name.'</td>
				<td>'.$last_name.'</td>
				<td>'.$entry_meta['title'].'</td>
				<td>'.$entry_meta['category'].'</td>
				<td>'.$entry_meta['description'].'</td>
				<td>'.esc_url_raw( $img_src ).'</td>';
				$adttionl_values = $entry_values['additional_fields'];			
				if($adttionl_values){
					$addtional_fields = wpc_get_addtional_field_by_contest_id($contest_id);
					if( !empty($addtional_fields) && $addtional_fields != '' ){
						$addtional_fields = unserialize($addtional_fields);
						$adttionl_values = unserialize($adttionl_values);
						$addition_val = '';
						foreach($addtional_fields as $addtional_field){
							$id = $addtional_field['id'];
							$label = $addtional_field['label'];
							$addition_val .=  $label.' : '.(isset($adttionl_values[$id]) ? $adttionl_values[$id] : '' );
							
						}
						
						
					}else{
						$addition_val = 'No Addition Value Found.';
					}			
					
					
				}else{
					$addition_val = 'No Addition Value Found.';
				}				
				$table .= '<td>'.$addition_val.'</td>';				
				
				if(WPC_get_judges_names()){
					foreach(WPC_get_judges_names() as $key => $val){
						$judge_score = wpc_get_judge_score_entry($key, $entry_id) ? wpc_get_judge_score_entry($key, $entry_id) : 'Not Scored' ;
						$table .= '<td>'.$judge_score.'</td>';
					}
				}
				if( wpc_get_score($entry_id) && (wpc_get_score($entry_id) !== 0) ){

					$score = wpc_get_score($entry_id);

					

				}else{

					$score = "Not Scored Yet";

					

				}
				$table .=				'<td>'.$score.'</td>
				</tr>';
				
				
			}
			$table .= '</table>';
			return $table;
			return false;
		}
		
		
		
	}
}