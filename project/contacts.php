<?php 
	$time = microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$start = $time;
 ?>
<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>
<?php 
	if(isset($_GET['del_contact_id'])){

		$user_id = $_SESSION['id'];
		$id = $_GET['del_contact_id'];
		$check_query = "SELECT * FROM contacts WHERE id = '$id'";
		$check_user_query = mysqli_query($connection, $check_query);

		confirmQuery($check_user_query);
		if(mysqli_num_rows($check_user_query) == 0){
			$_SESSION['alert-danger'] = "Contact does not exist";
			redirect("contacts.php");
			exit();
		} else {
			while($row = mysqli_fetch_assoc($check_user_query)){
				$the_user_id = $row['user_id'];
			}
		}
		if($the_user_id != $user_id){
			$_SESSION['alert-danger'] = "Contact does not belong to YOU";
			redirect("contacts.php");
			exit();
		} else {
			$query = "DELETE FROM contacts WHERE id = '$id'";
			$delete_query = mysqli_query($connection, $query);

			if($delete_query){
				$_SESSION['alert-success'] = "Contact was successfully deleted";
			}else {
				$_SESSION['alert-danger'] ="Contact was not deleted";

			}
		}
	} 
?>
<?php 
	if(isset($_POST['save_contact'])){
		if(empty(trim($_POST['contact_name'])) || empty($_POST['contact_number'])){
			$_SESSION['alert-danger'] ="Not saved fields are not filled";
		} else {
			$user_id = $_SESSION['id'];
			$contact_name = escape($_POST['contact_name']);
			$contact_number = escape($_POST['contact_number']);

			$query = "INSERT INTO contacts (contact_name, contact_number, user_id) ";
			$query .= "VALUES ('{$contact_name}', '{$contact_number}', '{$user_id}') ";
			$insert_query = mysqli_query($connection, $query);

			confirmQuery($insert_query);
			if($insert_query){
				$_SESSION['alert-success'] = "Contact was successfully saved";
			}else {
				$_SESSION['alert-danger'] ="Contact was not saved";
			}
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact App | Adegbulugbe Timilehin</title>
	<link rel="stylesheet" type="text/css" href="../bootstrapv4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../fonts/css/all.css">
	<link rel="stylesheet" type="text/css" href="../styles/app.css">
	<style type="text/css">
	</style>
</head>
<body>
	<?php include("../includes/navbar.php"); ?>
	
	<section class="container">
		
	<section class="header">
		<div class="header-topic container-fluid">
			<p>Add New Contact</p>
		</div>
		<div class="post">
			<form class="container-fluid" method="post">
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
			    <label for="contact_name">Name</label>
			    <input type="text" class="form-control" id="contact_name" aria-describedby="emailHelp" name="contact_name" placeholder="Enter name">
			  </div>
			  <div class="form-group">
			    <label for="phonenumber">Phone Number</label>
			    <input type="number" class="form-control" id="phonenumber" placeholder="Phone number" name="contact_number" min="11">
			  </div>
			  <button type="submit" class="btn btn-dark" name="save_contact">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<?php 
			$user_id = $_SESSION['id'];
			$query = "SELECT * FROM contacts WHERE user_id = '$user_id'";

			$check_row = mysqli_query($connection, $query);
			confirmQuery($check_row);

			if(mysqli_num_rows($check_row) == 0){
				echo "No records yet";
			} else {
		 ?>
		<div class="header-topic container-fluid">
			<p>NUMBERS(click to edit | delete)</p>
		</div>
		<?php 
			//GET THE CURRENT PAGE
			if(isset($_GET['p'])){
				$pageno = $_GET['p'];
			} else {
				$pageno = 1;
			}

			// FORMULA FOR PAGINATION
			$no_of_records_per_page = 5;
			$offset = ($pageno-1) * $no_of_records_per_page;

			//GET THE NUMBER OF PAGES
			$total_pages_sql = "SELECT COUNT(*) FROM contacts WHERE user_id = '$user_id'";
			$pages_sql = mysqli_query($connection, $total_pages_sql);
			$no_of_rows = mysqli_fetch_array($pages_sql)[0];
			$total_pages = ceil($no_of_rows / $no_of_records_per_page);

			$s_query = "SELECT * FROM contacts WHERE user_id = '$user_id' ORDER BY contact_name ASC LIMIT $offset, $no_of_records_per_page";
			$select_query = mysqli_query($connection, $s_query);
			confirmQuery($select_query);

			while($row=mysqli_fetch_assoc($select_query)){
				$contact_name = $row['contact_name'];
				$contact_number = $row['contact_number'];
				$contact_id = $row['id'];
			
		 ?>
		<div class="element-group">
			<div class="element">
				<div class="container">
					<div class="row">
						<div class="col contact_name">
							<p><?php echo $contact_name; ?></p>
						</div>
						<div class="col contact_number">
							<p><?php echo $contact_number; ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="edit_contacts.php?c_id=<?php echo $contact_id; ?>">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm" class="delete-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="contacts.php?del_contact_id=<?php echo $contact_id; ?>" onclick="document.getElementById('editForm').submit();">DELETE</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php 
			} 
		 ?>
		<ul class="pagina">
			<?php if($pageno<=1 && $total_pages==1): ?>

			<?php elseif($pageno<=1 && $total_pages>1): ?>
			<li class="float-right"><a href="contacts.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno != $total_pages): ?>
			<li class="float-left"><a href="contacts.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<li class="float-right"><a href="contacts.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno == $total_pages): ?>
			<li class="float-left"><a href="contacts.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<?php endif; ?>
		</ul>
	<?php } ?>
	</section>
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/contacts.js"></script>

</html>
<?php 
	$time= microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	echo "Page generated in " . $total_time . " seconds";
 ?>