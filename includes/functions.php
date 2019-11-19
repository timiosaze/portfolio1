<?php
function redirect($location){
		
	return header("Location:" . $location);
}

function escape($string) {
	global $connection;
	return mysqli_real_escape_string($connection, trim($string));
}

function confirmQuery($result){
	global $connection;
	if(!$result){
		die("QUERY FAILED". mysqli_error($connection));
	}
}

function username_exists($username){
	global $connection;

	$username = mysqli_real_escape_string($connection, $username);

	$query = "SELECT username FROM users WHERE username = '$username'";

	$check_username_query = mysqli_query($connection, $query);

	confirmQuery($check_username_query);

	if(mysqli_num_rows($check_username_query) > 0){
		
		return true;

	} else {
		
		return false;
	
	}
}

function email_exists($user_mail){
	global $connection;

	$usermail = mysqli_real_escape_string($connection, $user_mail);
	
	$query = "SELECT usermail FROM users WHERE usermail = '$usermail'";
	
	$check_email_query = mysqli_query($connection, $query);
	
	confirmQuery($check_email_query);

	if(mysqli_num_rows($check_email_query) > 0){
	
		return true;
	} else {
	
		return false;
	}

}

function register_user($username, $user_mail, $password){
	global $connection;
	$username = mysqli_real_escape_string($connection, $username);
	$user_mail = mysqli_real_escape_string($connection, $user_mail);
	$password = mysqli_real_escape_string($connection, $password);

	// ENCRYPT PASSWORD
	$password = password_hash($password, PASSWORD_BCRYPT, array('cost' =>12));

	$query ="INSERT INTO users (username, usermail, password, created_at) ";
	$query .= "VALUES('{$username}', '{$user_mail}', '{$password}', now())";

	$register_user_query = mysqli_query($connection, $query);

	confirmQuery($register_user_query);

}
function login_user($username, $password){
	global $connection;

	$username = escape($username);
	$password = escape($password);

	$query = "SELECT * FROM users WHERE username = '$username'";
	$select_query = mysqli_query($connection, $query);
	$nuw_rows = mysqli_num_rows($select_query);
	if(mysqli_num_rows($select_query) > 0){
		while($row = mysqli_fetch_array($select_query)){
			$user_name = $row['username'];
			$user_id = $row['id'];
			$user_password = $row['password'];
		}
		if(password_verify($password, $user_password)){
			$_SESSION['username'] = $user_name;
			$_SESSION['id'] = $user_id;

			switch($_SESSION['link']){
				case "note":
					redirect("../project/notes.php");
					exit();
					break;
				case "contact":
					redirect("../project/contacts.php");
					exit();
					break;
				case "appointment":
					redirect("../project/appointments.php");
					exit();
					break;
				case "gallery":
					redirect("../project/gallery.php");
					exit();
					break;
				default:
					$_SESSION['error_login'] = "Login details correct"; 
					redirect("../auth/login.php");
					exit();
			}
		// redirect("../project/notes.php");
		// exit();
		} 
	} else {
		$_SESSION['error_login'] = "Login details not correct"; 
		redirect("../auth/login.php");
		exit();
		
	}
	// if($num_rows==0){
		
	// 	$_SESSION['error_login'] = "Login details not correct"; 
	// 	redirect("../auth/login.php");
	// 	exit();
	// } else {
	// 	while($row = mysqli_fetch_array($select_query)){
	// 		$user_name = $row['username'];
	// 		$user_id = $row['id'];
	// 		$user_password = $row['password'];
	// 	}
	// 	if(password_verify($password, $user_password)){
	// 		$_SESSION['username'] = $user_name;
	// 		$_SESSION['id'] = $user_id;

	// 		switch($_SESSION['link']){
	// 			case "note":
	// 				redirect("../project/notes.php");
	// 				exit();
	// 				break;
	// 			case "contact":
	// 				redirect("../project/contacts.php");
	// 				exit();
	// 				break;
	// 			case "appointment":
	// 				redirect("../project/appointments.php");
	// 				exit();
	// 				break;
	// 			case "gallery":
	// 				redirect("../project/gallery.php");
	// 				exit();
	// 				break;
	// 			default:
	// 				$_SESSION['error_login'] = "Login details correct"; 
	// 				redirect("../auth/login.php");
	// 				exit();
	// 		}
	// 	// redirect("../project/notes.php");
	// 	// exit();
	// 	} 
	// }

	

	
	
}