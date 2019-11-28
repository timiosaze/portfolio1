<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>
<?php
	if(isset($_GET['c_id'])){
		$id = escape($_GET['c_id']);
	} else {
	 	redirect("../contacts.php");
	 	exit();
	}
	if(isset($_POST['update_contact'])){
		if(empty(trim($_POST['contact_name'])) || empty(trim($_POST['contact_number']))){
			$_SESSION['alert-danger'] ="Contact fields must be filled";
		} else {
		$contact_name = escape($_POST['contact_name']);
		$contact_number = escape($_POST['contact_number']);

		$query = "UPDATE contacts SET ";
		$query .= "contact_name = '{$contact_name}', ";
		$query .= "contact_number = '{$contact_number}' ";
		$query .= " WHERE id = '{$id}'";

		$insert_query = mysqli_query($connection, $query);

		// confirmQuery($insert_query);
		if($insert_query){
			$_SESSION['alert-success'] = "Contact was successfully updated";
			
		}else {
			$_SESSION['alert-danger'] ="Contact was not updated";

		}
		redirect("contacts.php");
		exit();
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
		/*.header {
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
			
		}
		.header-topic p {
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
		}*/
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
			 <?php 
			 	$user_id = $_SESSION['id'];
			 	$id = $_GET['c_id'];
			 	$query = "SELECT * FROM contacts WHERE id = '{$id}'";
			 	$select_query = mysqli_query($connection, $query);

			 	confirmQuery($select_query);
			 	while($row = mysqli_fetch_assoc($select_query)){
			 		$the_user_id = $row['user_id'];
			 		$contact_name = $row['contact_name'];
			 		$contact_number = $row['contact_number'];
			 	}

			 	if($user_id != $the_user_id){
			 		echo "YOU ARE NOT THE OWNER OF THIS CONTACT";
			 	} else {
			  ?>
			  <div class="form-group">
			    <label for="contact_name">Name</label>
			    <input type="text" class="form-control" id="contact_name" aria-describedby="emailHelp" name="contact_name" placeholder="Enter name" value="<?php echo $contact_name; ?>">
			  </div>
			  <div class="form-group">
			    <label for="phonenumber">Phone Number</label>
			    <input type="number" class="form-control" id="phonenumber" placeholder="Phone number" name="contact_number" min="11" value="<?php echo $contact_number; ?>">
			  </div>
			  <button type="submit" class="btn btn-dark" name="update_contact">Submit</button>
			<?php } ?>
			</form>
		</div> 
	</section>
	
	
	</section>
</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/contacts.js"></script>

</html>