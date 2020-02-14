<?php
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GameTracker.pw- mobile</title>
	<link rel="stylesheet" href="/m/css/bootstrap.css">
	<link rel="stylesheet" href="/m/css/bootstrap-responsive.css">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/m/css/toggle-switch.css">
	<link rel="stylesheet" href="/m/css/style.css">
	<!--[if lt IE 9]>
	<script src="dist/html5shiv.js"></script>
	<![endif]-->
</head>
<body>

		<div class="navbar">
			<div style="width:100%">
					<div class="navbar-inner">
						<ul class="nav">
		  					<li><a href="/m/index.php"><img style="max-height:30px;" src="/img/mygame.png"></a></li>
		  					<li><a href="/m/index.php">Pocetna</a></li>
		  					<li><a href="/m/servers">Serveri</a></li>
							</ul>
					</div> <!-- /.navbar-inner -->
				</div> <!-- /.navbar -->
		</div> <!-- /row -->

		<br>
		
<div class="container">
		
           <?php
		   define("access", 1);
		   
		   if($_GET['page'] == "servers"){
			   include("servers.php");
		   } else if($_GET['page'] == "server_info"){
			   include("server_info.php");
		   } else {
			   include("main.php");
		   }
		   ?>

	</div> <!-- /container -->

	<!-- JavaScript -->
	<script src="/m/js/jquery-1.10.1.min.js"></script>
	<script src="/m/js/bootstrap.js"></script>

</body>
</html>