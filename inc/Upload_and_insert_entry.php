<?php /*  @PACKAGE WP CONTEST* 	USE: Insert and Upload entry, redirect tp paypal  if contest type is paid.*	*/if(!function_exists('wpc_upload_insert_entry')){function wpc_upload_insert_entry(){						if(isset($_POST['pop_submit'])){			global $wpdb;			$table_name = $wpdb->prefix . 'wpc_entry';						//INIT VALIDATION CLASS			$WPC_Validation = new WPC_Validation();			$popfilevalidation = $WPC_Validation->wpc_upload_validation($_FILES['pop_images']);						// SUMITTED VALUES			$contest_id = sanitize_text_field( $_POST['contest_id'] );			$title = $_POST['title'];			$category = $_POST['category'];			$description = $_POST['description'];						//GETTING GENERAL SETTINGS			$general_settings = get_option( 'wpc_general_settings' );						//GETTING GENERAL SETTINGS			$WPC_contest_settings = new WPC_contest_settings( absint($contest_id) );			$contest_settings = $WPC_contest_settings->WPC_the_contest_settings();						// UPLOADING FILES AFTER PASS VALIDATION			if($popfilevalidation == true){				if ( ! function_exists( 'wp_handle_upload' ) ) {					require_once( ABSPATH . 'wp-admin/includes/file.php' );				}else{					wp_redirect( esc_url( wpc_get_pages_link($general_settings['failed_payment_page']) ) );						exit();				}				$files = $_FILES['pop_images'];				$successful_uploads = array();				$failed_uploads = array();				$insert_failed  = array();				$insert_success  = array();				$separate_files_array = array();				$ii = 0;				foreach( $files['name'] as $Fiels_name){								foreach($files  as $key => $value ){					$separate_files_array[$ii][$key] = $value[$ii];								}				$ii++;				}								foreach($separate_files_array as $single_file ){					$upload_overrides = array( 'test_form' => false );					$movefile = wp_handle_upload( $single_file, $upload_overrides );					if ( $movefile && ! isset( $movefile['error'] ) ) {						$successful_uploads[] = $movefile['url'];					} else {												$failed_uploads[] = $single_file['name'];					}									}																//when all uploaded successfully				if(count($failed_uploads) == 0 && count($successful_uploads) > 0 ){					if($contest_settings['contest_type'] !== 'paid'){																																									//INSERT ENTRY VALUES when contest is free						foreach($successful_uploads as $pos => $successful_upload ){							$insert_values = array();							$entry_meta = array();							$insert_values['contest_id'] = sanitize_text_field( $contest_id );							$insert_values['user_id'] = get_current_user_id();							$entry_meta['title'] = sanitize_text_field( $title[$pos] );							$entry_meta['category'] = sanitize_text_field( $category[$pos] );							$entry_meta['description'] = sanitize_text_field( $description[$pos] );							$entry_meta['image'] = esc_url_raw( $successful_upload );							$insert_values['entry_meta'] = serialize($entry_meta);							$insert_values['payment_id'] = 'NULL';							$format = array('%d', '%d', '%s', '%s');							//CONTEST HAS ADDTIONAL FIELDS 							if(wpc_get_addtional_field_by_contest_id($contest_id)){								$addtional_fields_value = array();								$addtional_fields = wpc_get_addtional_field_by_contest_id($contest_id);																if( !empty($addtional_fields) && $addtional_fields != '' ){									$addtional_fields = unserialize($addtional_fields);									foreach($addtional_fields as $addtional_field){									$id = $addtional_field['id'];										if(isset($_POST[$id])){											$addtional_fields_value[$id] = sanitize_text_field( $_POST[$id][$pos] );																					}									}								}																if(count($addtional_fields_value) >= 1){									$addtional_fields_value = serialize($addtional_fields_value);																		$insert_values['additional_fields'] = $addtional_fields_value;									$format[] = '%s';																	}							}							//IF INSET IN DB IS FAILED							if(!wpc_db_inserts( $table_name, $insert_values, $format  )){								$insert_failed[$successful_upload];							}else{								$insert_success[$successful_upload];							}						} 																																																																							}else{						$_POST['insert_upload_msg'] = __('Paid entry not allowed.', 'wpc');					}				}else{					$_POST['insert_upload_msg'] = __('Error moving files', 'wpc');				}								if(count($insert_failed) == 0){										if($contest_settings['contest_type'] !== 'paid' ){						wp_redirect( esc_url( wpc_get_pages_link( $general_settings['success_payment_page'] ) ) );						exit();					}														}else{					//error throw if all all emtries not inserted to DB					$_POST['insert_upload_msg'] = 'Insert upload Field';				}			}		}	}}	