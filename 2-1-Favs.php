<?php
include ("./inc/header.inc.php"); 
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
if (isset($_GET['u'])) {	//anything stored in after u= is stored in the get u variable.
	
	/*xxx*/$filtrado = test_input($_GET['u']);
	$username = mysqli_real_escape_string($con,$filtrado);

	if (ctype_alnum($username)) {	//Checking the username is only numbers and letters.
		//check user exists and his first name
		$check = mysqli_query($con,"SELECT username, first_name FROM users WHERE username='$username'");
		if (mysqli_num_rows($check)===1) {
			$get = mysqli_fetch_assoc($check);
			$username = $get['username'];
			$firstname = $get['first_name'];
		}
		else{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://".$dominio.".com\">";//Anadido ".$dominio."; Sin ello funcionaba****
			exit();
		}
	}
}
?>
<br/>
<b><h2><center><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>  <?php echo$username?>'s FAVs</center></h2></b></br>
<hr /><br />
<?php
//get favs
$fav_mini=mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$username' && removed='n'");
$fav_mini_count=mysqli_num_rows($fav_mini);
if ($fav_mini_count !=0){
//	$i=0;
//	$max=12;
	while (($minifav=mysqli_fetch_assoc($fav_mini) )){	
		$i++;
		$friendusername=$minifav['user_to'];
		$getfriendquery=mysqli_query($con,"SELECT * FROM users WHERE username='$friendusername' LIMIT 1");
		$getfriendrow=mysqli_fetch_assoc($getfriendquery);

		$friendprofilepic=$getfriendrow['profile_pic'];
		
		if($friendprofilepic == ""){
			echo "<center><div class='favs'><a href='$friendusername'><img src='img/imgpic.jpg' alt=\"$friendusername's Profile\" title=\"$friendusername's Profile\" height='50' width='40' style='padding-right:6px'><br/>$friendusername</a></div></center>";
		}
		else{
			echo "<center><div class='favs'><a href='$friendusername'><img src='userdata/profile_pics/$friendprofilepic' alt=\"$friendusername's Profile\" title=\"$friendusername's Profile\" height='50' width='40' style='padding-right:7px'><br/>$friendusername</a></center>";
		}
	}
}
else{
echo $username." has no FAVs yet.";
}

?><br/><hr/><br/>