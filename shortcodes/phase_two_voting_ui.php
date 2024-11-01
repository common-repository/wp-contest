<?php /*  * 	@PACKAGE WP CONTEST*	USE: phase two voting shortcode*/if(!function_exists('wpc_phase_two_voting_contest')){function wpc_phase_two_voting_contest($atts, $content = null){	extract(shortcode_atts(array(			'contest_id'=>'0',				),$atts,'wpc_voting_round'));			$output ='';	$contest_id = sanitize_text_field( $contest_id );	if( $contest_id  != '0' ){		if(!is_user_logged_in()){		return 'Sorry, only judges can see this information. If you’re a judge please <a href="'.wp_login_url(get_the_permalink()).'">login</a> and return to this page.';	}	if(count(wpc_get_judges()) > 3 ){		return 'Only 3 judges allowed. Unlimited judges allowed on premium version only.';	}	$current_user = wp_get_current_user();		$all_contest_id = wpc_get_all_contest_id();	$all_entries_id = wpc_entries_eligible_for_phase_two($contest_id);	$WPC_contest_settings = new WPC_contest_settings($contest_id);	$settings = $WPC_contest_settings->WPC_the_contest_settings();	if(!$all_contest_id){		return 'No Contest Found';	}	if(!in_array( $contest_id, $all_contest_id)){		 return 'No Contest Found';	}	if($settings['contest_on_off'] !== 'on'){		return 'This Contest is Not Enable';	}	$arr1 = array('wpc_judge', 'administrator' );	$arr2 = $current_user->roles;	$arr3 = array_intersect($arr1, $arr2);	if(!in_array('wpc_judge', $current_user->roles) && count($arr3) == 0 ){		return 'Sorry, only judges can see this information. If you’re a judge please <a href="'.wp_login_url(get_the_permalink()).'">login</a> and return to this page.';	}		if($settings['current_phase'] != 2){		return 'Voting currently disabled by contest admin.';	}		if(!$all_entries_id){		return 'No entry found, contact admin for more information.';	}		if(!isset($_GET['entry_id'])){			$current_display_entry_id = $all_entries_id[0];					}else{						if(!in_array($_GET['entry_id'], $all_entries_id)){				return 'No Photo Found With This ID ('.$_GET['entry_id'].') For This Contest';			}			$current_display_entry_id = absint($_GET['entry_id']);		}		$entry_values = wpc_get_entry($current_display_entry_id);		$entry_meta = unserialize( $entry_values['entry_meta'] );		$img_src = wpc_upload_dir_url().$entry_meta['image'];		if(in_array('administrator', $current_user->roles)){					$output .= '		<div class="pop_phase_two_voting_wrap">		<h3 class="contest_title">'.wpc_get_contest_title($contest_id).'</h3>			<div class="phase_two_voting_img_wrap">				<img src="'.$img_src.'" alt="" />			</div>			<div class="phase_two_voting_img_info_box">				<h3><b>Entry Number:</b> '.$current_display_entry_id.'</h3>				<h3><b>Title:</b> '.$entry_meta['title'].'</h3>				<h3><b>Category:</b> '.$entry_meta['category'].'</h3>				<h3><b>Description:</b> <span class="des">'.$entry_meta['description'].'</span></h3> 			</div>		</div>';		}		if(in_array('wpc_judge', $current_user->roles)){		$already_voted = wpc_the_image_voted_by_current_judge_in_phase_two($current_display_entry_id, $current_user->ID);				if($already_voted){			$last_vote = wpc_phase_two_image_vote_by_judge($current_display_entry_id, $current_user->ID);			$vote_txt = 'Edit Your Vote. You last given score was <b>('.$last_vote .')</b>';			$editing_input = '<div class="editing_input_wrap"><h3 class="editing_reason_title">Editing Reason</h3><textarea name="editing_reason" id="editing_reason" cols="30" rows="10"></textarea></div>';			$editable = '<input value="true" id="editable" type="hidden" />';		}else{			$vote_txt = 'Vote for this entry';			$editing_input = '';			$editable = '<input value="false" id="editable" type="hidden" />';		}		$yet_vote = wpc_the_judge_total_num_images_yet_to_vote_in_phase_two($contest_id, $current_user->ID);		$voting_criterias = wpc_get_phase_two_voting_criterias($contest_id);		$voting_criterias =  unserialize( $voting_criterias);		$grades =  $voting_criterias['grades'];		$criterias =  $voting_criterias['criteria'];		$grade_to_display = '';		foreach($grades as $grade){			$grade_to_display .= '<th>'.$grade.'</th>';		}				/*=====================		 Voting Display Start		+++++++++++++++++++++++*/		$output .= '<div class="pop_phase_two_voting_wrap"><h3 class="contest_title">'.wpc_get_contest_title($contest_id).'</h3>	<div class="phase_two_voting_img_wrap">		<img src="'.$img_src.'" alt="" />	</div>	<div class="phase_two_voting_img_info_box">		<h3><b>Image Number:</b> '.$current_display_entry_id.'</h3>		<h3><b>Title:</b> '.$entry_meta['title'].'</h3>		<h3><b>Category:</b> '.$entry_meta['category'].'</h3>		<h3><b>Description:</b> <span class="des">'.$entry_meta['description'].'</span></h3> 	</div>	<div class="phase_two_voting_btns_wrap">		<div class="vt_text">'.$vote_txt.'</div>		<form class="phase_two_voting_form" method="post" action="">			<div class="phase_two_voting_error"></div>		<table class="phase_two_voting_table">			<tr>				<th>					&nbsp;				</th>				'.$grade_to_display.'			</tr>';foreach($criterias as $criteria){	$criteria_name = 	wpc_stripout_spcl_char($criteria);	$criteria_name =  str_replace(" ","", $criteria_name);$output .='<tr class="'.$criteria_name.'">				<td>					'.$criteria.':				</td>				<td>					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="1" />1 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="2" />2 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="3" />3 				</td>				<td>					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="4" />4 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="5" />5 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="6" />6 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="7" />7 				</td>				<td>					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="8" />8 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="9" />9 					<input name="'.$criteria_name.'" id="'.$criteria_name.'" type="radio" value="10" />10									</td>							</tr>';			}			$output .='<tr><td colspan="4">'.$editing_input.'</td></tr>																				</table>		<input id="phaseTWoentry_id" value="'.$current_display_entry_id.'" type="hidden" />		<input id="phaseTWocontest_id" value="'.$contest_id.'" type="hidden" />			'.$editable.'		<div class="phase_two_vt_btn">						<input  class="vote_for_phase_two" type="submit" Value="Vote" />		</div>		<div class="phase_two_voting_info">			<h3><b>Total Number Of Image To Vote:</b> '.count($all_entries_id).'</h3>			<h3><b>Total Number Images Yet To Vote:</b> '.$yet_vote.'</h3>		</div>		</form>	</div></div>';		}								$output .= wpc_entry_pagination($all_entries_id, $current_display_entry_id, $contest_id);	}		return $output;}}