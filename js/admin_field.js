/*  
* 	@PACKAGE WP CONTEST
*	USE: Add admin field and validation
*/

jQuery(document).ready(function($){
	$(document.body).on('click', '.singel_field_remove', function(){
		var target =  $(this).parent();
		target.fadeOut(300, function(){ 
			target.remove();
		});
	});	
	
	$('#pop_addtional_fields_sortable').sortable();
	// add field 
	
	$(document.body).on('click', 'button.pop__field', function(event){
		 event.preventDefault();
		var that = $(this);
		var popAddFieldProcess = function(formdata, action){
		
		$.ajax({
			url:fieldObj.url,
			type:'POST',
			data:{
				action: action,
				data: formdata,
				security:fieldObj.security,
				
			},
			success:function(response){
				
					$(".addtional_fields").append(response);
					
				
			},
			error:function(){
				$(".fields_validation").html('Some problem Found');
			}
			
			
		});
		
	}
	var formdata = {
				'field_type':that.attr('field_type'),
				
				
		};
	
	popAddFieldProcess(formdata, 'wpc_add_field' );
	
	
	});
	
	
	$(document.body).on('click', 'input#pop_field_submit', function(event){
		
			$(".singel_field").each(function(){
				var that =  $(this);
				var type =  that.find('#field_type').attr('value');
				var label = that.find('.pop_input_label').attr('value');
				if(!label || label == '' ){
					that.css('border', '1px solid red');
					that.find('.field_validation_msg').html('<span style="color:red;">Please Add Label.</span>');
					event.preventDefault();
					return;
				}
				if(type == 'radio' || type == 'dropdown'){
					var _option = that.find('#field_pots').attr('value'); 
					if( !_option || _option == '' ){
					that.css('border', '1px solid red');
					that.find('.field_validation_msg').html('<span style="color:red;">Please Add Option.</span>');
					event.preventDefault();
					return;
					}
				}
				
			});
		
		
	});
	
	
	
	
	
	
	
});