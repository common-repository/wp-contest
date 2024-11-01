/*  
* 	@PACKAGE WP CONTEST
*	USE: deelete entry
*/


jQuery(document).ready(function($){
	
		function doConfirm(msg, yesFn, noFn) {
		var confirmBox = $("#confirmBox");
		confirmBox.find(".message").text(msg);
		confirmBox.find(".yes,.no").unbind().click(function () {
			confirmBox.hide();
		});
		confirmBox.find(".yes").click(yesFn);
		confirmBox.find(".no").click(noFn);
		confirmBox.show();
		}
		
			
		var deleteEntry = function(formdata, action){
		
		$.ajax({
			url:Delobj.ajaxurl,
			type:'POST',
			data:{
				action: action,
				data: formdata,
				security:Delobj.security,
				
			},
			success:function(response){
				
					$("p.mdgggg").html(response);
					if(response == 'success'){
					location.reload();
					return;
					}
					console.log(response);
				
			},
			error:function(){
				console.log('Form was not submitted successfully');
			}
			
			
		});
		
	};	
			
			
			
			
		$("form#delete_entry_form").submit(function (event) {
			//console.log('gg');
			event.preventDefault(); 
			var form = $(this);
			doConfirm("Are you sure?", function yes() {
			var formdata = {
				'entry_id': $('#get_entry_id').val()
			}	
			deleteEntry(formdata, 'wpc_delete_entry');	
				
				
			}, function no() {
				event.preventDefault();
			});
		
		});
		//Export admin csv 
		var adminExortEntries = function(fromdata, action){
		$.ajax({
			type:'post',
			url: Delobj.ajaxurl,
			data:{
				action:action,
				data:fromdata,
				security:Delobj.security,
				
				
				
			},
			success:function(response){
				$('.admin_exporting').css('display', 'none');
				if(response == 'failed'){
					$('.admin_export_response').html('<span style="color:red;">Problem Exporting Csv</span>');
					return;
				}
				//pop_generated_table_for_export
				$('.admin_export_response').html(response);
				$("table.pop_generated_table_for_export").tableToCSV();
				//console.log(response);
				
			},
			error:function(response){
				alert(response);
			}
			
			
		});
		}
		$(document.body).on('click', '.pop_admin_exort, .export_winner_only' ,function(event){
			event.preventDefault();
			var all_export_button = $(this);
			var export_winner_only_button = $('.export_winner_only_wrap').find('.export_winner_only').length;
			if(all_export_button.hasClass('has_winners') && !export_winner_only_button){
				var get_contest_id = $('.pop_admin_exort').attr('contest_id');
				$('.export_winner_only_wrap').html('<a href="#" action="winners_only" contest_id="'+get_contest_id+'"  class="btn btn-primary export_winner_only">Export Winners Only</a>');
				return;
			}
			
			var contest_id = all_export_button.attr('contest_id');
			var exportdata = {
				
				'contest_id':contest_id,
				'action':all_export_button.attr('action')
				
				
				
				
				};
			$('.admin_exporting').css('display', 'block');
			adminExortEntries(exportdata, 'wpc_admin_export');
			
		
		});
		
	});