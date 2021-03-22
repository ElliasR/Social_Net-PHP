<?php
include ("inc/header.inc.php");
/*if (!isset($_SESSION["user_login"])) { 
	header("Location: index.php");
}
else{
	$username = $_SESSION["user_login"]; 
}*/
?>
<?php	
//FIRST NAME, LAST NAME, BIO	
$get_info=mysqli_query($con,"SELECT first_name, last_name, bio FROM users WHERE username='$username'");
$get_row=mysqli_fetch_assoc($get_info);
$db_first_name=$get_row['first_name'];
$db_last_name=$get_row['last_name'];
$db_bio=$get_row['bio'];

$formsubmit= @$_POST['form'];
if($formsubmit){ 	
		/*xxx*/$filtrado = test_input($_POST['fname']);
	$firstname = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['lname']);
	$lastname = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['email']);
	$em = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['email2']);
	$em2 = mysqli_real_escape_string($con,$filtrado);
			/*xxx*/$filtrado = test_input($_POST['query']);
	$qtype = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['bio']);
	$qbody = mysqli_real_escape_string($con,$filtrado);
	$date= date('Y-m-d H:i:s');

		
	if (strlen($qbody) > 22 && strlen($qbody) < 500) {
		if ($em==$em2) {
			
			$info_submit_query=mysqli_query($con,"INSERT INTO contactus VALUES ('','$qbody','$date','$firstname','$lastname','$em','$qtype')");
			echo "<br/> Thank you very much for your message. We will work on it to get it sorted!";//errormsg
		}
		else{
			echo "<br/> Your Emails do not match, please try again <br/>";//errormsg
		}
	}
	else{
		echo"Your message needs to be between 22 and 500 characters long, Please, check it and try again";//errormsg
	}
}
?></br>
<b><h2><center><i class="fa fa-envelope fa-lg" aria-hidden="true"></i>  CONTACT US </center></h2></b></br>
<hr />
<a><h2 class="hidingborder"> <i class="fa fa-info-circle fa-1g"></i> 
Please, Complete the form.</h2></a>
<form id="content2" action="" method="post">
	<center></br>
		<input type="text" name="fname" id="fname" size="40" placeholder="First name" required="required"> <br />
		<input type="text" name="lname" id="lname" size="40" placeholder="Last name" required="required"> <br />
		<input type="email" name="email" size="25" placeholder="Email address" required="required"/><br/>
		<input type="email" name="email2" size="25" placeholder="Email address (repeat)" required="required"/><br/>
		<select name="query" required><option value="">PLEASE, SELECT</option><option value="suggestion">Suggestion</option><option value="issue">Malfunction</option><option value="abuse">Report Abuse</option><option value="query">Query</option><option value="other">Other</option></select><br/>
		</br><br/><b><p>Issue Description (500 max.): </p>
		<textarea name="bio" id="bio" rows="6" cols"="60" maxlength="500" required="required"></textarea></b>
		<br/><br/><input type="submit" name="form" id="form" Value="UPDATE">
	</center></br>
</form>
<hr />
<br />