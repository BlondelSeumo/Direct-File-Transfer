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

	# Core Initialization File
	require_once __DIR__ . '/core/init.core.php';

	# Initilize DB Class
	$db = DB::getInstance();
	$data = $db->get('upload_settings', array('id', '=', 1))->first();

	# Check if form fields are filled and csrf token exists
	if (Input::exists()) {
		if (Token::check(Input::get('csrf_token'))) {

			# Validate form input data
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
					'username' => array('required' => true),
					'password' => array('required' => true)
			));

			# If validation passed check if username and password are correct
			if ($validation->passed()) {
				$user = new User();
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);

				# Redirect based on the login results
				if ($login) {
					Redirect::to('index.php');
				} else {
					Session::flash('login-error', 'Invalid username or password.');
				}

			} else {

				# If there were form valication errors, send error messages
				$errorMessages;

				foreach ($validation->errors() as $error) {
					$errorMessages .= $error . '<br>';
				}

				Session::flash('login-error', $errorMessages);
				Redirect::to('index.php');
			}
		}
	}

	/* INCLUDE HEADER CONTENT */
 	include_once __DIR__ . '/header.php';

?>
		
		
<!-- LOGIN CONTAINER WRAPPER -->
<div class="container">
	<div id="login-page">

		<!-- TITLE NAME -->
		<div class="form-title text-center">
			<i class='fab fa-staylinked'></i>
			<h3><?= html_entity_decode($data->title); ?></h3>	
		</div>
		
		<!-- FORMS CONTENT WRAPPER -->
	  	<div class="form-wrapper">

		    <!-- LOGIN FORM-->
		    <form class="login-form" method="post">

		    	<h5>Account Login</h5>

		    	<!-- LOGIN STATUS MESSAGE -->
				<div>
					<?php  	
						if (Session::exists('login-success')) {
							echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('login-success') . '</p>'; 
						} else if(Session::exists('login-error')) {
							echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('login-error') . '</p>'; 
						}
					?>
				</div> <!-- LOGIN STATUS MESSAGE -->

				<!-- USERNAME FIELD -->
		    	<div class="field">	
					<label for="username">Username</label>
					<input type="text" name="username" id="username" autocomplete="off" required>
				</div> <!-- END USERNAME FIELD -->

				<!-- PASSWORD FIELD -->
				<div class="field">	
					<label for="password">Password</label>
					<input type="password" name="password" id="password" autocomplete="off" required>
				</div> <!-- END PASSWORD FIELD -->

				<!-- SUPPORTING FIELD -->
				<div class="field">	
					<div class="left-box radio-control">							
						<input class="input-control" type="checkbox" name="remember" id="remember"> 
						<label class="label-control" for="remember">Remember me</label>
					</div>
					
				</div> <!-- END SUPPORTING FIELDS -->

				<!-- CSRF TOKEN -->
				<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">

				<!-- SIGN IN ACTION BUTTON -->	
				<div class="submit-button">						
					<button class="ripple" id="sign-in" type="submit" name="sign-in">Sign In</button>
				</div>		      

		    </form> <!-- END LOGIN FORM -->

	  	</div> <!-- END FORMS CONTENT WRAPPER -->

	</div>
</div> <!-- END LOGIN CONTAINER WRAPPER -->


<!-- FOOTER INFORMATION -->
<footer class="fixed-bottom text-center">

	<div id="copyright">
		<p>Copyright &copy; 2020 <a href="https://codecanyon.net/user/berkine/portfolio" target="_blank">Berkine</a></p>
	</div>

	<div id="version">
		<p>Version: 1.0.0</p>
	</div>

</footer> <!-- END FOOTER INFORMATION -->


<!-- INCLUDE FOOTER CONTENT -->
<?php include_once __DIR__ . '/footer.php' ?>