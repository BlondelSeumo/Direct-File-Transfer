<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Notification of Missing DB Credentials</title>

	<link rel="stylesheet" href="admin/assets/client/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700,800" rel="stylesheet">

	<style type="text/css">
		body {
			font-family: 'Poppins',sans-serif;
			background-color: #ECF4F7;
			padding: 10rem;
		}
		.box {
			padding: 4rem;
			background-color: #FFF;
			border-radius: 5px;
			-webkit-box-shadow: 0 0 5px 0 rgba(43,43,43,0.1), 0 11px 6px -7px rgba(43,43,43,0.1);
			box-shadow: 0 0 5px 0 rgba(43,43,43,0.1), 0 11px 6px -7px rgba(43,43,43,0.1);
			border: none;
			margin-bottom: 30px;
			-webkit-transition: all 0.3s ease-in-out;
			transition: all 0.3s ease-in-out;
		}
		h1 {
			text-transform: uppercase;
			font-size: 24px;
			font-weight: 800;
			margin-bottom: 2rem;
		}
		h2 {
			text-transform: uppercase;
			font-size: 20px;
			font-weight: 800;
			margin-top: 4rem;
			text-align: left;
			margin-left: 9rem;
		}
		h4 {
			font-size: 18px;
		}
		h4.left {
			margin-left: 9rem;
		}
	</style>
</head>
<body>

	<div class="container">
		
		<div class="row text-center">
			
			<div class="col-md-12">
				
				<div class="box">
					<h1>Thank you for purchasing Wasabi File Transfer Script</h1>
					<h4>To get started, you will need to include your MySQL DB Credentials</h4>
					<h4>You have 2 options to do that:</h4>

					<h2>Option 1:</h2>
					<h4>Run <b>install.php</b> script in the root directory</h4>

					<h2>Option 2:</h2>
					<h4 class="left">Create DB config manually, simply create a file with <b>dbconfig.core.php</b> name under <b>admin/core</b> directory and include this content in the newly created php file filled with your <b>DB data</b> instead of <b>XXXXXX</b> placeholders.</h4>
					<pre style="text-align: left; margin-left: 5rem; background-color: #ecf4f7; padding-top: 1rem;">
	&lt;php

	define('DBSERVER','XXXXXX');
	define('DBNAME','XXXXXX');
	define('DBUSER','XXXXXX');
	define('DBPASSWORD','');
					</pre>	
				</div>
			</div>

		</div>

	</div>
	
</body>
</html>
