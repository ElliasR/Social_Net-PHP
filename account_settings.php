<?php
include ("inc/header.inc.php");
if (!isset($_SESSION["user_login"])) { 
	header("Location: index.php");
}
else{
	$username = $_SESSION["user_login"]; 
}
?>
<?php	//PASSWORD RESET
$senddata=$_POST ['senddata'];
	/*xxx*/$filtrado = test_input($_POST['oldpassword']);
$old_password = mysqli_real_escape_string($con,$filtrado);
	/*xxx*/$filtrado = test_input($_POST['newpassword']);
$new_password = mysqli_real_escape_string($con,$filtrado);
	/*xxx*/$filtrado = test_input($_POST['newpassword2']);
$repeat_password = mysqli_real_escape_string($con,$filtrado);

if($senddata) {
	$password_query = mysqli_query($con,"SELECT * FROM users WHERE username='$username'");
	while ($row=mysqli_fetch_assoc($password_query))
		$db_password=$row['password'];
		$old_password_md5 = md5 ($old_password);
		if($old_password_md5 == $db_password){
			if ($new_password == $repeat_password){
				if(strlen($new_password) <=5){
					echo "<br/> Sorry, your password must be more than 6 characters long. <br/> ";//errormsg
				}
				else{
					$new_password_md5 = md5($new_password);
					$password_update_query = mysqli_query($con,"UPDATE users SET password='$new_password_md5' WHERE username='$username'");
					echo "<br/> Your password has been updated<br/> ";//errormsg
				}
			}
			else{
				echo "<br/> Your new passwords do not match, try again <br/> ";//errormsg
			}
		}
		else{
			echo "<br/> The old password is incorrect, please try again <br/> ";//errormsg
		}
}
else{
	echo "";
}
//FIRST NAME, LAST NAME, BIO	
	
$get_info=mysqli_query($con,"SELECT first_name, last_name, bio FROM users WHERE username='$username'");
$get_row=mysqli_fetch_assoc($get_info);
$db_first_name=$get_row['first_name'];
$db_last_name=$get_row['last_name'];
$db_bio=$get_row['bio'];

$updateinfo= @$_POST['updateinfo'];
if($updateinfo){ 	
		/*xxx*/$filtrado = test_input($_POST['fname']);
	$firstname = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['lname']);
	$lastname = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['bio']);
	$bio = mysqli_real_escape_string($con,$filtrado);

	
	if (strlen($firstname)<1){$firstname=$db_first_name;}
	if (strlen($lastname)<1){$lastname=$db_last_name;}
	if (strlen($bio)<1) {$bio=$db_bio;}
	
	if (strlen($firstname)<2) {
		echo "<br/> Your first name must be at least two characters long.<br/> ";//errormsg
	}
	if (strlen($lastname)<2) {
		echo "<br/> Your last name must be at least two characters long.<br/> ";//errormsg
	}
	else
	{
		$info_submit_query=mysqli_query($con,"UPDATE users SET first_name='$firstname', last_name='$lastname', bio='$bio' WHERE username='$username'");
		echo "<br/> Your profile has been updated with the new information provided <br/> ";//errormsg
		header("Location: account_settings.php");
	}
}

//PROFILE PIC
$check_pick = mysqli_query ($con , "SELECT profile_pic FROM users WHERE username='$username'");
$get_pick_row = mysqli_fetch_assoc ($check_pick);
$profile_pic_db = $get_pick_row ['profile_pic'];
if($profile_pic_db=="") {
	$profile_pic ="img/imgpic.jpg";
}
else{
	$profile_pic="userdata/profile_pics/".$profile_pic_db;
}
//Profile image upload script
if (isset($_FILES['profilepic'])) {
	if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png")|| (@$_FILES["profilepic"]["type"]=="image/gif")) && (@$_FILES["profilepic"]["size"] < 1048576)){
		$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$rand_dir_name = substr(str_shuffle($chars), 0, 15);
		mkdir("userdata/profile_pics/$rand_dir_name");
	
		if(file_exists ("userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"])){
			echo @$_FILES["profilepic"]["name"]." already exists";//errormsg
		}
		else{
			move_uploaded_file (@$_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
			$profile_pic_name=@$_FILES["profilepic"]["name"];
			$profile_pic_query=mysqli_query($con,"UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username='$username'");//pyok
			header ("Location:account_settings.php");
		}
	}
	else{
		echo"<br/> Invalid file, image must be smaller than a MB and .jpg, JPG, jpeg, JPEG, gif, GIF, PNG or png";//errormsg
	}
}
?></br>
<b><h2><center><i class="fa fa-cog fa-lg" aria-hidden="true"></i>  ACCOUNT SETTINGS</center></h2></b></br>
<hr />
<a onclick="document.getElementById('content').style.display=(document.getElementById('content').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-camera fa-1g"></i> 
Profile Image</h2></a>
<form id="content" style="display:none;" action="" method="POST" enctype="multipart/form-data">
	</br><center><img src="<?php echo $profile_pic; ?>" width="70"></br></br>
	<input type="file" name="profilepic" /><br/>
	<br/><input type="submit" name="uploadpic" value="UPLOAD IMAGE"/></center> <br/>
</form> 

<!--<hr />-->
<a onclick="document.getElementById('content1').style.display=(document.getElementById('content1').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-lock fa-1g"></i>  
Change Password</h2></a>
<form id="content1" style="display:none;" action="account_settings.php" method="post">
	</br><center><input type="password" name="oldpassword" id="oldpassword" size="40" placeholder="Old password"> <br />
	<input type="password" name="newpassword" id="newpassword" size="40" placeholder="New password"> <br />
	<input type="password" name="newpassword2" id="newpassword2" size="40" placeholder="Repeat new password"> <br />
<br /><input type="submit" name="senddata" id="senddata" Value="UPDATE"></center> <br />
</form>
<!--<hr />-->
<a onclick="document.getElementById('content2').style.display=(document.getElementById('content2').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-info-circle fa-1g"></i> 
Profile Info</h2></a>
<form id="content2" style="display:none;" action="account_settings.php" method="post">
	<center></br><input type="text" name="fname" id="fname" size="40" placeholder="<?php echo "FIRST NAME: ".$db_first_name; ?>"> <br />
	<input type="text" name="lname" id="lname" size="40" placeholder="<?php echo "LAST NAME: ".$db_last_name; ?>"> <br />
	</br><b><p>About You: </p><textarea name="bio" id="bio" rows="6 cols"="60" maxlength="50"><?php echo $db_bio;?></textarea></b>
	<br/><br/><input type="submit" name="updateinfo" id="updateinfo" Value="UPDATE"></center></br>
</form>
<!--<hr />-->
<a onclick="document.getElementById('content3').style.display=(document.getElementById('content3').style.display=='none')?'block':'none';"><h2 class="hiding">  <i class="fa fa-times fa-1g"></i> 
Close Account</h2></a>
<form id="content3" style="display:none;" action="close_account.php" method="post">
	</br><center><input type="submit" name="closeaccount" id="closeaccount" Value="CLOSE ACCOUNT"></center>
	<br />
</form>
<hr /><br/>

<?php include ( "./inc/footer.inc.php")?>