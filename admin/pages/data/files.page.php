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
			  				<i class="fas fa-th-large"></i>
			  				<div class="content-title">
			  					<h4>File Uploads</h4>
			  					<span>All uploaded files and their metadata</span>
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
		  						<a href="" class="active">File Uploads</a>
		  					</li>
		  				</ol>
		  			</div> <!-- END CONTENT NAV BREADCRUM -->

		  		</div>
  				

  			</div>  		
  		</div> <!-- END CONTENT HEADER SECTION -->


  		<!-- CONTENT BODY SECTION -->
  		<div class="content-body">
	  		<div class="row justify-content-md-center">
	  			

	  			<!-- DISPLAY FILES DATA TABLE -->
	  			<div class="col-12 col-sm-12 col-md-12">
	  				<div class="box card">


	  					<!-- BOX TITLE-->
	  					<div class="box-header data-table">
	  						<h4>File Uploads Table</h4>
	  						<span>View shared files details</span>
	  					</div>	

	  					<!-- DELETE NOTIFICATION MESSAGE -->
	  					<div><span class="notification-message"></span></div>  					

	  					<!-- BOX CONTENT -->
	  					<div class="box-content">
	  						<form id="file-uploads" action="" method="post" enctype="multipart/form-data">

	  							<div class="actions-total">
	  								<button href="#" class="btn actions-total-buttons" id="actions-total-download" data-toggle="tooltip" data-placement="top" title="Download Selected Files" disabled="disabled"><i class="fas fa-download"></i></button>
	  								<button href="#" class="btn actions-total-buttons" id="actions-total-share" data-toggle="tooltip" data-placement="top" title="Share Selected Files" disabled="disabled"><i class="fas fa-share-alt"></i></button>
	  								<button href="#" class="btn actions-total-buttons" id="actions-total-delete" button-toggle="tooltip" button-placement="top" title="Delete Selected Files" disabled="disabled" data-toggle="modal" data-target="#confirm-delete-all"><i class="fas fa-trash-alt"></i></button>
	  							</div>
	  							
	  							<!-- SET DATATABLE -->
							    <table id='filesTable' class='table table-striped' width='100%'>
							       	<thead>							       		
							         	<tr>
								           	<th width="2%"><a href="#" id="select-all"><i class="fas fa-check-double"></i></a></th>
								           	<th width="30%">File Name</th>
								           	<th width="10%">File Type</th>
								           	<th width="10%">File Size</th>
								           	<th width="10%">Share Type</th>
								           	<th width="10%">Upload Date</th>						           	
								           	<th width="13%">Action</th>
							        	</tr>
							       	</thead>
							    </table> <!-- END SET DATATABLE -->

							</form>
	  					</div> <!-- END BOX CONTENT -->


	  				</div>
	  			</div> <!-- END DISPLAY FILES DATA TABLE -->
	  			

	  		</div>
  		</div> <!-- END CONTENT BODY SECTION -->


  		<!-- DELETION CONFIRMATION MODAL -->
  		<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<h4 class="modal-title" id="myModalLabel"><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>
			        	
			      	</div>
			      	<div class="modal-body">
			        	<p>You are about to delete <b class="title"></b> audio file, this procedure is irreversible.</p>
			        	<p>Do you want to proceed?</p>
			     	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        	<button type="button" class="btn btn-danger btn-ok">Delete</button>
			      	</div>
			    </div>
		  	</div>
		</div> <!-- END DELETION CONFIRMATION MODAL -->


		<!-- EMAIL DOWNLOAD LINK MODAL -->
  		<div class="modal fade" id="email-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<h4 class="modal-title" id="myModalLabel">Email Download Link</h4>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>			        	
			      	</div>
			      	<form class="send-email" action="" method="post" enctype="multipart/form-data">
			      		<div class="modal-body">

			      			<div class="file-info">
			      				<h6>Send Download Link for: </h6>
			      				<span class="file"></span>
			      			</div>

				        	<!-- EMAIL ADDRESS -->
							<div class="input-box">								
								<h6>To Email Address</h6>
								<div class="form-group">							    
								    <input type="text" class="form-control" class="email" name="email" id="email" placeholder="Enter Receiver's Email Address" required>
								</div> 
							</div> <!-- END EMAIL ADDRESS -->
							
							<span id="id-number" style="display: none"></span>

							<!-- SUBJECT -->
							<div class="input-box">								
								<h6>Email Subject <small> (optional)</small></h6>
								<div class="form-group">							    
								    <input type="text" class="form-control" class="subject" name="subject" id="subject" placeholder="Enter Subject">
								</div> 
							</div> <!-- END SUBJECT -->


							<!-- MESSAGE -->
							<div class="input-box">								
								<h6>Email Message <small> (optional)</small></h6>
								<div class="form-group">
									<textarea class="form-control" class="message" name="message" id="message" rows="5" maxlength="500" placeholder="Enter Message"></textarea>			
								</div> 
							</div> <!-- END MESSAGE -->
			     		</div>


				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				        	<button type="submit" class="btn btn-ok send-email">Send</button>
				      	</div>

				    </form>

			    </div>
		  	</div>
		</div> <!-- END DELETION CONFIRMATION MODAL -->


		<!-- DELETION ALL CONFIRMATION MODAL -->
  		<div class="modal fade" id="confirm-delete-all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			    <div class="modal-content">			    	
			      	<div class="modal-header">
			      		<h4 class="modal-title" id="myModalLabel"><i class="fas fa-trash-alt"></i> Confirm Delete</h4>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>
			        	
			      	</div>
			      	<form id="delete-files" action="" method="post" enctype="multipart/form-data">
				      	<div class="modal-body">
				        	<p>You are about to delete selected files, this procedure is irreversible.</p>
				        	<p>Do you want to proceed?</p>
				     	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				        	<button type="submit" class="btn btn-danger">Delete</button>
				      	</div>
			      	</form>
			    </div>
		  	</div>
		</div> <!-- END DELETION ALL CONFIRMATION MODAL -->


		<!-- EMAIL DOWNLOAD LINK MODAL -->
  		<div class="modal fade" id="email-link-all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<h4 class="modal-title" id="myModalLabel">Email Download Link</h4>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>			        	
			      	</div>
			      	<form id="send-email-all" action="" method="post" enctype="multipart/form-data">
			      		<div class="modal-body">

			      			<div class="file-info">
			      				<h6>Send Download Link for Selected Files. </h6>

			      			</div>

				        	<!-- EMAIL ADDRESS -->
							<div class="input-box">								
								<h6>To Email Address</h6>
								<div class="form-group">							    
								    <input type="text" class="form-control" class="email" name="email" id="email" placeholder="Enter Receiver's Email Address" required>
								</div> 
							</div> <!-- END EMAIL ADDRESS -->
							
							<span id="id-number" style="display: none"></span>

							<!-- SUBJECT -->
							<div class="input-box">								
								<h6>Email Subject <small> (optional)</small></h6>
								<div class="form-group">							    
								    <input type="text" class="form-control" class="subject" name="subject" id="subject" placeholder="Enter Subject">
								</div> 
							</div> <!-- END SUBJECT -->


							<!-- MESSAGE -->
							<div class="input-box">								
								<h6>Email Message <small> (optional)</small></h6>
								<div class="form-group">
									<textarea class="form-control" class="message" name="message" rows="5" id="message" maxlength="500" placeholder="Enter Message"></textarea>			
								</div> 
							</div> <!-- END MESSAGE -->
			     		</div>


				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				        	<button type="submit" class="btn btn-ok send-email">Send</button>
				      	</div>

				    </form>

			    </div>
		  	</div>
		</div> <!-- END DELETION CONFIRMATION MODAL -->


		


  	</div>
</div>  <!-- END MAIN WRAPPER -->


<!-- INCLUDE HEADER CONTENT -->
<?php include_once __DIR__ . '/../../footer.php'; ?>

