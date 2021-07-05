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
			  				<i class="fas fa-user-cog"></i>
			  				<div class="content-title">
			  					<h4>Password Settings</h4>
			  					<span>Change your admin password</span>
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
		  						<a href="" class="active">Password Settings</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  		

	  			<!-- CHANGE ADMIN PASSWORD -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Change Admin Password</h4>
	  					</div>


	  					<!-- PASSWORD CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('password-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('password-success') . '</p>'; 
								} else if(Session::exists('password-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('password-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END PASSWORD CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="change-password" action="includes/changepassword.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- CURRENT PASSWORD -->
								<div class="input-box">								
									<h6>Current Password</h6>
									<div class="form-group">							    
									    <input type="password" class="form-control" id="password_current" name="password_current" placeholder="Current Password" autocomplete="off" required>
									</div> 
								</div> <!-- END CURRENT PASSWORD -->


								<!-- NEW PASSWORD -->
								<div class="input-box">								
									<h6>New Password</h6>
									<div class="form-group">							    
									    <input type="password" class="form-control" id="password_new" name="password_new" placeholder="New Password" autocomplete="off" required>
									</div> 
								</div> <!-- END NEW PASSWORD -->


								<!-- CONFIRM NEW PASSWORD -->
								<div class="input-box">								
									<h6>Confirm New Password</h6>
									<div class="form-group">							    
									    <input type="password" class="form-control" id="password_new_again" name="password_new_again" placeholder="Confirm New Password" autocomplete="off" required>
									</div> 
								</div> <!-- END CONFIRM NEW PASSWORD -->


								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="change_password" type="submit" name="change_password">Change Password</button>
								</div> <!-- END SAVE CHANGES ACTION BUTTON -->

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END CHANGE ADMIN PASSWORD -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN CONTENT WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

