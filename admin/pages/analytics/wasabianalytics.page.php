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


<!-- CHARTJS FOR LINE GRAPH (MUST LOAD FIRST) -->
<script src="assets/server/js/Chart.bundle.min.js"></script>


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
			  				<i class="fab fa-staylinked"></i>
			  				<div class="content-title">
			  					<h4>Wasabi Data Metrics</h4>
			  					<span>Monitor your data traffic and activity</span>
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
		  						<a href="" class="active">Wasabi Data Metrics</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row">
	  			

	  			<!-- DISPLAY WASABI FILE UPLOAD METRICS -->
	  			<div class="col-sm-12 col-md-12">
	  				<div class="box card">

	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>Uploaded Files</h4>
	  						<span>Wasabi file uploads for current month</span>
	  					</div>

	  					<!-- BOX CONTENT -->
	  					<div class="box-content">

	  						<canvas id="uploaded-files-chart" width="400" height="100"></canvas>

	  						<span id="countries-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  					</div> <!-- END BOX CONTENT -->

	  				</div>
	  			</div> <!-- END DISPLAY WASABI FILE UPLOAD METRICS -->


	  			<!-- DISPLAY WASABI BUCKET UPLOAD METRICS -->
	  			<div class="col-sm-12 col-md-12">
	  				<div class="box card">

	  					<!-- BOX TITLE-->
	  					<div class="box-header">
	  						<h4>File Upload Traffic</h4>
	  						<span>Wasabi bucket upload traffic for current month</span>
	  					</div>

	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
							
							<canvas id="uploaded-traffic-chart" width="400" height="100"></canvas>

	  					</div> <!-- END BOX CONTENT -->

	  				</div>	  				
	  			</div> <!-- END DISPLAY WASABI BUCKET UPLOAD METRICS -->
	  			
	  			
	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->

  	</div> 
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

