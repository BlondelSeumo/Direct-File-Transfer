

	<!-- TOP NAVBAR -->
	<nav class="main-header navbar navbar-expand fixed-top navbar-white navbar-light">

	    <!-- LEFT TOP NAVBAR LINKS -->
	    <ul class="navbar-nav">
	      	<li class="nav-item">
	        	<a class="nav-link" id="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="" target="_blank" data-toggle="tooltip" data-placement="right" title="Frontend Upload Page"><i class="fas fa-globe-americas"></i></a>
	      	</li>
	    </ul> <!-- END LEFT TOP NAVBAR LINKS -->

	    <!-- RIGHT TOP NAVBAR LINKS -->
	    <ul class="navbar-nav ml-auto">

	      	<!-- ADMIN MENU -->
	      	<li class="nav-item dropdown" id="admin-menu">
	        	<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
	          		<span class="d-md-inline">Admin</span>
	        	</a>
	        	<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right animate__animated animate__bounceIn">

		          	<!-- ADMIN MENU BODY -->
		          	<li>		          		
		            	<a href="index.php" class="btn btn-default"><i class="fas fa-layer-group"></i> Dashboard</a>
		          	</li>
		          	<li>		          		
		            	<a href="pages/settings/profile.page.php" class="btn btn-default"><i class="fas fa-user-cog"></i> Profile Settings</a>
		          	</li>
		          	<li>		          		
		            	<a href="pages/settings/password.page.php" class="btn btn-default"><i class="fas fa-key"></i> Change Password</a>
		          	</li>
		          	<li>		          		
		            	<a href="logout.php" class="btn btn-default"><i class="fas fa-sign-out-alt"></i> Sign out</a>
		          	</li>  
	          	
	        	</ul> 
	      	</li> <!-- END ADMIN MENU -->

	    </ul> <!-- END TOP RIGHT NAVBAR LINKS -->

	</nav> <!-- END TOP NAVBAR -->


	<!-- MAIN SIDEBAR CONTAINER -->
  	<aside class="main-sidebar">

	    <!-- BRAND LOGO -->
	    <a href="#" class="brand-link">
	      	<i class='fab fa-staylinked'></i>
	      	<span class="brand-text">Upload & Share</span>
	    </a>

	    <!-- SIDEBAR -->
	    <div class="sidebar">

	      	<!-- SIDEBAR MENU -->
	      	<nav>
	        	<ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
		          	<li class="nav-item">
		            	<a href="index.php" id="dashboard-page" class="nav-link" >
		              		<i class="nav-icon fas fa-layer-group" title="Dashboard"></i>
		              		<p>
		                		Dashboard
		                		<i class="right fas fa-angle-right"></i>
		              		</p>
		            	</a>
		          	</li>
	          		<li class="nav-header">Upload Data</li>
	          		<li class="nav-item">
	            		<a href="pages/data/files.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-th-large" title="File Uploads Data"></i>
	              			<p>
	                			File Uploads
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-item">
	            		<a href="pages/data/share.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-bezier-curve" title="File Share Data"></i>
	              			<p>
	                			Share Data
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>	          		
	          		<li class="nav-header">Analytics</li>
	          		<li class="nav-item">
	            		<a href="pages/analytics/wasabianalytics.page.php" class="nav-link">
	              			<i class="nav-icon fab fa-staylinked" title="Wasabi Data Metrics"></i>
	              			<p>
	                			Wasabi Data Metrics
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-item">
	            		<a href="pages/analytics/analytics.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-poll-h" title="Google Analytics"></i>
	              			<p>
	                			Google Analytics
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-header">Marketing</li>
	          		<li class="nav-item">
	            		<a href="pages/marketing/adsense.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-ad" title="Google Adsense"></i>
	              			<p>
	                			Adsense
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		
	          		<li class="nav-header">Layouts</li>
	          		<li class="nav-item">
	            		<a href="pages/layouts/frontend.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-palette" title="Frontend Layout"></i>
	              			<p>
	                			Frontend Layout
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-header">Settings</li>
	          		<li class="nav-item">
	            		<a href="pages/settings/wasabicredentials.page.php" class="nav-link">
	              			<i class="nav-icon fab fa-staylinked" title="Wasabi Credentials Settings"></i>
	              			<p>
	                			Wasabi Credentials
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>	          		
	          		<li class="nav-item">
	            		<a href="pages/settings/upload.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-sliders-h" title="Upload Settings"></i>
	              			<p>
	                			Upload Settings
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-item">
	            		<a href="pages/settings/smtp.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-at" title="SMTP Settings"></i>
	              			<p>
	                			SMTP Settings
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>	          			          		
	          		<li class="nav-item">
	            		<a href="pages/settings/google.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-tools" title="Google Settings"></i>
	              			<p>
	                			Google Settings
	                			<i class="fas fa-angle-right right" title="Google Settings"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-item">
	            		<a href="pages/settings/profile.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-user-cog" title="Profile Settings"></i>
	              			<p>
	                			Profile Settings
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		<li class="nav-item">
	            		<a href="pages/settings/password.page.php" class="nav-link">
	              			<i class="nav-icon fas fa-key" title="Password Settings"></i>
	              			<p>
	                			Password Settings
	                			<i class="fas fa-angle-right right"></i>
	              			</p>
	            		</a>
	          		</li>
	          		
	        	</ul>
	      	</nav> <!-- END SIDEBAR MENU -->
	      
	    </div> <!-- END SIDEBAR -->

	    <!-- PAGE FOOTER CONTENT -->
	    <footer class="fixed-bottom">

			<div id="copyright">
				<p>Copyright &copy; 2020</p>
			</div>

			<div id="version">
				<p>Version: 1.0.0</p>
			</div>

		</footer> <!-- END PAGE FOOTER CONTENT -->

  	</aside> <!-- END MAIN SIDEBAR CONTAINER -->