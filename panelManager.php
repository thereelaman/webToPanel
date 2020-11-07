<?php 
  session_start();
  include('./lib/db.php');

  $hasThePanelChanged = isset($_GET['id']) & (isset($_SESSION['id']) != isset($_GET['id']));
  $isThereNoSessionData = !isset($_SESSION['id']) & !isset($_SESSION['paneltype']) & !isset($_SESSION['token']);
  
  if ($hasThePanelChanged | $isThereNoSessionData) {
	$_SESSION['id'] = $_GET['id'];
	$_SESSION['paneltype'] = $_GET['paneltype'];
	$_SESSION['token'] = $_GET['token'];
  }

  $msg = "";

  if (!$_SESSION['logged_in']) { 
  	$_SESSION['msg'] = "You must log in first!";
  	header('location: ../../index.php');
  }

  if (isset($_POST['upload'])) { 
  
    $filename = $_FILES["uploadfile"]["name"]; 
    $tempname = $_FILES["uploadfile"]["tmp_name"];     
	$folder = "userimages/";
	$targetFile =  $folder.basename($filename);
  
	//update the image in the database
    $query = "UPDATE panel SET data = '$filename' WHERE panels.id ='".$_SESSION['id']."'"; 
  	mysqli_query($mysqli, $query); 
          
    // Now let's move the uploaded image into the folder: image 
    if (move_uploaded_file($tempname, $targetFile))  { 
        $msg = "Image uploaded successfully."; 
    }else{ 
        $msg = "Failed to upload image."; 
    } 
  } 

?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon"  href="/img/icons/favicon.ico" type="image/png"/>
	<title>Panel Manager</title>
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

<body>
	<header class="header_area">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container" style="padding-top: 16px !important;">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="dashboard.php"><img src="img/logo.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav justify-content-center">
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item" ><a href="/lib/logout.php" class="primary_btn text-uppercase">log out</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<section class="impress_area">
		<div class="container">
			<h1 style = "color:white;" >
               	<?php
					echo "You are working on the ";
					echo $_SESSION['paneltype'];
					echo " panel with id = ";
					echo $_SESSION['id'];
					echo ". ";

					$query = "SELECT data FROM panels WHERE id = '".$_SESSION['id']."'";
					$result = mysqli_query($mysqli, $query);
					$row = mysqli_fetch_assoc($result);

					if (mysqli_num_rows($result) == 1)	{				  
						echo "<br>And the image currently being displayed is: ";
						echo "<img src=\"userimages/";
						echo $row['data'];
						echo "\" alt=\"The image being displayed on the panel.\">";
					}
					else{
						  echo "<br>And there's no image currently being displayed on your panel. Please upload an image!";
					}
               	?>
			</h1>

			<form method="POST" action="./panelManager.php" enctype="multipart/form-data"> 
				<p style="color:white;">Select a new image to upload. The image must match the size on your panel (ie. a 32x32 panel needs a 32x32 pixel image.)</p>
      			<div class="container"> 
					<div class="form-inline">
						<input style="color:white" type="file" name="uploadfile" value=""/>
						<button class="primary_btn" type="submit" name="upload">Upload</button>
					</div>
        		</div> 
  			</form> 

		</div>
	</section>
</body>
</html>