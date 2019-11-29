<?php require_once("includes/config.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Adegbulugbe Timilehin | Portfolio</title>
	<link rel="stylesheet" type="text/css" href="bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="styles/app.css">
</head>
<body>
	<?php include("includes/navbar.php"); ?>
	<section class="profile">
		<div class="img">
			<img src="images/timipic.jpeg" class="pic">
		</div>
		<div class="social-icons">
			<a href="#"><i class="fab fa-github fa-2x"></i></a>
			<a href="#"><i class="fab fa-linkedin fa-2x"></i></a>
		</div>
		<div class="profile-details">
			<p><span id="dev_name">ADEGBULUGBE TIMILEHIN OSAZE</span><br>
			<span id="field">WEB DEVELOPER</span><br>
			<span id="skill">PHP | LARAVEL | BASIC FRONTEND</span></p>
		</div>
	</section>
	<section class="portfolio">
		<div class="container">
			<p id="header">Portfolio</p>
			<div class="row justify-content-around">
				<div class="red col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<a href="project/notes.php?link=note">
					<div class="project ">
						<p>A <br> Simple Note App</p>
					</div>	
					</a>
				</div>
				<div class="red col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<a href="project/contacts.php?link=contact">
					<div class="project ">
						<p>A <br> Simple Contact App</p>
					</div>
					</a>
				</div>
				<div class="red col-lg-3 col-md-6 col-sm-12 col-xs-12">
					<a href="project/appointments.php?link=appointment">
						<div class="project ">
							<p>A <br> Simple Meeting App</p>
						</div>	
					</a>
				</div>
				
			</div>
		</div>
	</section>
</body>
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="bootstrapv4/js/bootstrap.min.js"></script>
</html>