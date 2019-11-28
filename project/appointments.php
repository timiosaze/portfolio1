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
<?php 
	if(isset($_GET['del_id'])){
		$user_id = $_SESSION['id'];
		$id = $_GET['del_id'];

		$check_query = "SELECT user_id FROM meetings WHERE id = '$id'";
		$check_user_query = mysqli_query($connection, $check_query);
		confirmQuery($check_user_query);
		$the_user_id = mysqli_fetch_array($check_user_query)[0];

		if(mysqli_num_rows($check_user_query) == 0){
			$_SESSION['alert-danger'] = "Meeting does not exist";
			redirect("appointments.php");
			exit();
		} elseif($the_user_id != $user_id) {
			$_SESSION['alert-danger'] = "Meeting does not belong to YOU";
			redirect("appointments.php");
			exit();
		} else {
			$query = "DELETE FROM meetings WHERE id = '$id' LIMIT 1";
			$delete_query = mysqli_query($connection, $query);
			confirmQuery($delete_query);
			if($delete_query){
				$_SESSION['alert-success'] = "Meeting successfully deleted";
				redirect("appointments.php");
				exit();
			} else {
				$_SESSION['alert-danger'] = "Meeting not deleted";
				redirect("appointments.php");
				exit();
			}
		}
	}	
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Appointments App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="../clockpicker-gh-pages/dist/bootstrap-clockpicker.min.css"> -->
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
		.contact_name, .contact_number {
			text-align: center;
			line-height: 25px;
			height: 25px;
			font-size: 1.15em;
			font-family: 'Open Sans';
			font-style: normal;
		}
		.contact_name {
			font-weight: 300;
			color:#3828e0;
		}
		.contact_number {
			font-weight: 600;
		}
		.col .edit-form a {
			color: #3828e0;

		}
		.col .delete-form a {
			color: #db2e1f;
		}
		.appoint_time, .appoint_title {
			padding-top: 10px;
			text-align: center;
		}
		.appoint_time {
			font-weight: 700;
			color: #3828e0;
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
		
	<section class="header">
		<div class="header-topic container-fluid">
			<p>New Appointment</p>
		</div>
		<div class="post">
			<?php if(isset($_POST['submit'])){
						if(empty(trim($_POST['meeting'])) || empty(trim($_POST['meeting_date']))){
							$_SESSION['alert-danger'] = "Not saved, fields are not filled";
						} else {
							$user_id = $_SESSION['id'];
							$meeting = escape($_POST['meeting']);
							$meeting_date = escape($_POST['meeting_date']);

							$query = "INSERT INTO meetings (user_id, meeting, meeting_date) ";
							$query .= "VALUES ('{$user_id}', '{$meeting}', '{$meeting_date}')";
							$insert_query = mysqli_query($connection, $query);

							confirmQuery($insert_query);
							if($insert_query){
								$_SESSION['alert-success'] = "Meeting was successfully saved";
							} else {
								$_SESSION['alert-danger'] = "Meeting was not saved";
							}
						}
					} 
			?>
			<form class="container-fluid" method="post" enctype="multipart/form-data">
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
				    <label for="exampleFormControlTextarea1">Appointment</label>
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Meeting" rows="3" name="meeting"></textarea>
				</div>
				<div class="form-group">
				    <label >Appointment Time</label>
				    <input type="text" class="form-control clockpicker" name="meeting_date">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
				<button type="submit" class="btn btn-dark"  name="submit">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<?php

			$user_id = $_SESSION['id'];
			//GET THE CURRENT PAGE
			if(isset($_GET['p'])){
				$pageno = $_GET['p'];
			}else {
				$pageno = 1;
			}

			//FORMULA FOR PAGINATION 
			$no_of_records_per_page = 5;
			$offset = ($pageno -1) * $no_of_records_per_page;

			//GET THE TOTAL NUMBER OF PAGES
			$total_pages_sql = "SELECT COUNT(*) FROM meetings WHERE user_id = '$user_id'";
			$pages_result = mysqli_query($connection, $total_pages_sql);
			$total_row = mysqli_fetch_array($pages_result)[0];
			$total_pages = ceil($total_row/$no_of_records_per_page);


			$c_query ="SELECT * FROM meetings WHERE user_id = '$user_id' ORDER BY meeting_date DESC LIMIT $offset, $no_of_records_per_page";
			$check_row = mysqli_query($connection, $c_query);

			confirmQuery($check_row);
			if(mysqli_num_rows($check_row) == 0){
				echo "No meetings set";
			} else {
		 ?>
		<div class="header-topic container-fluid">
			<p>APPOINTMENTS(click to edit or delete)</p>
		</div>
		<?php 
			$select_row = mysqli_query($connection, $c_query);

			confirmQuery($select_row);
			while($row = mysqli_fetch_assoc($select_row)){
				$id = $row['id'];
				$meeting = $row['meeting'];
				$meeting_date = $row['meeting_date'];
		 ?>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col-10 appoint_title">
							<p> <?php echo $meeting; ?></p>
						</div>
						<div class="col-2 time_date">
							<div class="col appoint_time">
								<p><?php echo date("g:ia", strtotime($meeting_date)); ?></p>
							</div>
							<div class="col appoint_date">
								<p><?php echo date("M d, Y", strtotime($meeting_date)); ?></p>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="edit_appoint.php?a_id=<?php echo $id; ?>">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="appointments.php?del_id=<?php echo $id; ?>">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>

		</div>
	<?php } ?>
		<ul class="pagina">
			<?php if($pageno<=1 && $total_pages==1): ?>

			<?php elseif($pageno<=1 && $total_pages>1): ?>
			<li class="float-right"><a href="appointments.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno != $total_pages): ?>
			<li class="float-left"><a href="appointments.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<li class="float-right"><a href="appointments.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno == $total_pages): ?>
			<li class="float-left"><a href="appointments.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<?php endif; ?>
		</ul>
	<?php } ?>
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- ClockPicker script -->
<!-- <script type="text/javascript" src="../clockpicker-gh-pages/dist/bootstrap-clockpicker.min.js"></script> -->
<script type="text/javascript" src="../scripts/script.js"></script>
<script type="text/javascript">
$('.clockpicker').flatpickr({
	enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today"
});
</script>

</html>