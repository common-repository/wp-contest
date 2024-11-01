<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: Add addition fields to a contest
*/
if(!function_exists('wpc_add_field')){
function wpc_add_field(){
	$data = $_POST['data'];
	$security = $_POST['security'];
	$type    = sanitize_text_field( $data['field_type'] );
	$field_markup = wpc_get_add_field_markup();
	$uniqid =  md5(uniqid(time(), true));
	
	if(!check_ajax_referer('fields-sequirity-nonce','security')){
		wp_send_json('');
	}
	
	if( !current_user_can('manage_options') ){
		wp_send_json('');
			
	}
	
	if(!array_key_exists($type, wpc_load_field_type())){
		wp_send_json('');
	}
	$markup = $field_markup[$type];
	$field_details = '
						<input id="field_type" value="'.$type.'" name="'.$uniqid.'_TYPE" type="hidden" />
						<input name="field_id[]" value="'.$uniqid.'" type="hidden" />
						
					';
	$markup = str_replace("__REQUIRE_VALUE__", '', $markup);
	$markup = str_replace("__OPTION_VALUE__", 'Option Value', $markup);
	$markup = str_replace("__LABEL_VALUE__", '', $markup);
	$markup = str_replace("__PLACEHOLDER_VALUE__", '', $markup);
	$markup = str_replace("__FIELDS_DETAILS__", $field_details, $markup);
	$markup = str_replace("__FIELDS_ID__", $uniqid, $markup);
	
	wp_send_json($markup);
	die();
}
}