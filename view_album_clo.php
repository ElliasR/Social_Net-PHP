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
?></br></br><img src="./img/clo.png" style="background-color:transparent; max-width:20px;max-height:20px;"><span style="color:blue;"> CLOTHES albums </span><br/>
<br/>
<form method="POST" action="">
	<input type="submit" name="WsClothing" value="W's Clothing" style="background-color:rgb(255,174,201);">
</form>
<?php
if(isset($_POST['WsClothing'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50030'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s W's Clothing albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=0&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="WsAccessories" value="W's Accessories" style="background-color:rgb(255,174,201);">
</form>
<?php
if(isset($_POST['WsAccessories'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50040'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s W's Accessories albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="WsUnderwear" value="W's Underwear" style="background-color:rgb(255,174,201);">
</form>
<?php
if(isset($_POST['WsUnderwear'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50050'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s W's Underwear albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="WsShoes" value="W's Shoes" style="background-color:rgb(255,174,201);">
</form>
<?php
if(isset($_POST['WsShoes'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50060'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s W's Shoes albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="MsClothing" value="M's Clothing" style="background-color:rgb(153,217,234);">
</form>
<?php
if(isset($_POST['MsClothing'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50070'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s M's Clothing albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="MsAccessories" value="M's Accessories" style="background-color:rgb(153,217,234);">
</form>
<?php
if(isset($_POST['MsAccessories'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50080'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s M's Accessories albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="MsUnderwear" value="M's Underwear" style="background-color:rgb(153,217,234);">
</form>
<?php
if(isset($_POST['MsUnderwear'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50090'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s M's Underwear albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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
<form method="POST" action="">
	<input type="submit" name="MsShoes" value="M's Shoes" style="background-color:rgb(153,217,234);">
</form>
<?php
if(isset($_POST['MsShoes'])){
	
	$get_albums=mysqli_query($con,"SELECT * FROM catclothes WHERE master='50100'");
	$numrows=mysqli_num_rows($get_albums);
	echo "</br><h2 style='text-align:center;'>".$username."'s M's Shoes albums</h2>";
	
	while($row=mysqli_fetch_assoc($get_albums)){
		$id=$row['id'];
		$album_title=$row['name'];

		if($username==$ae){
		$aei='view_photo_clothe.php?uid=' .$id. '';
		}
		else{
		$aei='rate_clothe.php?clothecatid=90&clothesubid=' .$id. '&username2='.$username.'&favs=0&brand=&shop=&tags=&country=&daysago=0&gender=0';
		}
		$get_user_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND uid='$id' AND removed='no' ORDER BY id DESC");
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