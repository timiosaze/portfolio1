<?php require_once("../includes/config.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Adegbulugbe Timilehin | Portfolio</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<style type="text/css">
		.auth {
			width: 100%;
			max-width: 320px;
			min-width: 300px;
			border: 1px solid black;
			border-radius: 5px;
			margin: 100px auto;
		}
		.auth label {
			font-size: 2em;
			font-weight: 700;
		}
		.auth button {
			margin-bottom: 10px;
		}
	</style>
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
	          <a class="dropdown-item" href="#">Logout</a>
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
		<section class="auth">
			<form autocomplete="off" id="login_form" method="post" action="../includes/login.php">
			  <div class="container">
			  <label>Login</label>
			  <?php if(isset($_SESSION['error_login'])){
			  	  echo "<div class='alert alert-danger' role='alert'>". $_SESSION['error_login'] ."</div>";
			  	  unset($_SESSION['error_login']);
			  	  
			  }
			   ?>	
			  <div class="form-group">
			    <input type="text" class="form-control" id="name" placeholder="Enter name" name="username">
			  </div>
			  <div class="form-group">
			    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
			  </div>
			  <button type="submit" class="btn btn-primary" name="login">Submit</button>
			</div>
			</form>
		</section>
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>
<script type="text/javascript" src="../scripts/auth.js"></script>

</html>