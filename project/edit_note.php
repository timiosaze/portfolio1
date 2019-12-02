<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Notes App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
</head>
<body>
	<?php 
		#UPDATE ROUTE
		if(isset($_GET['n_id'])){
			$the_note_id = escape($_GET['n_id']);
		} else {
			redirect("notes.php");
			exit();
		}
		
		if(isset($_POST['update'])){
			if(empty(trim($_POST['note']))){
				$_SESSION['alert-danger'] = "Note field empty";
			}else {
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
	}
	 ?>
	<?php include("../includes/navbar.php"); ?>
	
	<section class="container">
		
	<section class="header">
		<div class="header-topic container-fluid">
			<p>Add New Note</p>
		</div>
		<div class="post">

			<?php 
					#READ NOTE OF THE USER USING THE ID
					if(isset($_GET['n_id'])){
						$the_note_id = escape($_GET['n_id']);
					}

					$user_id = $_SESSION['id'];
					$query = "SELECT * FROM notes WHERE id = '$the_note_id'";
					$update_query = mysqli_query($connection, $query);
					
					if(mysqli_num_rows($update_query) == 0){
						redirect("notes.php");
						exit();
					}

					while($row = mysqli_fetch_assoc($update_query)){
						$the_user_id = $row['user_id'];
						$note = $row['note'];
						$updated_at = $row['updated_at'];
					}

					#CHECK IF THE USER LOGGED IN IS THE OWNER OF THE NOTE
					if($user_id != $the_user_id){
						echo "YOU ARE NOT THE OWNER OF THIS NOTE";
					} else {
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
		<?php } ?>
		</div> 
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>