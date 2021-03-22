<?php include ( "./inc/header.inc.php"); 
//if(!isset( $_SESSION['user_login'])) {
//	header("Location: index.php");
//}

?>

<?php
	/*xxx*/$filtrado = test_input($_GET['us']);
$us = mysqli_real_escape_string($con,$filtrado);
	/*xxx*/$filtrado = test_input($_GET['code']);
$code = mysqli_real_escape_string($con,$filtrado);

$query=mysqli_query($con,"SELECT * FROM users WHERE username='$us'");
while($row=mysqli_fetch_assoc($query)){
	$db_code=$row['comodin'];
}
if($code==$db_code){
	echo"	
		<form method='post'><br/><center>
			<p><h2><i class='fa fa-lock fa-lg' aria-hidden='true'></i><b> CHANGE YOUR PASSWORD:</b></h2></p><br/><hr /><br/>
			<input type='password' name='newpassword' id='newpassword' size='40' placeholder='New password'> <br />
			<input type='password' name='newpassword2' id='newpassword2' size='40' placeholder='Repeat new password'> <br />
			<br /><input type='submit' name='senddata' id='senddata' Value='UPDATE'> <br /></center>
		</form><br/><hr /><br/>	
	";	
}
else{
	echo"Email and reset code do not match.";//errormsg
}

$senddata=$_POST ['senddata'];
if($senddata){
		/*xxx*/$filtrado = test_input($_POST['newpassword']);
	$new_password= mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['newpassword2']);
	$repeat_password= mysqli_real_escape_string($con,$filtrado);
	if ($new_password == $repeat_password){
		if(strlen($new_password) <=5){
			echo "<br/> Sorry, your password must be more than 6 characters long. <br/> ";//errormsg
		}
		else{
			$new_password_md5 = md5($new_password);
			$password_update_query = mysqli_query($con,"UPDATE users SET password='$new_password_md5' WHERE username='$us'");
			echo "<script> alert('Your password has been updated. Try to log in now using your new password!')</script>";
		}
	}
	else{
		echo "<script> alert('Your new passwords do not match. Please, try again.')</script>";//errormsg
	}
}

?>
<?php include ( "./inc/footer.inc.php")?>