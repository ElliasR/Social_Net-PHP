<?php
include ("./inc/header.inc.php"); 
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
if (isset($_GET['u'])) {	//anything stored in after u= is stored in the get u variable.
	/*xxx*/$filtrado = test_input($_GET['u']);
	$username = mysqli_real_escape_string($con,$filtrado);
	if ($username!="") {	
		$check = mysqli_query($con,"SELECT username, first_name FROM users WHERE username='$username'");
		if (mysqli_num_rows($check)===1) {
			$get = mysqli_fetch_assoc($check);
			$username = $get['username'];
		}
		else{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://$dominio.com/1home.php\">";
			exit();
		}
	}
	else{
		echo "<meta http-equiv=\"refresh\" content=\"0; url=http://$dominio.com/1home.php\">";
	}
}
$ae=$_SESSION["user_login"];
?>
<br/>
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"> </i> <?php echo $username;?>'s Albums</center></h2></b></br>
<hr />
<form method='POST' action=''>
	<input type='submit' name='view_album_body' value='Albums BODY'>
</form>

<?php
if(isset($_POST['view_album_body'])){
	$get_albums=mysqli_query($con,"SELECT * FROM catbody2nd");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><i class='fa fa-child fa-lg' aria-hidden='true'> BODY albums </i>";
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['bodyid'];
		$album_title=$row['bodysub'];

		if($username==$ae){
		$aei='view_photo.php?uid=' .$id. '';
		}
		else{
		$aei='rate_body.php?bodycatid=9&bodysubid=' .$id. '&username2='.$username. '&favs=0&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
		$numphotos=mysqli_num_rows($get_user_photos);
		$imgg=mysqli_fetch_assoc($get_user_photos);
		$imggg=$imgg['image_url'];
		if ($numphotos>0 ){
			echo"
			<td>
			<center>
			<div class='albums'>
			<a href=$aei>
			<img src='$imggg' style='max-height:85%; max-width:85%; margin-top:2%;'><br />
			<b> $id - $album_title</b> 
			</a>
			</div>
			</center>
			</td></br>
			";
		
		}
	}
}
?>
<form method='POST' action=''>
	<input type='submit' name='view_album_car' value='Albums CAR'>
</form>
<?php
if(isset($_POST['view_album_car'])){
	$get_albums=mysqli_query($con,"SELECT * FROM catcars WHERE master='0'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br></br><i class='fa fa-car fa-lg' aria-hidden='true'> CAR albums </i>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['model'];

		if($username==$ae){
		$aei='view_photo_car.php?uid2=' .$id. '';
		}
		else{
		$aei='rate_car.php?carcatid=' .$id. '&carsubid=0&username2='.$username.'&component=0&modelyear=0&favs=0&tags=&country=&daysago=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_car WHERE username='$username' AND uid2='$id' AND removed='no' ORDER BY id DESC");
		$numphotos=mysqli_num_rows($get_user_photos);
		$imgg=mysqli_fetch_assoc($get_user_photos);
		$imggg=$imgg['image_url'];
		if ($numphotos>0 ){
			echo"
			<td>
			<center>
			<div class='albums'>
			<a href=$aei>
			<img src='$imggg' style='max-height:85%; max-width:85%; margin-top:2%;'><br />
			<b> $id - $album_title</b> 
			</a>
			</div>
			</center>
			</td></br>
			";
		
		}
	}
}
?>
<form method='POST' action=''>
	<input type='submit' name='view_album_clothes' value='Albums CLOTHES'>
</form>
<?php
if(isset($_POST['view_album_clothes'])){
	echo "<meta http-equiv=\"refresh\" content=\"0; url=http://".$dominio.".com/view_album_clo.php?u=".$username."\">";
}	
?>
<form method='POST' action=''>
	<input type='submit' name='view_album_soli' value='Albums SOLIDARITY'>
</form>
<?php
if(isset($_POST['view_album_soli'])){
	$get_albums=mysqli_query($con,"SELECT * FROM catsoli WHERE master='0'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br></br><i class='fa fa-heart fa-lg' aria-hidden='true'> SOLIDARITY albums </i>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['model'];

		if($username==$ae){
		$aei='view_photo_soli.php?uid=' .$id. '';
		}
		else{
		$aei='rate_soli.php?solicat=' .$id. '&username2='.$username. '&favs=0&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_soli WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
		$numphotos=mysqli_num_rows($get_user_photos);
		$imgg=mysqli_fetch_assoc($get_user_photos);
		$imggg=$imgg['image_url'];
		if ($numphotos>0 ){
			echo"
			<td>
			<center>
			<div class='albums'>
			<a href=$aei>
			<img src='$imggg' style='max-height:85%; max-width:85%; margin-top:2%;'><br />
			<b> $id - $album_title</b> 
			</a>
			</div>
			</center>
			</td></br>
			";
		
		}
	}
}
?><br/>
<hr />