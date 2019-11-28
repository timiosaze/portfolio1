<?php 
	if(isset($_SESSION['link'])){

	} elseif (isset($_GET['link'])){
		$_SESSION['link'] = $_GET['link'];
	} else {
		redirect("../index.php");
		exit();
	}
