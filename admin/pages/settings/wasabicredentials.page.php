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
	$data = $db->get('configs', array('id', '=', 1))->first();
 	
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
			  				<i class='fab fa-staylinked'></i>
			  				<div class="content-title">
			  					<h4>Wasabi Credentials</h4>
			  					<span>Configure your Wasabi IAM and Bucket parameters</span>
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
		  						<a href="" class="active">Wasabi Credentials</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>
  				
  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- CHANGE AWS CREDENTIALS -->
	  			<div class="col-12 col-sm-12 col-md-5">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Setup Wasabi Settings</h4>
	  						<span>Enter your Wasabi IAM user keys</span>
	  					</div>


	  					<!-- CREDENTIALS CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('wasabi-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('wasabi-success') . '</p>'; 
								} else if(Session::exists('wasabi-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('wasabi-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END CREDENTIALS CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="aws-settings" action="includes/changewasabicredentials.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- ACCESS KEY -->
								<div class="input-box">								
									<h6>Wasabi Access Key</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="access_key" name="access_key" placeholder="Enter your Wasabi IAM Access Key" value="<?= escape($data->access_key); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END ACCESS KEY -->


								<!-- SECRET ACCESS KEY -->
								<div class="input-box">								
									<h6>Wasabi Secret Access Key</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="secret_access_key" name="secret_access_key" placeholder="Enter your Wasabi IAM Secret Access Key" value="<?= escape($data->secret_access_key); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END SECRET ACCESS KEY -->


								<!-- WASABI BUCKET NAME -->
								<div class="input-box">								
									<h6>Wasabi Bucket Name</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="bucket_name" name="bucket_name" placeholder="Enter your Wasabi Bucket Name" value="<?= escape($data->bucket_name); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END WASABI BUCKET NAME -->


								<!-- AWS REGION -->
								<div class="input-box">	
									<h6>Wasabi Region</h6>
			  						<select id="region" name="region" data-placeholder="Select your Wasabi Region:">			
										<option value="us-east-1" <?php if ($data->region == 'us-east-1') echo ' selected="selected"'; ?>>Wasabi US East 1 (N. Virginia) us-east-1</option>
										<option value="us-east-2" <?php if ($data->region == 'us-east-2') echo ' selected="selected"'; ?>>Wasabi US East 2 (N. Virginia) us-east-2</option>
										<option value="us-central-1" <?php if ($data->region == 'us-central-1') echo ' selected="selected"'; ?>>Wasabi US Central 1 (Texas) us-central-1</option>
										<option value="us-west-1" <?php if ($data->region == 'us-west-1') echo ' selected="selected"'; ?>>Wasabi US West 1 (Oregon) us-west-1</option>
										<option value="eu-central-1" <?php if ($data->region == 'eu-central-1') echo ' selected="selected"'; ?>>Wasabi EU Central 1 (Amsterdam) eu-central-1</option>
										<option value="ap-northeast-1" <?php if ($data->region == 'ap-northeast-1') echo ' selected="selected"'; ?>>Wasabi AP Northeast 1 (Tokyo) ap-northeast-1 (Only for Japan)</option>
									</select>
								</div> <!-- END AWS REGION -->


								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="save-wasabi-settings" type="submit" name="save-wasabi-settings">Save Changes</button>
								</div>

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END CHANGE AWS CREDENTIALS -->	  			


	  		</div>
  		</div> <!-- CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN CONTENT WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

