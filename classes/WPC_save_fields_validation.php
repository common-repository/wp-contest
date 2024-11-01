<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: USE FOR VALIDATE ADDITIONAL FIELDS IN WP-ADMIN
*/
if(!class_exists('WPC_save_fields_validation')){
	class WPC_save_fields_validation{
		private $fileds_ids = null, $contest_id  = null, $error = null;
		
	/* 
	* @PARAM $fileds_ids, $contest_id
	*/
	public function __construct( array $fileds_ids, $contest_id){
		$this->fileds_ids = $fileds_ids;
		$this->contest_id = $contest_id;
	}
	
	/*
	* validate addition field added by admin
	*/
	
	public function validation(){
		$fileds_ids  	= $this->fileds_ids;
		$contest_id    =  $this->contest_id;
		if(!wpc_if_contest_exist( sanitize_text_field($contest_id)) ){
			$this->error = 'Contest Not Exist.';
			return false;
		}
		foreach($fileds_ids as $fileds_id){
			$label = $_POST[$fileds_id.'LABEL'];
			$type  = $_POST[$fileds_id.'_TYPE'];
			if($label == '' || empty($label)){
				$this->error = 'Add Label For all Fields';
				return false;
			}
			if($type == 'dropdown' || $type == 'radio'){
				$options =  $_POST[$fileds_id.'OPTION'];
				if($options == '' || empty($options ) || $options == ',' ){
					$this->error = 'Add Option To select/radio Field';
					return false;
				}
			}
		}
		return true; 
	}
	
	// RETURN VALIDATION ERROR
	public function error(){
		return $this->error;
	}
	
	
}
}