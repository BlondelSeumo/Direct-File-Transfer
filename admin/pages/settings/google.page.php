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
	$data = $db->get('configs_google', array('id', '=', 1))->first();
 	
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
			  				<i class="fas fa-tools"></i>
			  				<div class="content-title">
			  					<h4>Google Settings</h4>
			  					<span>Configure your google parameters to get analytics data</span>
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
		  						<a href="" class="active">Google Settings</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- ADD GOOGLE ANALYTICS SETTINGS -->
	  			<div class="col-12 col-sm-12 col-md-5">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Setup Google Keys</h4>
	  						<span>Include your google analytics tracking keys</span>
	  					</div>


	  					<!-- GOOGLE ADSENSE CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('analytics-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('analytics-success') . '</p>'; 
								} else if(Session::exists('analytics-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('analytics-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END GOOGLE ADSENSE CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="google-settings" action="includes/changegooglecredentials.inc.php" method="post" enctype="multipart/form-data">


	  							<!-- GOOGLE ANALYTICS AUTH CLIENT ID -->
								<div class="input-box">								
									<h6>Google Analytics Service Account Credentials - <a href="https://developers.google.com/analytics/devguides/reporting/core/v3/quickstart/service-php" target="_blank">How To Get</a></h6>
									<div class="select-file">
										<input type="file" name="file" id="file" class="file"  required />
										<label for="file">
											<i class="fas fa-user-secret"></i>
											<span id="file-upload-label">Include JSON Key File </span>
										</label>		
									</div>
								</div> <!-- END GOOGLE ANALYTICS AUTH CLIENT ID -->	


		  						<!-- GOOGLE ANALYTICS ID -->
								<div class="input-box">								
									<h6>Google Analytics Tracking ID - <a href="https://developers.google.com/analytics/devguides/reporting/core/v3/quickstart/service-php" target="_blank">How To Get</a></h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="analytics-id" name="analytics-id" placeholder="Ex: UA-XXXXXXXX-X" value="<?= escape($data->analytics_id); ?>" required>
									</div> 
								</div> <!-- END GOOGLE ANALYTICS ID -->


								<!-- GOOGLE MAPS KEYS -->
								<div class="input-box">								
									<h6>Google Maps API Key - <a href="https://developers.google.com/maps/gmp-get-started" target="_blank">How To Get</a></h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="google-maps" name="google-maps" placeholder="Ex: XXXXXXXXXXXXXXXXXXXXX" value="<?= escape($data->maps_key); ?>" required>
									</div> 
								</div> <!-- END GOOGLE MAPS KEYS -->						


								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">

								
								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="save-google-settings" type="submit" name="save-google-settings">Save Changes</button>
								</div>


							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END ADD GOOGLE ANALYTICS SETTINGS -->


	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

