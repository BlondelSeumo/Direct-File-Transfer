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
	$data = $db->get('users', array('username', '=', $user->data()->username))->first();

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
			  					<h4>Profile Settings</h4>
			  					<span>Configure your personal informaiton</span>
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
		  						<a href="" class="active">Profile Settings</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			
	  			<!-- UPDATE ADMIN PROFILE -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">

	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Update Admin Profile</h4>
	  					</div>


	  					<!-- PROFILE UPDATE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('profile-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('profile-success') . '</p>'; 
								} else if(Session::exists('profile-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('profile-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END PROFILE UPDATE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="account-settings" action="includes/updateprofile.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- USERNAME -->
								<div class="input-box">								
									<h6>Login Name</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="username" name="username" placeholder="Login Name" value="<?= escape($data->username); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END USERNAME -->


								<!-- NAME -->
								<div class="input-box">								
									<h6>Full Name</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="name" name="name" placeholder="FirstName LastName" value="<?= escape($data->name); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END NAME -->


								<!-- EMAIL -->
								<div class="input-box">								
									<h6>Email Address</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="email" name="email" placeholder="admin@example.com" value="<?= escape($data->email); ?>" autocomplete="off" required>
									</div> 
								</div> <!-- END EMAIL -->


								<!-- CURRENT PASSWORD -->
								<div class="input-box">								
									<h6>Current Password</h6>
									<div class="form-group">							    
									    <input type="password" class="form-control" id="password_current" name="password_current" placeholder="Current Password" autocomplete="off" required>
									</div> 
								</div> <!-- END CURRENT PASSWORD -->


								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="updated_profile" type="submit" name="updated_profile">Save Changes</button>
								</div>

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END UPDATE ADMIN PROFILE-->


	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN CONTENT WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

