<?php include ( "./inc/header.inc.php"); 
?>

<?php
	/*xxx*/$filtrado = test_input($_GET['u']);
$u = mysqli_real_escape_string($con,$filtrado);
	/*xxx*/$filtrado = test_input($_GET['code']);
$code = mysqli_real_escape_string($con,$filtrado);

$query=mysqli_query($con,"SELECT * FROM users WHERE username='$u'");
while($row=mysqli_fetch_assoc($query)){
	$db_code=$row['bio'];
	$db_id=$row['id'];
	$db_country=$row['country'];
}
if($code==$db_code){
		mysqli_query($con,"UPDATE users SET activated='1', bio='Type something about you...' WHERE username='$u'");
		mysqli_query($con,"INSERT INTO ranking VALUES ('$db_id','$u','$db_country','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')");
		echo'</br><center>Thank you, you email has been confirmed, Pease click here to <a href="/index.php">LOG IN</a></center></br>';//errormsg
}
else{
	echo"Username and activation code do not match.";//errormsg
}
?>

<?php include ( "./inc/footer.inc.php")?>