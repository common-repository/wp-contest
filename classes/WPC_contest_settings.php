<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE FOR GET CONTEST SETTINGS
*/
if(!class_exists('WPC_contest_settings')){
	class WPC_contest_settings{
		private $_contest_settings = null;
		
	/*
	* @param $contest_id
	*/
	public function __construct(  $contest_id){
		global $wpdb;
		$contest_id = sanitize_text_field( $contest_id );
		$settings = array();
		
		$table_name = $wpdb->prefix . 'wpc_contests';
		$all_settings = $wpdb->get_row(
			"SELECT * FROM $table_name WHERE id='$contest_id' ", 
			
			ARRAY_A
		);
		
		if($all_settings){
			if($all_settings['fields']){
				$settings = unserialize($all_settings['fields']);
				unset($all_settings['fields']);
			}
			foreach($all_settings as $key => $val){
				
				$settings[$key] = $val;
				
			}
		}
		if(count($settings)){
			$this->_contest_settings = $settings;
			
			
		}
		
	}
	// RETURN CONTEST SETTINGS
	public function WPC_the_contest_settings(){
		return $this->_contest_settings;
	}
	
}
}