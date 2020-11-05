<?php 
  session_start(); 

  include('./lib/db.php');

  if (!$_SESSION['logged_in']) { 
  	$_SESSION['msg'] = "You must log in first!";
  	header('location: ../../index.php');
  }
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon"  href="/img/icons/favicon.ico" type="image/png"/>
	<title>Dashboard - myGAT.ml</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="vendors/linericon/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
	<link rel="stylesheet" href="vendors/animate-css/animate.css">
	<link rel="stylesheet" href="vendors/flaticon/flaticon.css">
	<!-- main css -->
	<link rel="stylesheet" href="css/style.css">
</head>

<body{
    position: fixed; 
    overflow: hidden;
	width: 100%;
	height: 100%;
}>

	<header class="header_area">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="dashboard.php"><img src="img/logo.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav justify-content-center">
							<!--<li class="nav-item active"><a class="nav-link" href="dashboard.php">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="/lib/logout.php" name="logout_user">Log Out</a></li>-->
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item" style="padding:1em 0em 0em 0em"><a href="/lib/logout.php" class="primary_btn text-uppercase">log out</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<section class="impress_area">
		<div class="container">
			<div class="impress_inner">
				<h2>Welcome back, <?php echo($_SESSION['username'])?>!!!</h2>
				<p>Thank you for being with us.</p>
				<p><h2>The displays you own are:</h2></p>
				<div class="container">
              		<?php 
				
						$query = "SELECT panels.id, paneltype, token, temperature, brightness FROM panelOwner, panels WHERE panelOwner.user='".$_SESSION['username']."' and panels.id = panelOwner.id "; 
                		$result = mysqli_query($mysqli, $query);
				
						echo "<table border='1' class='table table-hover'><tr><th  style='color:white;'>Panel ID</th><th style='color:white;'>Panel Type</th><th style='color:white;'>Token</th><th style='color:white;'>Temperature</th><th style='color:white;'>Brightness (%)</th></tr>";
						while ($panel = mysqli_fetch_row($result)){
							echo "<tr><td><a class=\"primary_btn\"><span>";
							echo ($panel[0]);
							echo "</span></a></td><td style='color:white;'>";
							echo ($panel[1]);
							echo "</td><td style='color:white;'>";
							echo ($panel[2]);
							echo "</td><td style='color:white;'>";
							echo ($panel[3]);
							echo "</td><td style='color:white;'>";
							echo ($panel[4]);
							echo "</td></tr>";
						}
						echo "</table>";

              		?>
				</div> 
			</div>
		</div>
	</section>
</body>
</html>