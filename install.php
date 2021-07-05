<?php

# Check if POST was sent
if (isset($_POST['submit'])) {
	
	# Define all db input variables
   $db_host = filter_input(INPUT_POST, 'db_host', FILTER_SANITIZE_STRING);
   $db_username = filter_input(INPUT_POST, 'db_username', FILTER_SANITIZE_STRING);
   $db_name = filter_input(INPUT_POST, 'db_name', FILTER_SANITIZE_STRING);
   $db_password = filter_input(INPUT_POST, 'db_password', FILTER_SANITIZE_STRING);



  	$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);


   	if (empty($db_host) || empty($db_username) || empty($db_name)) {
              
               $error='<div class="alert alert-danger">All fields are required!</div>';
 
    } else if ($mysqli->connect_errno > 0) {

               $error = '<div class="alert alert-danger">Database connection failed!</div>';

    } else {

        $connect_code="<?php
        define('DBSERVER','".$db_host."');
        define('DBNAME','".$db_name."');
        define('DBUSER','".$db_username."');
        define('DBPASSWORD','".$db_password."');
        ";
        

        $fp = fopen('admin/core/dbconfig.core.php', 'w');
        fwrite($fp,$connect_code);
        fclose($fp);
        
        Header('Location: index.php');
        exit();
  }

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Notification</title>

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
					<h1>Wasabi Direct Multipart File Transfer</h1>
					<h4>Database Configuration</h4>
					
					<form action="" method="POST" autocomplete="off">
                                     
                         <?php if (isset($error)) {echo htmlspecialchars($error, ENT_COMPAT, 'UTF-8');} ?>
                         <div class="describe">
                            <h1>Database Information:</h1>
                         </div> 
                         <div class="form-group">
						    <input type="text" class="form-control" name="db_host" placeholder="Enter your Database Host" required>
						  </div>

						  <div class="form-group">
						    <input type="text" class="form-control" name="db_name" placeholder="Enter your Database Name" required>
						  </div>

						  <div class="form-group">
						    <input type="text" class="form-control" name="db_username" placeholder="Enter your Database User" required>
						  </div>

						  <div class="form-group">
						    <input type="text" class="form-control" name="db_password" placeholder="Enter your Database Password">
						  </div>                               
                                                 
                        <div class="submit">
                            <input class="btn btn-primary" type="submit" name="submit" value="Install" >
                        </div>                             
                                            
                    </form>

				</div>
			</div>

		</div>

	</div>
	
</body>
</html>
