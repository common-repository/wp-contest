<?php 
/*  @PACKAGE WP CONTEST
* 	USE: SAVE CONTEST ADDITIONAL FIELDS
*/
if(!class_exists('WPC_save_additional_fields_admin')){
	class WPC_save_additional_fields_admin{
		private $fileds_ids = null, $contest_id  = null;
		public function __construct( array $fileds_ids, $contest_id){
			$this->fileds_ids = $fileds_ids;
			$this->contest_id = $contest_id;
		}
		public function saving(){
			global $wpdb;
			$table_name = $wpdb->prefix . 'wpc_contests';
			$fileds_ids  	= $this->fileds_ids;
			$contest_id    =  $this->contest_id;
			if(!wpc_if_contest_exist($contest_id)){
				
				return false;
			}
			$saving_data = array(); 
			foreach($fileds_ids as $fileds_id){
				$label = $_POST[$fileds_id.'LABEL'];
				$id = $fileds_id;
				$type  = $_POST[$fileds_id.'_TYPE'];
				$data = array();
				$data['label'] = sanitize_text_field($label);
				$data['type'] = sanitize_text_field($type);
				$data['id'] = sanitize_text_field($id);
				if(isset($_POST[$id.'PLACEHOLDER'])){
					$data['placeholder'] = sanitize_text_field($_POST[$id.'PLACEHOLDER']);
				}
				if(isset($_POST[$id.'REQUIRE'])){
					$require = $_POST[$id.'REQUIRE'];
					if($require == 'on'){
						$data['require'] = 'on';
					}else{
						$data['require'] = 'off';
					}
				}
				if($type == 'dropdown' || $type == 'radio'){
					$options =  $_POST[$fileds_id.'OPTION'];
					$data['options'] = sanitize_text_field($options);
				}
				$saving_data[] = $data;	
			}
			if(count($saving_data)){
				$update = $wpdb->update( 
					$table_name, 
					array( 
						'additional_fields' => serialize($saving_data)
					), 
					array( 'id' => (int)$contest_id ), 
					array( '%s' ), 
					array( '%d' ) 
				);
				if($update){ return true; }else{ return false; }
			}
			return false;
		}
		
		
	}
}