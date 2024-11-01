<?php 
/*  
* 	@PACKAGE WP CONTEST
*	USE: function for add field
*/
if(!function_exists('wpc_get_add_field_markup')){
function wpc_get_add_field_markup(){
	$fields = array(
		'text' => '<div id="__FIELDS_ID__" class="singel_field">
					 <div class="field_validation_msg"></div>
					 <div  class="singel_field_remove">+</div>
					  <div class="field_type_title">
						Text
					  </div>
					  <div class="field_label">
						<b  class="min-width-100"  >Label:</b> <input value="__LABEL_VALUE__" name="__FIELDS_ID__LABEL" class="pop_input_label" value="" type="text" />
					  </div>
					  <div class="fields_setting_section">
						<div class="fields_setting_values">
							<b class="min-width-100" >Placeholder:</b> <input value="__PLACEHOLDER_VALUE__" name="__FIELDS_ID__PLACEHOLDER" class="pop_input_placeholder" type="text" />
						</div>
						<div class="fields_setting">
							<h6>Settings:</h6>
							<input __REQUIRE_VALUE__  name="__FIELDS_ID__REQUIRE" class="pop_input_require" type="checkbox" />Require
						</div>
					  </div>
					  __FIELDS_DETAILS__
					</div>',
	'number' => '<div id="__FIELDS_ID__" class="singel_field">
					 <div class="field_validation_msg"></div>
					 <div  class="singel_field_remove">+</div>
					  <div class="field_type_title">
						Number
					  </div>
					  <div class="field_label">
						<b  class="min-width-100"  >Label:</b> <input value="__LABEL_VALUE__"  name="__FIELDS_ID__LABEL" class="pop_input_label" value="" type="text" />
					  </div>
					  <div class="fields_setting_section">
						<div class="fields_setting_values">
							<b class="min-width-100" >Placeholder:</b> <input value="__PLACEHOLDER_VALUE__"  name="__FIELDS_ID__PLACEHOLDER" class="pop_input_placeholder" type="text" />
						</div>
						<div class="fields_setting">
							<h6>Settings:</h6>
							<input __REQUIRE_VALUE__  name="__FIELDS_ID__REQUIRE" class="pop_input_require" type="checkbox" />Require
						</div>
					  </div>
					  __FIELDS_DETAILS__
					</div>',
	'dropdown' => '<div id="__FIELDS_ID__" class="singel_field">
					 <div class="field_validation_msg"></div>
					 <div  class="singel_field_remove">+</div>
					  <div class="field_type_title">
						Dropdown
					  </div>
					  <div class="field_label">
						<b  class="min-width-100"  >Label:</b> <input value="__LABEL_VALUE__"  name="__FIELDS_ID__LABEL" class="pop_input_label" value="" type="text" />
					  </div>
					  <div class="fields_setting_section">
						<div class="fields_setting_values">
							
							<b  class="min-width-100" >Options:</b> <span field_id="__FIELDS_ID__">+</span><br />
							<h6>Add Option separetd by comma</h6>
							<input id="field_pots" name="__FIELDS_ID__OPTION"  value="__OPTION_VALUE__"  type="text" />
							
						</div>
						<div class="fields_setting">
							<h6>Settings:</h6>
							<input __REQUIRE_VALUE__  name="__FIELDS_ID__REQUIRE" class="pop_input_require" type="checkbox" />Require
						</div>
					  </div>
					  __FIELDS_DETAILS__
					</div>',
	'radio' => '<div id="__FIELDS_ID__" class="singel_field">
					<div class="field_validation_msg"></div>
					<div  class="singel_field_remove">+</div>
					  <div class="field_type_title">
						Radio
					  </div>
					  <div class="field_label">
						<b  class="min-width-100"  >Label:</b> <input value="__LABEL_VALUE__"  name="__FIELDS_ID__LABEL" class="pop_input_label" value="" type="text" />
					  </div>
					  <div class="fields_setting_section">
						<h6>Add Option separetd by comma</h6>
							<input  id="field_pots"  name="__FIELDS_ID__OPTION" value="__OPTION_VALUE__" type="text" />
							
						<div class="fields_setting">
							<h6>Settings:</h6>
							<input  __REQUIRE_VALUE__ name="__FIELDS_ID__REQUIRE" class="pop_input_require" type="checkbox" />Require
						</div>
					  </div>
					  __FIELDS_DETAILS__
					</div>',
	'checkbox' => '<div id="__FIELDS_ID__" class="singel_field">
					 <div class="field_validation_msg"></div>
					 <div  class="singel_field_remove">+</div>
					  <div class="field_type_title">
						Checkbox
					  </div>
					  <div class="field_label">
						<b  class="min-width-100"  >Label:</b> <input  value="__LABEL_VALUE__" name="__FIELDS_ID__LABEL" class="pop_input_label" value="" type="text" />
					  </div>
					  <div class="fields_setting_section">
						
						<div class="fields_setting">
							<h6>Settings:</h6>
							<input __REQUIRE_VALUE__ name="__FIELDS_ID__REQUIRE" class="pop_input_require" type="checkbox" />Require
						</div>
					  </div>
					  __FIELDS_DETAILS__
					</div>',
	
	
	);
	
	return apply_filters('wpc_add_field_markup', $fields );
	
	
	
	
}
}