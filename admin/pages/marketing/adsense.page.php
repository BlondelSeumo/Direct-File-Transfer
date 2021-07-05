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
			  				<i class="fas fa-ad"></i>
			  				<div class="content-title">
			  					<h4>Google AdSense</h4>
			  					<span>Configure any of your preferred Ad Programs</span>
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
		  						<a href="" class="active">Google AdSense</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- ADD GOOGLE ADSENSE -->
	  			<div class="col-12 col-sm-12 col-md-5">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Advertisements</h4>
	  						<span>Use any of your marketing programs</span>
	  					</div>


	  					<!-- GOOGLE ADSENSE CHANGE STATUS MESSAGE -->
	  					<div>
	  						<?php  	
	  							if (Session::exists('adsense-success')) {
									echo '<p class="status-message success-message animate__animated animate__bounceIn">' . Session::flash('adsense-success') . '</p>'; 
								} else if(Session::exists('adsense-error')) {
									echo '<p class="status-message error-message animate__animated animate__bounceIn">' . Session::flash('adsense-error') . '</p>'; 
								}
							?>
	  					</div> <!-- END GOOGLE ADSENSE CHANGE STATUS MESSAGE -->


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="adsense-settings" action="includes/changeadsense.inc.php" method="post" enctype="multipart/form-data">

		  						<!-- LEFT COLUMN -->
								<div class="input-box">								
									<h6>Left Column Ad Banner</h6>
									<div class="form-group">
									<textarea class="form-control" id="left-ad" name="left-ad" rows="8" maxlength="1000" placeholder='Example: <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle" style="display:inline-block;width:250px;height:350px;"
	 data-ad-client="ca-pub-XXXXXXXXXXXXXXXXX"
	 data-ad-host="ca-host-pub-XXXXXXXXXXXXXXXXXXXX"
	 data-ad-host-channel="XXXXX"
	 data-ad-slot="XXXXXXXXXXXXXXX"
	 data-ad-format="vertical"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>'><?= escape($data->adsense_left); ?></textarea>			
									</div> 
								</div> <!-- END LEFT COLUMN -->


								<!-- RIGHT COLUMN -->
								<div class="input-box">								
									<h6>Right Column Ad Banner</h6>
									<div class="form-group">
										<textarea class="form-control" id="right-ad" name="right-ad" rows="8" maxlength="1000" placeholder='Example: <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle" style="display:inline-block;width:250px;height:350px;"
	 data-ad-client="ca-pub-XXXXXXXXXXXXXXXXX"
	 data-ad-host="ca-host-pub-XXXXXXXXXXXXXXXXXXXX"
	 data-ad-host-channel="XXXXX"
	 data-ad-slot="XXXXXXXXXXXXXXX"
	 data-ad-format="vertical"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>'><?= escape($data->adsense_right); ?></textarea>			
									</div> 
								</div> <!-- END RIGHT COLUMN -->


								<!-- CSRF TOKEN -->
								<input type="hidden" name="csrf_token" value="<?php echo Token::generate(); ?>">


								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="submit-button text-center">							
									<button class="ripple" id="save-adsense-settings" type="submit" name="save-adsense-settings">Save Changes</button>
								</div>


							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END ADD GOOGLE ADSENSE -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN CONTENT WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

