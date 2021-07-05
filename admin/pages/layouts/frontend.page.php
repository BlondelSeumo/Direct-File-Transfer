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
			  				<i class="fas fa-palette"></i>
			  				<div class="content-title">
			  					<h4>Frontend Layouts</h4>
			  					<span>Customize your frontend view</span>
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
		  						<a href="" class="active">Frontend Layouts</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>
  				
  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- CHANGE FRONTEND LAYOUTS -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Change Frontend Layouts</h4>
	  						<span>All the changes are saved & applied instantly</span>
	  					</div>


	  					<!-- FRONTEND CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('frontend-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('frontend-success') . '</p>'; 
								} else if(Session::exists('frontend-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('frontend-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END FRONTEND CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="aws-settings" action="includes/changefrontend.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- TITLE -->
								<div class="input-box">								
									<h6>Application Title</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Frontend Title Name" value="<?= escape($data->title); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END TITLE -->


								<!-- DESCRIPTION -->
								<div class="input-box">								
									<h6>Service Description</h6>
									<div class="form-group">							    
									    <textarea class="form-control" id="description" name="description" rows="5" maxlength="5000" placeholder="Provide Service Descriptions"><?= escape($data->description); ?></textarea>
									</div> 
								</div> <!-- END DESCRIPTION -->


								<!-- COPYRIGHT -->
								<div class="input-box">								
									<h6>Copyright Description</h6>
									<div class="form-group">							    
									    <textarea class="form-control" id="copyright" name="copyright" rows="5" maxlength="5000" placeholder="Provide Copyright Information"><?= escape($data->copyright); ?></textarea>
									</div> 
								</div> <!-- END COPYRIGHT -->



								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="save-aws-settings" type="submit" name="save-aws-settings">Save Changes</button>
								</div>

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END CHANGE FRONTEND LAYOUTS -->	  			


	  		</div>
  		</div> <!-- CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN CONTENT WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

