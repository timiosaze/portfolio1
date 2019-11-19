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
	<title>Notes App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<!-- <style type="text/css">
		.header {
			width: 100%;
			max-width: 500px;
			min-width: 300px;
			margin: 30px auto;
			background-color: #fff;
		}
		.header .element {
			width: inherit;
			border-bottom: 1px solid #f1f1f1;
			border-left: 2px solid #3828e0;
			padding: 10px;
		}
		.header .element-group {
			width:inherit;
		}
		.header .element .time {
			font-size: 0.85em;
			color: #3828e0;
			font-weight: 300;
		}
		.header .element:hover {
			background-color: #FDFEF3;
			cursor: pointer;
		}
		.header .element:hover .actions {
			visibility: visible;
		}
		.header .header-topic {
			width: inherit;
			height: 30px;
			background-color: #000;
			/*margin-bottom: 30px;*/
			/*border-bottom: 1px solid black;*/
		}
		.header-topic p {
			/*padding: px;*/
			line-height: 30px;
			font-size: 15px;
			color:#fff;
		}
		.header .post {
			padding: 30px 0px;
			background-color: #fff;

		}
		.element-group .actions {
			display: none;
		}
		.editForm, .deleteForm {
			display: inline-block !important;
		}
		.element-group .inside-container {
			height: 40px;
			background-color: rgba(0,0,0,0.4);
			border: 1px solid black;
		}
		.col form {
			text-align: center;
			line-height: 40px;
			font-size: 1.3em;
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 600;
		}
		.col .edit-form a {
			color: #3828e0;

		}
		.col .delete-form a {
			color: #db2e1f;
		}
	</style> -->
</head>
<body>
	<?php 
		if(isset($_GET['n_id'])){
			$the_note_id = escape($_GET['n_id']);
		}
		
		if(isset($_POST['update'])){
			$user_id = $_SESSION['id'];
			$note = escape($_POST['note']);

			$query = "UPDATE notes SET ";
			$query .= "note = '{$note}' ";
			$query .= "WHERE id = '{$the_note_id}'";

			
			$update_query = mysqli_query($connection, $query);

			if($update_query){
				$_SESSION['alert-success'] = "Note was successfully updated";
				redirect('notes.php');
				exit();
			} else {
				$_SESSION['alert-danger'] = "Note was not updated";
				redirect('notes.php');
				exit();
			}
		}
	 ?>
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
		
	<section class="header">
		<div class="header-topic container-fluid">
			<p>Add New Note</p>
		</div>
		<div class="post">

			<?php 
					if(isset($_GET['n_id'])){
						$the_note_id = escape($_GET['n_id']);
					}

					$user_id = $_SESSION['id'];
					$query = "SELECT * FROM notes WHERE id = '$the_note_id'";

					$select_all_query = mysqli_query($connection, $query);

					while($row = mysqli_fetch_assoc($select_all_query)){
						$note = $row['note'];
						$updated_at = $row['updated_at'];
					}
			?>
			<form  method="post" class="container-fluid" enctype="multipart/form-data">
				<?php 
					if(isset($_SESSION['alert-success'])){
						echo "<div class='alert alert-success' role='alert'>". $_SESSION['alert-success'] . "</div>";
						unset($_SESSION['alert-success']);
					} elseif(isset($_SESSION['alert-danger'])){
						echo "<div class='alert alert-danger' role='alert'>". $_SESSION['alert-danger'] . "</div>";
						unset($_SESSION['alert-danger']);
					}
				 ?>
				<div class="form-group">
				    <!-- <label for="exampleFormControlTextarea1">Example textarea</label> -->
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Note" rows="3" name="note"><?php echo $note; ?></textarea>
				</div>
				<button type="submit" class="btn btn-dark" name="update">Submit</button>
			</form>
		</div> 
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>