<?php
include("./inc/header.inc.php");
	if(!isset( $_SESSION['user_login'])) {
		header("Location: index.php");
	}

if($username){
	if(isset($_POST['no'])){
		header("Location:account_settings.php"); 
	}
	if(isset($_POST['yes'])){
		$closeaccount=mysqli_query($con,"UPDATE users SET closed='yes' WHERE username='$username'"); 
		echo"<br/><br/>Your account has been closed";//errormsg
		session_destroy();
	}
}
else{
	die("");
}
?>
<br />
<center>
	<form action="close_account.php" method="POST"><br />
		<br />Are you sure you want to close your account?<br />
		<br />
		<input type="submit" name="no" value="No">
		<input type="submit" name="yes" value="Yes, Close it">
	</form>
</center>