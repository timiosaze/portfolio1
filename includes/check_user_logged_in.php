<?php 
	if(isset($_SESSION['username'])){

	} else {
		redirect("../auth/login.php");
	}