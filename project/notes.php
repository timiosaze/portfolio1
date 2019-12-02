<?php include('../includes/config.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php session_start(); ?>
<?php include('../includes/check_link.php'); ?>
<?php include('../includes/check_user_logged_in.php'); ?>
<?php 
		#DELETE ROUTE
		if(isset($_GET['del_id'])){

			$user_id = $_SESSION['id'];
			$id = escape($_GET['del_id']);
			$check_query = "SELECT user_id FROM notes WHERE id = '$id'";
			$check_user_query = mysqli_query($connection, $check_query);
			confirmQuery($check_user_query);
			$the_user_id = mysqli_fetch_array($check_user_query)[0];
			
			if(mysqli_num_rows($check_user_query)==0){
				$_SESSION['alert-danger'] = "Note does not exist";
				redirect("notes.php");
				exit();
			} elseif($the_user_id != $user_id) {
				$_SESSION['alert-danger'] = "Meeting does not belong to YOU";
				redirect("notes.php");
				exit();
			} else {
				$query = "DELETE FROM notes WHERE id = {$id}";
				$deletequery = mysqli_query($connection, $query);

				if($deletequery){
					$_SESSION['alert-success'] = "Note was successfully deleted";
					redirect("notes.php");
					exit();
				} elseif(!$deletequery) {
					$_SESSION['alert-danger'] = "Note was not deleted";
					redirect("notes.php");
					exit();
				}
			}
		}
	 ?>
	 
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
		#CREATE ROUTE
		if(isset($_POST['submit'])){
			if(empty(trim($_POST['note']))){
				$_SESSION['alert-danger'] = "Not saved field are not filled";

			} else {

				$user_id = $_SESSION['id'];
				$note = escape($_POST['note']);


				$query = "INSERT INTO notes (user_id, note, created_at) ";
				$query .= "VALUES ('{$user_id}', '{$note}', now())";
				$insert_query = mysqli_query($connection, $query);

				if($insert_query){
					$_SESSION['alert-success'] = "Note was successfully saved";
				} else {
					$_SESSION['alert-danger'] = "Note was not saved";
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

			<form  method="post" class="container-fluid" enctype="multipart/form-data">
			 <?php include("../includes/sessions.php"); ?>
				<div class="form-group">
				    <!-- <label for="exampleFormControlTextarea1">Example textarea</label> -->
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Note" rows="3" name="note"></textarea>
				</div>
				<button type="submit" class="btn btn-dark" name="submit">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<?php 
			#CHECK IF ANY NOTE EXISTS OF THE USER
			$user_id = $_SESSION['id'];
			$c_query ="SELECT * FROM notes WHERE user_id = '$user_id'";
			$check_query = mysqli_query($connection, $c_query);

			confirmQuery($check_query);
			if(mysqli_num_rows($check_query) == 0){
				echo "No records yet";
			} else {
		 ?>
		<div class="header-topic container-fluid">
			<p>NOTES(click to edit or delete)</p>
		</div>
		<?php 
				#READ ROUTE WITH MAXIMUM OF 5 PER PAGE
						$user_id = $_SESSION['id'];
					// GET CURRENT PAGE number
					  if(isset($_GET['p'])){
					  	$pageno = $_GET['p'];
					  } else {
					  	$pageno = 1;
					  }

					  // FORMULA FOR PAGINATION
					  $no_of_records_per_page = 5;
					  $offset = ($pageno-1) * $no_of_records_per_page;

					  //GET THE TOTAL NUMBER OF PAGES
					  $total_pages_sql = "SELECT COUNT(*) FROM notes WHERE user_id = '$user_id'";
					  $pages_result = mysqli_query($connection, $total_pages_sql);
					  $total_rows = mysqli_fetch_array($pages_result)[0];
					  $total_pages = ceil($total_rows / $no_of_records_per_page);

					  
					$query = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY updated_at DESC LIMIT $offset,$no_of_records_per_page ";

					$select_all_query = mysqli_query($connection, $query);

					while($row = mysqli_fetch_assoc($select_all_query)){
						$id = $row['id'];
						$note = $row['note'];
						$updated_at = $row['updated_at'];
		?>
		<div class="element-group">
			<div class="element">
				
				
				<p><?php echo $note; ?><br> 
				<span class="time"><?php  
					$d = strtotime($updated_at);
				echo date('M j, Y | h:ia', $d); ?></span>
				</p>
			</div>
			<div class="container actions">
				<div class="row inside-container">
					<div class="col">
						<form id="editForm <?php echo "editnote" . $id;  ?>	" class="edit-form">
							<!-- <span class="time">11:34pm</span> -->
							<a href="edit_note.php?n_id=<?php echo $id; ?>" onclick="document.getElementById('<?php echo "editnote" . $id;  ?>').submit();">EDIT</a>
							<!-- <button type="button" class="btn btn-secondary btn-sm">Edit</button>	 -->
						</form>
					</div>
					<div class="col">
						<form id="editForm <?php echo "deletenote" . $id;  ?>" class="delete-form" method="post">

							<a href="notes.php?del_id=<?php echo $id; ?>" onclick="document.getElementById('<?php echo "deletenote" . $id;  ?>').submit();">DELETE</a>
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
			<li class="float-right"><a href="notes.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno != $total_pages): ?>
			<li class="float-left"><a href="notes.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<li class="float-right"><a href="notes.php?p=<?php echo $pageno+1; ?>">Next</a></li>
			<?php elseif($pageno == $total_pages): ?>
			<li class="float-left"><a href="notes.php?p=<?php echo $pageno-1; ?>">Previous</a></li>
			<?php endif; ?>
		</ul>
	<?php } ?>
	</section>
			
	</section>

</body>
<script type="text/javascript" src="../jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../bootstrapv4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/script.js"></script>

</html>