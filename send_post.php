<?php
include ("./inc/connect.inc.php");
session_start();
if (!isset($_SESSION["user_login"])) { 
	$user = $_SESSION["user_login"];
}
else{
	$user="";
}
$post = $_POST['post'];
if ($post != ""){
	$date_added = date("Y-m-d");
	$added_by ="$user";
	$user_posted_to = "test123";

	$sqlCommand = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$added_by', '$user_posted_to')";
	$query = mysqli_query($con,$sqlCommand) or die (mysqli_error($con));
}
else{
	echo "You must enter the required information before it can be uploaded";
}
?>