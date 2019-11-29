<?php 
	if(isset($_SESSION['alert-success'])){
		echo "<div class='alert alert-success' role='alert'>". $_SESSION['alert-success'] . "</div>";
		unset($_SESSION['alert-success']);
	} elseif(isset($_SESSION['alert-danger'])){
		echo "<div class='alert alert-danger' role='alert'>". $_SESSION['alert-danger'] . "</div>";
		unset($_SESSION['alert-danger']);
	}
 