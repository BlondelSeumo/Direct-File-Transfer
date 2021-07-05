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
	require_once __DIR__ . '/../../core/init.core.php';	

	$user = new User();

	/* CHECK IF USER IS LOOGED IN */
	if (!$user->isLoggedIn()) {
		Redirect::to('../../login.php');
	}

	/* INCLUDE HEADER CONTENT */
 	include_once __DIR__ . '/../../header.php';
 	include_once __DIR__ . '/../../navbar.php';

 	/* Instance of DB Class */
 	$db = DB::getInstance();
	$data = $db->get('upload_settings', array('id', '=', 1))->first();


?>


<!-- MAIN WRAPPER -->
<div id="wrapper">
  	<div class="content-wrapper">
  		
  		<!-- CONTENT HEADER SECTION -->
  		<div class="content-header">
  			<div class="container-fluid">

  				<div class="row">
  					
  					<!-- CONTENT TITLE -->
		  			<div class="col-sm-6">
		  				<div class="content-header-title">
			  				<i class="fas fa-sliders-h"></i>
			  				<div class="content-title">
			  					<h4>Upload Settings</h4>
			  					<span>Configure your file upload parameters</span>
			  				</div>
		  				</div>		  				
		  			</div> <!-- END CONTENT TITLE -->

		  			<!-- CONTENT NAV BREADCRUM -->
		  			<div class="col-sm-6">
		  				<ol class="breadcrumb float-sm-right">
		  					<li class="breadcrumb-item">
		  						<a href="">Home</a>
		  					</li>
		  					<li class="breadcrumb-item">
		  						<a href="" class="active">Upload Settings</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- CHANGE UPLOAD SETTINGS -->
	  			<div class="col-12 col-sm-12 col-md-5">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>File Upload Settings</h4>
	  						<span>Change default settings as needed</span>
	  					</div>


	  					<!-- UPLOAD SETTINGS CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('upload-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('upload-success') . '</p>'; 
								} else if(Session::exists('upload-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('upload-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END UPLOAD SETTINGS CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="upload-settings" action="includes/changeuploadsettings.inc.php" method="post" enctype="multipart/form-data">

			  						
		  						<!-- FILE SIZE -->
								<div class="input-box">								
									<h6>Maximum File Size (MB)</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="max_file_size" name="max_file_size" value="<?= escape($data->max_size); ?>">
									</div> 
								</div> <!-- END FILE SIZE -->


								<!-- FILE QUANTITY -->
								<div class="input-box">								
									<h6>Maximum File Quantity</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="max_file_quantity" name="max_file_quantity" value="<?= escape($data->max_quantity); ?>">
									</div> 
								</div> <!-- END FILE QUANTITY -->


								<!-- FILE TYPES -->
								<div class="input-box">								
									<h6>Accepted File Types <a href="" data-toggle="modal" data-target="#modalTypes"><i class="fas fa-th-list" data-toggle="tooltip" data-placement="top" title="MIME Types Cheatsheet"></i></a></h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="file_type" name="file_type" value="<?= escape($data->file_type); ?>">
									</div> 
								</div> <!-- END FILE TYPES -->


								<!-- SHARE TYPE -->
								<div class="input-box">								
									<h6>Default Share Type</h6>
									<select id="share_type" name="share_type" data-placeholder="Select default file share type:">			
										<option value="email" <?php if ($data->share_type == 'email') echo ' selected="selected"'; ?>>Email</option>
										<option value="link" <?php if ($data->share_type == 'link') echo ' selected="selected"'; ?>>Link</option>
									</select>
								</div> <!-- END SHARE TYPE -->


								<!-- SIGNED LINK -->
								<div class="input-box">								
									<h6>Private Signed Link</h6>
									<select id="signed_link" name="signed_link" data-placeholder="Default private signed link status:">			
										<option value="disabled" <?php if ($data->signed_link == 'disabled') echo ' selected="selected"'; ?>>Disabled</option>
										<option value="enabled" <?php if ($data->signed_link == 'enabled') echo ' selected="selected"'; ?>>Enabled</option>
									</select>
								</div> <!-- END SIGNED LINK -->


								<!-- SIGNED LINK DURATION -->
								<div class="input-box">								
									<h6>Default Private Signed Link Expiration</h6>
									<select id="link_expiration" name="link_expiration" data-placeholder="Default private signed link expiration:">			
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
								</div> <!-- END SIGNED LINK DURATION -->


								<!-- MULTIPART CHUNK SIZE -->
								<div class="input-box">								
									<h6>Multipart Upload File Chunk Size</h6>
									<select id="chunk_size" name="chunk_size" data-placeholder="Default multipart chunk size:">			
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
								</div> <!-- END MULTIPART CHUNK SIZE -->
								

								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="save-upload-settings" type="submit" name="save-upload-settings">Save Changes</button>
								</div>
							

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  					<!-- ADDITIONAL SETTINGS MODAL -->
						<div class="modal fade" id="modalTypes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						  	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
							    <div class="modal-content">


									<!-- MODAL TITLE -->
							      	<div class="modal-header">
							        	<h5 class="modal-title" id="exampleModalLongTitle">File MIME Types Cheatsheet</h5>
							        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          		<span aria-hidden="true">&times;</span>
							        	</button>
							      	</div>

									
									<!-- MODAL MAIN BODY -->
							      	<div class="modal-body">
							      		
							      		<h6>Allowed file types must be included in one of the following formats: </h6>
							      		<ul>
							      			<li>['image/png', 'image/jpeg', ...] - Exact file types</li>
							      			<li>['image/*', 'audio/*', ...] - Grouped by file type category</li>
							      			<li>[] - All file types</li> 
							      		</ul>

							      		<h6>Common MIME Types: </h6>
							      		<div class="row no-gutters">
							      			<div class="col-6">
							      				<ul>
									      			<li>['image/png']</li>
									      			<li>['image/jpeg']</li>
									      			<li>['image/webp']</li>
									      			<li>['image/tiff']</li>
									      			<li>['image/svg+xml']</li>
									      			<li>['image/gif']</li>
									      			<li>['text/plain']</li>
									      			<li>['text/html']</li>
									      			<li>['text/csv']</li>
									      			<li>['text/html']</li>
									      		</ul>
							      			</div>

							      			<div class="col-6">
							      				<ul>
									      			<li>['audio/mpeg']</li>
									      			<li>['audio/wav']</li>
									      			<li>['audio/3gpp']</li>
									      			<li>['audio/ogg']</li>
									      			<li>['video/x-msvideo']</li>
									      			<li>['video/mpeg']</li>
									      			<li>['video/ogg']</li>
									      			<li>['application/json']</li>
									      			<li>['application/pdf']</li>
									      			<li>['application/vnd.rar']</li>
									      		</ul>
							      			</div>
							      		</div>

							      	</div>	<!-- END MODAL MAIN BODY -->						      


							    </div>
						  	</div>
						</div> <!-- END ADDITIONAL SETTINGS MODAL -->


	  				</div>
	  			</div> <!-- END CHANGE UPLOAD SETTINGS -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

