<?php 

ob_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'fadman4real');
define('DB_NAME', 'port_pdl');

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$connection){
	die("ERROR: Could not connect" . mysqli_connect_error());
} else {
	// echo "Connection is successful";
}