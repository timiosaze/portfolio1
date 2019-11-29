<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>
<?php 
	if(isset($_GET['del_id'])){
		$user_id = $_SESSION['id'];
		$id = escape($_GET['del_id']);

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
</head>
<body>
	<?php include("../includes/navbar.php"); ?>
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
			 <?php include("../includes/sessions.php"); ?>
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