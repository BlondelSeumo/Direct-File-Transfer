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

<!-- JS FILES FOR CHARTS & GOOGLE MAP -->
<script src="assets/server/js/moment.min.js"></script>
<script src="assets/server/js/Chart.min.js"></script>
<script src="assets/server/js/loader.js"></script>


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
			  				<i class="fas fa-poll-h"></i>
			  				<div class="content-title">
			  					<h4>Google Analytics Dashboard</h4>
			  					<span>Monitor your user traffic and activity closely</span>
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
		  						<a href="" class="active">Google Analytics</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center" id="google-analytics-charts">
	  			

	  			<!-- GOOGLE ANALYTICS - USERS AND SESSIONS -->
	  			<div class="col-12 col-sm-12 col-md-12">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>Users & Sessions</h4>
	  						<span>Google Analytics Metrics for the past 2 weeks</span>
	  					</div>

	  					<div class="box-content">
	  						<canvas id="users-analytics-chart" width="400" height="300"></canvas>
	  					</div>

	  					<span id="users-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  				</div>	  				
	  			</div> <!-- END GOOGLE ANALYTICS - USERS AND SESSIONS -->


	  			<!-- GOOGLE ANALYTICS - USERS AND SESSIONS -->
	  			<div class="col-12 col-sm-12 col-md-12">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>This Month vs Last Month</h4>
	  						<span>Google Analytics Metrics for comparing current and previous months users traffic</span>
	  					</div>


	  					<div class="box-content">
	  						<canvas id="monthly-analytics-chart" width="400" height="300"></canvas>
	  					</div>

	  					<span id="users-current-month" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>
	  					<span id="users-last-month" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  				</div>
	  			</div> <!-- END GOOGLE ANALYTICS - USERS AND SESSIONS -->


	  			<!-- GOOGLE ANALYTICS - TOP COUNTRIES -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>Top Countries</h4>
	  						<span>Top 100 countries for the past 2 weeks grouped by sessions</span>
	  					</div>


	  					<div class="box-content">
							<div id="countries-analytics-chart"></div>
	  					</div>

	  					<span id="countries-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  				</div>
	  			</div> <!-- END GOOGLE ANALYTICS - TOP COUNTRIES -->


	  			<!-- GOOGLE ANALYTICS - TOP TRAFFIC SOURCES -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>Top Traffic Sources</h4>
	  						<span>Top 10 traffic sources for the past 2 weeks grouped by sessions</span>
	  					</div>	  					

	  					<div class="box-content">
							<canvas id="traffic-analytics-chart" width="400" height="300"></canvas>
	  					</div>

	  					<span id="traffic-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  				</div>
	  			</div> <!-- GOOGLE ANALYTICS - TOP TRAFFIC SOURCES -->


	  			<!-- GOOGLE ANALYTICS - TOP DEVICES USED -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>Top Devices</h4>
	  						<span>Devices used for the past 2 weeks grouped by sessions</span>
	  					</div>	  					

	  					<div class="box-content">
							<canvas id="devices-analytics-chart" width="400" height="300"></canvas>
	  					</div>

	  					<span id="devices-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  				</div>
	  			</div> <!-- GOOGLE ANALYTICS - TOP DEVICES USED -->


	  			<!-- GOOGLE ANALYTICS - TOP BROWSERS USED -->
	  			<div class="col-12 col-sm-12 col-md-6">
	  				<div class="box card">

	  					<div class="box-header">
	  						<h4>Top Browsers</h4>
	  						<span>Top 5 browsers used for the past 2 weeks grouped by sessions</span>
	  						
	  					</div>	  					

	  					<div class="box-content">
							<canvas id="browsers-analytics-chart" width="400" height="300"></canvas>
	  					</div>

	  					<span id="browsers-biweekly" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>
	  					
  						<div id="embed-api-auth-container" style="display: none"></div>
  						<div id="view-selector-container" style="display: none"></div>

	  				</div>
	  			</div> <!-- GOOGLE ANALYTICS - TOP BROWSERS USED -->	  			


	  		</div>
  		</div> <!-- CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

