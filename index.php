
<?php
	
/*==========================================================================
 * Copyright (c) 2020 
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

	/* INCLUDE INITIALIZATION FILE */
	require_once __DIR__ . '/admin/core/init.core.php';

	/* INITIATE DB CLASS */
	try {
		$db = DB::getInstance();
		$data = $db->get('upload_settings', array('id', '=', 1))->first();
		$data_google = $db->get('configs_google', array('id', '=', 1))->first();
	} catch (Throwable $e) {
		header('Location: ' . 'notification.php');
	}
	
	
?>


<!DOCTYPE html>
<html lang="en">
<head>


	<!-- GENERAL METAS -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />

	<!-- WEBSITE TITLE -->
	<title><?= escape($data->title); ?></title>


	<!-- INCLUDE CSS FILES -->
	<link rel="stylesheet" href="admin/assets/client/css/bootstrap.min.css">
	<link rel="stylesheet" href="admin/assets/client/css/filepond.css">	
	<link rel="stylesheet" href="admin/assets/client/css/awselect.css">	
	<link rel="stylesheet" href="admin/assets/client/css/all.min.css">
	<link rel="stylesheet" href="admin/assets/client/css/styles.css">
	<link rel="stylesheet" href="admin/assets/client/css/responsive-styles.css">

	
	<!-- INCLUDE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
	
	
	<!-- JS FILES FOR PRELOAD CHECK-->
	<script src="admin/assets/client/js/jquery-3.5.1.min.js"></script>
	<script src="admin/assets/client/js/modernizr.js"></script>
	

	<!-- PRELOAD CHECK -->
	<script>
		$(window).on("load", function() {

			$(".se-pre-con").fadeOut("slow");
			
		});
	</script>

	
</head>
<body>
	

	<!-- PRELOAD CHECK -->
	<div class="se-pre-con"></div>


	<!-- MAIN SECTION -->
	<section>

			<div class="container">

				
				<!-- SECTION TITLE -->
				<div class="text-center">
		
					<div class="form-title">
						<h3><span><?= escape($data->title); ?></span></h3>
						<div><?= html_entity_decode($data->description); ?></div>						
					</div>

				</div> <!-- END SECTION TITLE -->

						

				<!-- UPLOAD FILE FORM -->
				<form id="multipartupload" action="" method="post" enctype="multipart/form-data" onsubmit="uploadFiles(event)">
					
					<div class="row">
						

						<!-- PLACEHOLDER FOR GOOGLE ADWORDS -->
						<div class="col-sm-12 col-md-3 col-lg"><?= html_entity_decode($data_google->adsense_left); ?></div>

						
						<!-- FILE TRANSFER -->
						<div class="col-sm-12 col-md-6 col-lg-5">

							<div class="form-wrapper">
								

								<!-- CONAINER FOR ALL INPUT FIELDS-->
								<div id="main-input-container">


									<!-- ADDITIONAL SETTINGS BUTTON-->
									<a id="settings" data-toggle="modal" data-target="#modalCenter"><i class="fas fa-sliders-h"></i></a>
									

									<!-- DRAG & DROP FILE UPLOAD BOX -->
									<div class="select-file">
										<p id="filepond-warning"></p>
										<input type="file" name="filepond[]" id="filepond" class="filepond"  multiple  required  />	

									</div>
									

									<!-- EMAIL FIELDS BOX -->
									<div id="email-box">
										

										<!-- SEND TO EMAIL ADDRESS (REQUIRED)  -->
										<div class="form-group" id="email-container">

										    <label for="send-to" class="control-label">Send To</label>
										    <div class="input-group email-group">
											    <input type="email" class="form-control" name="send-to[]" id="send-to" placeholder="Receiver's Email Address" novalidate>
											    <div class="input-group-append">
													<button class="btn btn-email-option add-email" type="button" data-toggle="tooltip" data-placement="top" title="Include new Email Address"><i class="fas fa-plus"></i></button>
												</div>
											</div>
											<span id="receiver-error"></span>

										 </div> 


										 <!-- FROM EMAIL ADDRESS (REQUIRED) -->
										<div class="form-group">

										    <label for="send-from" class="control-label">Send From</label>    
											<input type="email" class="form-control" id="send-from" name="send-from" placeholder="Your Email Address" novalidate>
											<span id="sender-error"></span>		

										 </div>
										

										<!-- MESSAGE (OPTIONAL) -->
										 <div class="form-group">

										    <label for="form-content">Message</label>
										    <textarea class="form-control" id="message" rows="6" name="message" placeholder="Notes for the Receiver (Optional)"></textarea>

										 </div>													
									
									</div> <!-- END EMAIL FIELDS BOXR -->

									
									<!-- FILE UPLOAD BUTTON -->
									<div class="form-submit-button text-center form-group">

										<button class="btn btn-primary ripple" type="submit" id="submit" name="submit">Upload & Share</button>

									</div>

								</div> <!-- END CONAINER FOR ALL INPUT FIELDS-->

								

								<!-- CONAINER FOR ALL UPLOAD PROCESSING FIELDS-->
								<div id="upload-process">

									<!-- FILE UPLOAD PROGRESS BOX -->
									<div id="upload-box">

										<h6 class="text-center">File Upload Status</h6>

										<div id="upload-status"></div>

									</div>
									

								</div> <!-- END CONAINER FOR ALL UPLOAD PROCESSING FIELDS-->

								

								<!-- CONAINER FOR FINAL RESULTS-->
								<div id="upload-results">

									<!-- CONTAINER TITLE AND LOGO -->
									<div id="upload-results-title">
										<i class='fab fa-staylinked'></i>
										<h5 id="final-email-status"></h5>
									</div>

									
									<!-- FILE UPLOAD STATUS MESSAGES -->
									<div id="final-message" class="text-center">
										<span></span>
									</div>	
									

									<div id="files-data"></div>


									<div class="form-group" id="link-container"></div>


									<!-- NEW FILE UPLOAD BUTTON -->
									<div class="form-submit-button text-center form-group">										
										<button class="btn btn-primary ripple" onclick="sendNewFile()" type="button">Share New Files</button>	
									</div>

								</div> <!-- END CONAINER FOR FINAL RESULTS-->

					
							</div> <!-- END FORM WRAPPER -->



							<!-- ADDITIONAL SETTINGS MODAL -->
							<div class="modal fade" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

							  	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
								    <div class="modal-content">


										<!-- MODAL TITLE -->
								      	<div class="modal-header">
								        	<h5 class="modal-title" id="exampleModalLongTitle">Upload Settings</h5>
								        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          		<span aria-hidden="true">&times;</span>
								        	</button>
								      	</div>

										
										<!-- MODAL MAIN BODY -->
								      	<div class="modal-body">
								      		

								      		<!-- SHARE VIA EMAIL OR LINK -->
								      		<div id="share-type">
								      			
								      			<h6 class="option-title">Share Type <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Send your download link via email or get a download link immediately"></i></h6>

												<div class="slider-checkbox">
												    <input type="radio" name="link-options" id="enable-email" <?php if ($data->share_type == 'email') echo ' checked="checked"'; ?> onclick="sendOptions()"/>
												    <label class="label" for="enable-email">Email</label>
												 </div>

												 <div class="slider-checkbox">
												    <input type="radio" name="link-options" id="enable-link" <?php if ($data->share_type == 'link') echo ' checked="checked"'; ?> onclick="sendOptions()" />
												    <label class="label" for="enable-link">Link</label>
												</div>

								      		</div> <!-- END SHARE VIA EMAIL OR LINK -->

											
											<!-- GENERATE PRIVATE SIGNED LINK WITH CUSTOM DURATION -->
								      		<div id="private-link">
								      			
								      			<h6 class="option-title">Private Signed Link <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Create Signed Pivate Download Links for your files with custom expire time"></i></h6>

								      			<div class="slider-checkbox">
											    	<input type="checkbox" id="enable-private-link" <?= ($data->signed_link == 'enabled') ? 'checked' : ''; ?> />
											    	<label class="label" id="private-link-label" for="enable-private-link"><?= ($data->signed_link == 'enabled') ? 'Enabled' : 'Disabled'; ?></label>   	
											  	</div>

											  	<select id="timer" name="timer" data-placeholder="Expires After:">
													<option value="1" <?php if ($data->signed_link_expiration == 1) echo ' selected="selected"'; ?>>1 Hour</option>
													<option value="6" <?php if ($data->signed_link_expiration == 6) echo ' selected="selected"'; ?>>6 Hours</option>
													<option value="12" <?php if ($data->signed_link_expiration == 12) echo ' selected="selected"'; ?>>12 Hours</option>
													<option value="24" <?php if ($data->signed_link_expiration == 24) echo ' selected="selected"'; ?>>1 Day</option>
													<option value="48" <?php if ($data->signed_link_expiration == 48) echo ' selected="selected"'; ?>>2 Days</option>
													<option value="72" <?php if ($data->signed_link_expiration == 72) echo ' selected="selected"'; ?>>3 Days</option>
													<option value="96" <?php if ($data->signed_link_expiration == 96) echo ' selected="selected"'; ?>>4 Days</option>
													<option value="120" <?php if ($data->signed_link_expiration == 120) echo ' selected="selected"'; ?>>5 Days</option>
													<option value="144" <?php if ($data->signed_link_expiration == 144) echo ' selected="selected"'; ?>>6 Days</option>
													<option value="168" <?php if ($data->signed_link_expiration == 168) echo ' selected="selected"'; ?>>1 Week</option>
												</select>

								      		</div> <!-- END GENERATE PRIVATE SIGNED LINK WITH CUSTOM DURATION -->


											<!-- CUSTOMIZE FILE UPLOAD CHUNK SIZE -->
								      		<div id="chunk-size">
								      			
								      			<h6 class="option-title">Multipart Chuck Size <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="You can customize file chucks as needed, larger files recommended to have larger file chunks"></i></h6>
								      			<select id="chunk" name="chunk" data-placeholder="Select Chuck Size:">
								      				<option value="5" <?php if ($data->chunk_size == 5) echo ' selected="selected"'; ?>>5MB</option>
								      				<option value="10" <?php if ($data->chunk_size == 10) echo ' selected="selected"'; ?>>10MB</option>
													<option value="20" <?php if ($data->chunk_size == 20) echo ' selected="selected"'; ?>>20MB</option>
													<option value="50" <?php if ($data->chunk_size == 50) echo ' selected="selected"'; ?>>50MB</option>
													<option value="100" <?php if ($data->chunk_size == 100) echo ' selected="selected"'; ?>>100MB</option>
													<option value="200" <?php if ($data->chunk_size == 200) echo ' selected="selected"'; ?>>200MB</option>
													<option value="500" <?php if ($data->chunk_size == 500) echo ' selected="selected"'; ?>>500MB</option>
													<option value="1000" <?php if ($data->chunk_size == 1000) echo ' selected="selected"'; ?>>1GB</option>
													<option value="5000" <?php if ($data->chunk_size == 5000) echo ' selected="selected"'; ?>>5GB</option>
												</select>

								      		</div> <!-- END CUSTOMIZE FILE UPLOAD CHUNK SIZE -->


								      	</div>	<!-- END MODAL MAIN BODY -->						      

								    </div>

							  	</div>

							</div> <!-- END ADDITIONAL SETTINGS MODAL -->

							
							<!-- BOTTOM COPYRIGHT INFO -->
							<div id="copyright">		
								<?= html_entity_decode($data->copyright); ?>
							</div>


						</div> <!-- END FILE TRANSFER -->
						

						<!-- PLACEHOLDER FOR GOOGLE ADWORDS -->
						<div class="col-sm-12 col-md-3 col-lg"><?= html_entity_decode($data_google->adsense_right); ?></div>


					</div> <!-- END ROW -->	

				</form> <!-- END UPLOAD FILE FORM -->


	</section> <!-- END SECTION -->


	
	<!-- INCLUDED JS FILES -->
	<script src="admin/assets/client/js/filepond.min.js"></script>
	<script src="admin/assets/client/js/filepond-plugin-file-validate-size.min.js"></script>
	<script src="admin/assets/client/js/filepond-plugin-file-validate-type.min.js"></script>
	<script src="admin/assets/client/js/filepond.jquery.js"></script>
	<script src="admin/assets/client/js/awselect.js"></script>	
	<script src="admin/assets/client/js/popper.min.js"></script>
	<script src="admin/assets/client/js/bootstrap.min.js"></script>	
	<script src="admin/assets/client/js/custom.js"></script>
	

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=<?= escape($data_google->analytics_id); ?>"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());

  		gtag('config', '<?= escape($data_google->analytics_id); ?>');
	</script> -->

</body>
</html>