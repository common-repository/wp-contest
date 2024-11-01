<?php
/*
	* 	@PACKAGE WP CONTEST
	*	USE: ENTRIES PAGE CONTENT
*/
?>
<div class="wrap">
	<div class="row">
		<?php
		if(isset($_GET['entry_id']) && isset($_GET['contest_id'])  ) {
			$contest_id = $_GET['contest_id'];
			$all_entries_id = wpc_get_all_paid_entry_id_by_contest_id($_GET['contest_id']);
			if(in_array( $_GET['entry_id'], $all_entries_id)){
							$entry_id = $_GET['entry_id'];
							$entry_values = wpc_get_entry($entry_id);
							$entry_meta = unserialize( $entry_values['entry_meta'] );
							$img_src = wpc_upload_dir_url().$entry_meta['image'];
							$title = $entry_meta['title'];
							$category = $entry_meta['category'];
							$description = $entry_meta['description'];
							$adttionl_values = $entry_values['additional_fields'];
							echo '<div style="padding:40px;" class="row">
											<h2>Entry ID:'.$entry_id.'</h2>
											<img style="width:400px; display:block;" src="'.$img_src.'" alt="" />
											<h2>Title: '.$title.'</h2>
											<h2>Category: '.$category.'</h2>
											<h2>Description: '.$description.'</h2>
									</div>';
							
							if($adttionl_values){
							$addtional_fields = wpc_get_addtional_field_by_contest_id($contest_id);
							if( !empty($addtional_fields) && $addtional_fields != '' ){
								$addtional_fields = unserialize($addtional_fields);
								$adttionl_values = unserialize($adttionl_values);
								echo '<div style="padding:40px;"  class="">';
									foreach($addtional_fields as $addtional_field){
									$id = $addtional_field['id'];
									$label = $addtional_field['label'];
									echo '<h2  ><b>'.$label.'</b>: '.(isset($adttionl_values[$id]) ? $adttionl_values[$id] : '' ).'</h2>';
									
									}
								echo '</div>';
							
							}
							
							}
				
				
				
			}
			
			
			
			
		}elseif(isset($_GET['contest_id'])){
			$contest_id = sanitize_text_field( $_GET['contest_id'] );
			$all_entries_id = wpc_get_all_paid_entry_id_by_contest_id($contest_id);
			if($all_entries_id){
		?>
		<div class="row" style="
			background: #0073aa;
			padding: 8px 20px;
			color: #fff;
			text-transform: uppercase;
			font-weight: 900;
			font-size: 15px;
			margin-bottom:20px;
			text-align:center;
			">	<div style="" id="confirmBox">
				<div class="message"></div>
				<span class="button yes">Yes</span>
				<span class="button no">No</span>
			</div>
			<div class="col-md-2">Entry</div>
			<div class="col-md-1">Title</div>
			<div class="col-md-1">Category</div>
			<div class="col-md-2">Description</div>
			<div class="col-md-1">Payment</div>
			<div class="col-md-2">Time</div>
			<div class="col-md-1">View</div>
			<div class="col-md-1">Winner</div>
			<div class="col-md-1">Delete</div>
		</div>
		<p class="mdgggg"></p>
		<?php
		foreach($all_entries_id as $entry_id ){
					$entry_values = wpc_get_entry($entry_id);
					$entry_meta = unserialize( $entry_values['entry_meta'] );
					$img_src = wpc_upload_dir_url().$entry_meta['image'];
					$title = $entry_meta['title'];
					$category = $entry_meta['category'];
					$description = $entry_meta['description'];
					if(get_option( 'wpc_winner_list_'.$contest_id )){  if(in_array($entry_id, get_option( 'wpc_winner_list_'.$contest_id ))){$winner = '<i class="fa fa-star"></i>'; }else{ $winner = '&nbsp;'; }  }else{ $winner = '&nbsp;';}
			
				echo 	'<div style="text-align:center; border: 1px solid #000; margin: 10px 0; padding: 10px;" class="row">
						<div class="col-md-2"><img style="width: 100px;" src="'.$img_src.'" alt="" /></div>
						<div class="col-md-1">'.$title.'</div>
						<div class="col-md-1">'.$category.'</div>
						<div class="col-md-2">'.$description.'</div>
						<div class="col-md-1">'.($entry_values['payment'] == '1' ? 'Paid' : 'Not Paid').'</div>
						<div class="col-md-2">'.$entry_values['entry_time'].'</div>
						<div class="col-md-1"><a href="'.get_admin_url().'admin.php?page=wpc_entries&contest_id='.$contest_id.'&entry_id='.$entry_id.'">View</a></div>
						<div class="col-md-1">'.$winner.'</div>
						<div class="col-md-1"><form method="post" action="" id="delete_entry_form"><input value="'.$entry_id.'" id="get_entry_id" type="hidden"  /><input id="delete_entry_submit" name="delete_entry_submit" value="Delete" type="submit" /></form></div>
					</div>
				
				';
		
		
		
		}
		?>
		<!-- EXPORT ENTRIES -->
		<div class="row">
			<div class="admin_exporting">Exporting. It may take few mintue.</div>
			<div style="margin-left:30px;" class="col-md-12">
				<p class="admin_export_response"></p>
				<?php	$winners_option_key = 'wpc_winner_list_'.$contest_id;
				if(!get_option( $winners_option_key )){
				$winner = '';
				}else{
				$winners_entry_array = get_option( $winners_option_key );
				if(count($winners_entry_array) > 1 ){
				$winner = 'has_winners';
				}else{
				$winner = '';
				}
				}
				
				
				
				
				?>
				<a href="#" action="all" contest_id="<?php echo $contest_id; ?>" class="btn btn-primary pop_admin_exort <?php echo $winner; ?>">Export All Entries</a> <span class="export_winner_only_wrap"></span>
				<?php
				$WPC_Admin_export_entry = new WPC_Admin_export_entry($contest_id);
				
								//echo 	$WPC_Admin_export_entry->WPC_get_entry_table();
				//echo '<pre>';
					//var_dump( WPC_get_judges_names());
					?>
				</div>
			</div>
			
			
			<!-- EXPORT ENTRIES END -->
			
			
			
			<?php
			}
			
			}else{
			echo '<h1>Select a contest : </h1>';
			if(wpc_get_all_contest_id()){
			foreach(wpc_get_all_contest_id() as $contest_id ){
			echo '<h3 style="font-size: 1em;"><a href="'.get_admin_url().'admin.php?page=wpc_entries&contest_id='.$contest_id.'">'.wpc_get_contest_title($contest_id).'</a></h3>';
			}
			}else{
			echo '<h1>No Contest Found</h1>';
			}
			
			
			}
			?>
		</div>
	</div>