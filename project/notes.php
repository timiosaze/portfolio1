<?php 
	$time = microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$start = $time;
 ?>
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
			$check_query = "SELECT * FROM notes WHERE id = '$id'";
			$check_user_query = mysqli_query($connection, $check_query);
			confirmQuery($check_user_query);
			
			if(mysqli_num_rows($check_user_query)==0){
				$_SESSION['alert-danger'] = "Note does not exist";
				redirect("notes.php");
				exit();
			} else {
				while($row = mysqli_fetch_assoc($check_user_query)){
					$the_user_id = $row['user_id'];
				}
			}
			if($the_user_id != $user_id){
				$_SESSION['alert-danger']="Note does not belong to YOU";
				redirect("notes.php");
				exit();
			} else {
				$query = "DELETE FROM notes WHERE id = {$id}";
				$deletequery = mysqli_query($connection, $query);

				if($deletequery){
					$_SESSION['alert-success'] = "Note was successfully deleted";
				} elseif(!$deletequery) {
					$_SESSION['alert-danger'] = "Note was not deleted";
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
				    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="New Note" rows="3" name="note"></textarea>
				</div>
				<button type="submit" class="btn btn-dark" name="submit">Submit</button>
			</form>
		</div> 
	</section>
	<section class="header">
		<?php 
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
<?php 
	$time= microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	echo "Page generated in " . $total_time . " seconds";
 ?>