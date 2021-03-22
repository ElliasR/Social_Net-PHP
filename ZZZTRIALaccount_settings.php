<?php
include ("inc/header.inc.php");
if (!isset($_SESSION["user_login"])) { //diferente en 15min11
	die("You must be logged in first to get access!");///$user=And66;$username=And66;
	}
	else{
	$username = $_SESSION["user_login"]; 
}
?>
<?php

	$updateinfo= @$_POST['updateinfo'];
	
	//First name, last name, bio info displayed before changing it
	$get_info=mysqli_query($con,"SELECT first_name, last_name, bio FROM users WHERE username='$username'");
	$get_row=mysqli_fetch_assoc($get_info);
	$db_first_name=$get_row['first_name'];
	$db_last_name=$get_row['last_name'];
	$db_bio=$get_row['bio'];

	
	
	
	
	
	//Submit and update new name, last name, bio in the database-----------------------------------------------------------------------
	if($updateinfo){ //update values
	
	/*function test_input($data) {
		$data = trim($data); // removes \0\t\n\x0B\r" "
		$data = stripslashes($data);
		$data = htmlspecialchars($data); //Transforms "&'<> into html entities
		//  $data = preg_replace('#[^A-Za-z0-9]#i', '', $data);
		  return $data;
		}*/
	
		
		$firstname = test_input($_POST['fname']);
		$lastname = $_POST['lname'];
		$bio= strip_tags($_POST['bio']);
		$firstname = mysqli_real_escape_string($con,$firstname);
		
$query = mysqli_query($con,"INSERT INTO zzzpruebas VALUES ('','$lastname')");
$query2 = mysqli_query($con,"SELECT * FROM zzzpruebas WHERE texto='$lastname'");	//azua'");--
$numrows=mysqli_num_rows($query2);
if(numrows>="1"){
	echo "Si-------------------------************************************************SELECT * FROM zzzpruebas WHERE texto='".$lastname."' \");</br>";
}
	
		
		echo "nada123-".$firstname."--456</br>";
		echo "</br>strip_tags123-".$lastname."--456</br>";

		$newstr = filter_var($firstname, FILTER_SANITIZE_STRING);
		echo "</br>filter123-".$newstr."--456</br>";
		
		$newstr2 = mysqli_real_escape_string($con,$firstname);
		echo "</br>real-escape-123-".$newstr2."--456</br>";
		
		$newstr = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
		echo "</br>SPEACIALCHARS123-".$newstr."--456</br>";

		$newstr = filter_var($firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		echo "</br>FULLSPEACIALCHARS123-".$newstr."--456</br>";
		
		$newstr = filter_var($firstname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		echo "</br>FULLSPEACIALCHARS123-".$newstr."--456</br>";
	}
	else{
	//do nothing
	}
	
	
	
	
	
	
	
	
	
	
	

?>

<hr /><br/>
<a onclick="document.getElementById('content2').style.display=(document.getElementById('content2').style.display=='none')?'block':'none';"><h2 class="hiding" style='max-width:230px;'> 
Update your profile info</h2></a></br>
<form id="content2" style="display:none;" action="" method="post">
<input type="text" name="fname" id="fname" size="40" placeholder="<?php echo "FIRST NAME: ".$db_first_name ?>"> <br />
<input type="text" name="lname" id="lname" size="40" placeholder="<?php echo "LAST NAME: ".$db_last_name ?>"> <br />
<b><p>About You: </p><textarea name="bio" id="bio" rows="6 cols"="60"><?php echo $db_bio?></textarea></b>
<br/>
<br/><input type="submit" name="updateinfo" id="updateinfo" Value="UPDATE"> <br />
<br />
