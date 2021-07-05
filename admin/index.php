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
	require_once __DIR__ . '/core/init.core.php';

	$user = new User(); 

	/* RUN IF USER IS LOGGED IN */
	if ($user->isLoggedIn()) {

		$db = DB::getInstance();
		$data = $db->get('data_dashboard', array('id', '=', 1))->first();

		/* INCLUDE HEADER CONTENT */
 		include_once __DIR__ . '/header.php';
 		include_once __DIR__ . '/navbar.php';
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
			  				<i class="fas fa-layer-group"></i>
			  				<div class="content-title">
			  					<h4>Dashboard</h4>
			  					<span>General overview of Upload & Share app usage</span>
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
		  						<a href="" class="active">Dashboard</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">

  			<!-- CARDS -->
	  		<div class="row">
	  			
	  			<!-- CARD - TOTAL UPLOADS-->
	  			<div class="col-sm-12 col-md-6 col-lg-3">
	  				<div class="card info-box-card">
		  				<div class="info-box">
		  					<span class="info-box-icon icon-3">
		  						<i class="fas fa-cloud-upload-alt"></i>
		  					</span>
		  					<div class="info-box-content">
		  						<span class="info-box-text">Total Uploads</span>
		  						<span class="info-box-number"><?= escape($data->total_uploads); ?></span>
		  					</div>
		  				</div>
	  				</div>
	  			</div> <!-- END CARD - TOTAL UPLOADS -->


	  			<!-- CARD - TOTAL DOWNLOADS -->
	  			<div class="col-sm-12 col-md-6 col-lg-3">
	  				<div class="card info-box-card">
		  				<div class="info-box">
		  					<span class="info-box-icon icon-4">
		  						<i class="fab fa-buromobelexperte"></i>
		  					</span>
		  					<div class="info-box-content">
		  						<span class="info-box-text">Total Bucket Size</span>
		  						<span class="info-box-number" id="total-bucket-size"></span>
		  					</div>
		  				</div>
	  				</div>
	  			</div> <!-- END CARD - TOTAL DOWNLOADS -->


	  			<!-- CARD - EMAILS SENT -->
	  			<div class="col-sm-12 col-md-6 col-lg-3">
	  				<div class="card info-box-card">
		  				<div class="info-box">
		  					<span class="info-box-icon icon-2">
		  						<i class="fab fa-mailchimp"></i>
		  					</span>
		  					<div class="info-box-content">
		  						<span class="info-box-text">Total Emails Sent</span>
		  						<span class="info-box-number"><?= escape($data->emails_sent); ?></span>
		  					</div>
		  				</div>
	  				</div>
	  			</div> <!-- END CARD - EMAIL SENT -->


	  			<!-- CARD - LINKS CREATED -->
	  			<div class="col-sm-12 col-md-6 col-lg-3">
	  				<div class="card info-box-card">
		  				<div class="info-box">
		  					<span class="info-box-icon icon-1">
		  						<i class="fas fa-share-alt"></i>
		  					</span>
		  					<div class="info-box-content">
		  						<span class="info-box-text">Total Links Created</span>
		  						<span class="info-box-number"><?= escape($data->links_created); ?></span>
		  					</div>
		  				</div>
	  				</div>
	  			</div> <!-- END CARD - LINKS CREATED -->

	  		</div> <!-- END CARDS -->


	  		<!-- WASABI DATA METRIC - TOTAL FILES PER DAY -->
	  		<div class="row">

	  			<!-- TOTAL BUCKET SIZE-->
	  			<div class="col-sm-12 col-md-12">
	  				<div class="box card">

	  					<!-- BOX HEADER-->
	  					<div class="box-header">
	  						<h4>Uploaded Files</h4>
	  						<span>Wasabi file uploads for current month</span>
	  					</div>

	  					<!-- BOX CONTENT-->
	  					<div class="box-content">

	  						<canvas id="uploaded-files-chart" width="400" height="350"></canvas>

	  						<span id="uploaded-files" class="loading deactivated"><img src="../admin/assets/server/img/preload.gif" alt="Processing"></span>

	  					</div> <!-- END BOX CONTENT-->

	  				</div>
	  			</div> <!-- END TOTAL BUCKET SIZE -->


	  		</div> <!-- END WASABI DATA METRIC - TOTAL FILES PER DAY-->


	  		<!-- GOOGLE ANALYTICS METRICS -->
	  		<div class="row" id="google-analytics-dashboard">

	  			<!-- TOP COUNTRIES-->
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
	  			</div> <!-- END TOP CONTRIES-->


	  			<!-- USERS & SESSIONS -->
	  			<div class="col-12 col-sm-12 col-md-6">
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
	  			</div> <!-- END USERS & SESSIONS-->

	  		</div> <!-- GOOGLE ANALYTICS METRICS -->

  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<?php


} else {
	
	/* IF USER IS NOT LOGGED IN REDIRECT TO LOGIN PAGE */
	Redirect::to('login.php');
}


/* INCLUDE FOOTER CONTENT */
include_once __DIR__ . '/footer.php'; 
