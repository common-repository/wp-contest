<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: save phase two voting template 
*/
if(!function_exists('wpc_save_phase_two_criteria')){
function wpc_save_phase_two_criteria(){
	global $wpdb;

	$table_name = $wpdb->prefix . 'wpc_contests';

	if(!current_user_can('manage_options')){

		wp_die('You are not allowed to edit this page.');

	}

	check_admin_referer('wpc_save_phase_two_criteria_verify');
	$contest_id =  sanitize_text_field( $_POST['contest_id'] );
	if(!count($_POST['criterias']) || !count($_POST['grade_names']) ){
		wp_redirect(  esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.absint($contest_id).'&error_criteria='.urlencode('Any Grade or Criteria Not Found') ) );

		exit();
	}
	$voting_criteria = array();
	if(isset($_POST['criterias'])){
		$criterias = $_POST['criterias'];
		foreach($criterias as $criteria){
			if(empty($criteria) || $criteria == ''){
				wp_redirect( esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.absint($contest_id).'&error_criteria='.urlencode('Enter label for all Criteria') ) );

				exit();
			}
		}
		$criterias = array_count_values($_POST['criterias']);
		$all_criteria = array();
		foreach($criterias as $criteria => $criteria_num ){
			$all_criteria[] =  esc_attr( (string)$criteria ) ;
		}
		$voting_criteria['criteria'] = $all_criteria;
	}
	
	if(isset($_POST['grade_names'])){
		$grade_names = $_POST['grade_names'];
		foreach($grade_names as $grade_name){
			if(empty($grade_name) || $grade_name == ''){
				wp_redirect( esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.absint($contest_id).'&error_criteria='.urlencode('Enter all grade name') ) );

				exit();
			}
		}
		$grade_names = array_count_values($_POST['grade_names']);
		$all_grade_name = array();
		foreach($grade_names as $grade_name => $grade_num ){
			$all_grade_name[] = esc_attr( (string)$grade_name );
		}
		$voting_criteria['grades'] = $all_grade_name;
	}
	
	$update = $wpdb->update( 
	$table_name, 
	array( 
		'phase_two_voting_creteria' => serialize($voting_criteria)
		
	), 
	array( 'id' => sanitize_text_field($contest_id )), 
	array( 
		'%s'
		
	), 
	array( '%d' ) 
);

if($update){
	wp_redirect( esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.absint($contest_id).'&success_criteria='.urlencode('Voting criteria saved') ) );

	exit();
}else{
	wp_redirect( esc_url_raw ( get_admin_url().'admin.php?page=wpc_contests&contest_id='.absint($contest_id).'&error_criteria='.urlencode('no changes occer') ) );

	exit();
}	
	
	


	
}
}