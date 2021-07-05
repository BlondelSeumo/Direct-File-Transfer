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
			  				<i class="fas fa-envelope-open"></i>
			  				<div class="content-title">
			  					<h4>SMTP Settings</h4>
			  					<span>Configure your SMTP parameters to send emails</span>
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
		  						<a href="" class="active">SMTP Settings</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row">
	  			

	  			<!-- SETUP SMTP SETTINGS -->
	  			<div class="col-12 col-sm-12 col-md-8">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Setup Email Settings</h4>
	  						<span>Include email credentials and settings for PHPMailer</span>
	  					</div>


	  					<!-- SMTP CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('smtp-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('smtp-success') . '</p>'; 
								} else if(Session::exists('smtp-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('smtp-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END SMTP CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="smtp-settings" action="includes/smtpsettings.inc.php" method="post" enctype="multipart/form-data">

	  							<div class="row justify-content-md-center">		  						

	  								<!-- REQUIRED SMTP SETTINGS -->
		  							<div class="col-12 col-sm-12 col-md-6 right-padding">
			  						
				  						<!-- SMTP HOST -->
										<div class="input-box">								
											<h6>SMTP Host</h6>
											<div class="form-group">							    
											    <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="Ex: smtp.gmail.com" value="<?= escape($data->smtp_host); ?>" autocomplete="off" required>
											</div> 
										</div> <!-- END SMTP HOST -->


										<!-- SMTP PORT -->
										<div class="input-box">								
											<h6>SMTP Port</h6>
											<div class="form-group">							    
											    <input type="text" class="form-control" id="smtp_port" name="smtp_port" placeholder="Ex: 587" value="<?= escape($data->smtp_port); ?>" autocomplete="off" required>
											</div> 
										</div> <!-- SMTP PORT -->


										<!-- SMTP ENCRYPTION -->
										<div class="input-box">								
											<h6>SMTP Encryption</h6>
											<div class="form-group">							    
											    <input type="text" class="form-control" id="smtp_encryption" name="smtp_encryption" placeholder="Ex: TLS" value="<?= escape($data->smtp_encryption); ?>" autocomplete="off" required>
											</div> 
										</div> <!-- SMTP ENCRYPTION -->


										<!-- EMAIL LOGIN -->
										<div class="input-box">								
											<h6>Email Login</h6>
											<div class="form-group">							    
											    <input type="text" class="form-control" id="email_login" name="email_login" placeholder="Ex: example@gmail.com" value="<?= escape($data->email_login); ?>" autocomplete="off" required>
											</div> 
										</div> <!-- END EMAIL LOGIN -->


										<!-- EMAIL PASSWORD -->
										<div class="input-box">								
											<h6>Email Password</h6>
											<div class="form-group">							    
											    <input type="password" class="form-control" id="email_password" name="email_password" placeholder="Enter your Email Password" value="<?= escape($data->email_password); ?>" autocomplete="off" required>
											</div> 
										</div> <!-- END EMAIL PASSWORD -->

									</div> <!-- END REQUIRED SMTP SETTINGS -->


									<!-- OPTIONAL SMTP SETTINGS -->
									<div class="col-12 col-sm-12 col-md-6 left-padding">
			  						
				  						<!-- SENDER EMAIL ADDRESS -->
										<div class="input-box">								
											<h6>From Email Address <small> (optional)</small></h6>
											<div class="form-group">							    
											    <input type="text" class="form-control" id="from_email" name="from_email" placeholder="Ex: no-reply@gmail.com" value="<?= escape($data->from_email); ?>" autocomplete="off">
											</div> 
										</div> <!-- END SENDER EMAIL ADDRESS -->


										<!-- SENDER FROM NAME -->
										<div class="input-box">								
											<h6>From Name <small> (optional)</small></h6> 
											<div class="form-group">							    
											    <input type="text" class="form-control" id="from_name" name="from_name" placeholder="Ex: no-reply" value="<?= escape($data->from_name); ?>" autocomplete="off">
											</div> 
										</div> <!-- SENDER FROM NAME -->


										<!-- EMAIL CC -->
										<div class="input-box">								
											<h6>Default Email CC <small> (optional)</small></h6> 
											<div class="form-group">							    
											    <input type="text" class="form-control" id="email_cc" name="email_cc" value="<?= escape($data->email_cc); ?>" placeholder="Ex: backup@example.com" autocomplete="off">
											</div> 
										</div> <!-- END EMAIL CC -->

									</div> <!-- END OPTIONAL SMTP SETTINGS -->


									<!-- CSRF TOKEN -->
									<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


									<!-- SAVE CHANGES ACTION BUTTON -->
									<div class="submit-button text-center">							
										<button class="ripple" id="save-smtp-settings" type="submit" name="save-smtp-settings">Save Changes</button>
									</div>

								</div>

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END SETUP SMTP SETTINGS -->


	  			<!-- CHECK SMTP SETTINGS -->
	  			<div class="col-12 col-sm-12 col-md-4">
	  				<div class="box card">

	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Test Email Settings</h4>
	  					</div>


	  					<!-- SMTP TEST STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('smtp-test-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('smtp-test-success') . '</p>'; 
								} else if(Session::exists('smtp-test-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('smtp-test-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END SMTP TEST STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="test-email" action="includes/smtptest.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- TEST EMAIL ADDRESS -->
								<div class="input-box">								
									<h6>To Email Address</h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="test_email" name="test_email" placeholder="Enter Test Email Address" required>
									</div> 
								</div> <!-- END TEST EMAIL ADDRESS -->


								<!-- SUBJECT -->
								<div class="input-box">								
									<h6>Email Subject <small> (optional)</small></h6>
									<div class="form-group">							    
									    <input type="text" class="form-control" id="test_subject" name="test_subject" placeholder="Enter Subject">
									</div> 
								</div> <!-- END SUBJECT -->


								<!-- MESSAGE -->
								<div class="input-box">								
									<h6>Email Message <small> (optional)</small></h6>
									<div class="form-group">
										<textarea class="form-control" id="test-message" name="test_message" rows="5" maxlength="500" placeholder="Enter Message"></textarea>			
									</div> 
								</div> <!-- END MESSAGE -->



								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="send-test-email" type="submit" name="send-test-email">Send Email</button>
								</div>

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END CHECK SMTP SETTINGS -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>