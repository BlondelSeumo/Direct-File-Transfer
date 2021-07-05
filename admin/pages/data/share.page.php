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
			  				<i class="fas fa-bezier-curve"></i>
			  				<div class="content-title">
			  					<h4>Share Data</h4>
			  					<span>All user file share information</span>
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
		  						<a href="" class="active">Share Data</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>
  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- DISPLAY SHARE DATA TABLE -->
	  			<div class="col-12 col-sm-12 col-md-12">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header data-table">
	  						<h4>Shared Data Table</h4>
	  						<span>View who is sharing and how files are shared</span>
	  					</div>


	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="share-data" action="" method="post" enctype="multipart/form-data">

	  							<!-- SET DATATABLE -->
							    <table id='shareTable' class='table table-striped' width='100%'>
							       	<thead>
							         	<tr>
								           	<th width="7%">Share Type</th>
								           	<th width="7%">File Quantity</th>
								           	<th width="20%">File Names</th>
								           	<th width="9%">Sender Email</th>
								           	<th width="10%">Receiver Emails</th>								           	
								           	<th width="10%">Message</th>								           	
								           	<th width="7%">Private Link</th>
								           	<th width="10%">Expiration Time</th>
								           	<th width="10%">Share Date</th>
							        	</tr>
							       	</thead>
							    </table> <!-- END SET DATATABLE -->

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END DISPLAY SHARE DATA TABLE -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  	</div>
</div> <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

