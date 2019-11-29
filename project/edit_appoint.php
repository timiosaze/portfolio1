<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>


<!DOCTYPE html>
<html>
<head>
	<title>Appointments App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
			<?php 
					if(isset($_GET['a_id'])){
						$id = escape($_GET['a_id']);
					} else {
						redirect("appointments.php");
						exit();
					}
					if(isset($_POST['update'])){
						
						if(empty(trim($_POST['meeting'])) || empty(trim($_POST['meeting_date']))){
							$_SESSION['alert-danger'] = "Not saved, fields are not filled";
						} else {
							$meeting = escape($_POST['meeting']);
							$meeting_date = escape($_POST['meeting_date']);

							$query = "UPDATE meetings SET ";
							$query .= "meeting = '{$meeting}', ";
							$query .= "meeting_date = '{$meeting_date}' ";
							$query .= "WHERE id = '$id'";

							$edit_query = mysqli_query($connection, $query);

							confirmQuery($edit_query);
							if($edit_query){
								$_SESSION['alert-success'] = "Meeting successfully updated";
								redirect("appointments.php");
								exit();
							} else {
								$_SESSION['alert-danger'] = "Meeting not updated";
								redirect("appointments.php");
								exit();
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
				<?php 
					$user_id = $_SESSION['id'];
					if(isset($_GET['a_id'])){
						$id = $_GET['a_id'];

						$query = "SELECT * FROM meetings WHERE id = '$id' LIMIT 1";
						$update_query = mysqli_query($connection, $query);

						if(mysqli_num_rows($update_query) == 0){
							redirect("appointments.php");
							exit();
						}
						while($row = mysqli_fetch_assoc($update_query)){
							$the_user_id = $row['user_id'];
							$meeting = $row['meeting'];
							$meeting_date = $row['meeting_date'];
						}

					}
					if($user_id != $the_user_id) {
						echo "YOU ARE NOT THE OWNER OF THIS APPOINTMENT";
					} else {
				 ?>

				<div class="form-group">
				    <label for="exampleFormControlTextarea1">Appointment</label>
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Meeting" rows="3" name="meeting"><?php echo $meeting; ?></textarea>
				</div>
				<div class="form-group">
				    <label >Appointment Time</label>
				    <input type="text" class="form-control clockpicker" name="meeting_date" value="<?php echo $meeting_date; ?>">
				    <span class="input-group-addon">
				        <span class="glyphicon glyphicon-time"></span>
				    </span>
				</div>
				<button type="submit" class="btn btn-dark"  name="update">Update</button>
			<?php } ?>
			</form>
		</div> 
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