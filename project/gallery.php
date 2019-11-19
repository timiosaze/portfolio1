<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php 
	if(isset($_SESSION['link'])){

	} elseif (isset($_GET['link'])){
		$_SESSION['link'] = $_GET['link'];
	} else {
		redirect("../index.php");
		exit();
	}
 ?>
<?php if(isset($_SESSION['username'])){

		} else {
			redirect("../auth/login.php");
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gallery App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<!-- <style type="text/css">
		.image_gal {
			height: 250px;
			border: 1px solid rgba(0,0,0,0.5);	
			margin: 20px 10px;
			position: relative;
			cursor: pointer;
		}
		.image_gal img {
			position: absolute;
			top:0;
			left: 0;
			z-index: -1;
			width: 100%;
			height: 250px;
    		object-fit: cover;
		}
		.image_box {
			height: 250px;
			margin: 20px 10px;
			position: relative;
			cursor: pointer;
		}
		.image_box img {
			width: 100%;
			height: 250px;
    		object-fit: cover;
		}
		.add-picture p {
			color: rgba(0,0,0,0.5);
			height: 125px;
			text-align: center;
			margin: 0px !important;
		}
		.add-picture p.first {
			padding-top:60px;
			vertical-align: bottom;


		}

		.add-picture {
			/*margin-top: 100px;*/
			vertical-align: middle;
			/*line-height: 250px;*/
		}
		input[type="file"] {
		    display: none;
		}
		.image_upload {
			width: inherit;
			display: block;
			cursor: pointer;
		}
		button .picture-button {
			margin: 0 auto;	
		}
		.fabutton {
		  background: none;
		  padding: 10px;
		  border: none;
		  cursor: pointer;
		}
		.image_box form {
			position: absolute;
			top: 0px;
			right:0px;
			display: none;
			background-color: rgba(0,0,0,0.4);
			z-index: 1;
		}
		.image_box {
			display: inline-block;
    		overflow: hidden;
		}
		.image_box img {
			-webkit-transition: all .2s ease;
		    -moz-transition: all .2s ease;
		    -ms-transition: all .2s ease;
		    -o-transition: all .2s ease;
		    transition: all .2s ease;
		    
		    vertical-align: middle;
		}
		.image_box img:hover, .image_box img:focus{
			-ms-transform: scale(1.2);
		    -moz-transform: scale(1.2);
		    -webkit-transform: scale(1.2);
		    -o-transform: scale(1.2);
		    transform: scale(1.2);
		}
	</style> -->
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	 <div class="container">
	  <a class="navbar-brand" href="#">PORTFOLIO</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav ml-auto">
	      <?php if(isset($_SESSION['username'])): ?>
	  	  <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <?php echo ucfirst($_SESSION['username']); ?>
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="../auth/logout.php">Logout</a>
	        </div>
	      </li>

	  	<?php else: ?>
		      <li class="nav-item active">
		        <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="register.php">Register</a>
		      </li>
		      <!-- <li class="nav-item">
		        <a class="nav-link" href="#">Pricing</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li> -->
		<?php endif; ?>
	    </ul>
	  </div>
	  </div>
	</nav>
	<section class="container">
		<section>
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-12" style="text-align: center;">
					<form>
					<div class="image_gal">
					<label for="file-upload" class="image_upload">
							<div class="add-picture">
								<p class="first"><i class="far fa-image fa-4x"></i></p>
								<p style="font-weight: 700;">Add Picture</p>
							</div>
							<!-- <img src="../images/nyscpic.jpg"> -->
					</label>
					<input id="file-upload" type="file"/>
					</div>
					<button class="btn btn-link picture-button">Save Picture</button>
					</form>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 image_outer" style="text-align: center;">
					<div class="image_box">
						<img src="../images/nyscpic.jpg"/>
						<form>
							<button type="submit" class="fabutton">
								<i class="far fa-trash-alt fa-2x" style="color: red;"></i>
							</button>
						</form>
					</div>
				</div><div class="col-lg-3 col-md-6 col-sm-12 image_outer" style="text-align: center;">
					<div class="image_box">
						<img src="../images/nyscpic.jpg"/>
						<form>
							<button type="submit" class="fabutton">
								<i class="far fa-trash-alt fa-2x" style="color: red;"></i>
							</button>
						</form>
					</div>
				</div><div class="col-lg-3 col-md-6 col-sm-12 image_outer" style="text-align: center;">
					<div class="image_box">
						<img src="../images/nyscpic.jpg"/>
						<form>
							<button type="submit" class="fabutton">
								<i class="far fa-trash-alt fa-2x" style="color: red;"></i>
							</button>
						</form>
					</div>
				</div><div class="col-lg-3 col-md-6 col-sm-12 image_outer" style="text-align: center;">
					<div class="image_box">
						<img src="../images/nyscpic.jpg"/>
						<form>
							<button type="submit" class="fabutton">
								<i class="far fa-trash-alt fa-2x" style="color: red;"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</section>
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>