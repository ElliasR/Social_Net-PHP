<?php
include("inc/header.inc.php");
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
	//Includes user location data to pic database
	$cit=mysqli_query($con,"SELECT * FROM users WHERE username='$username'");
	$city = mysqli_fetch_assoc($cit);
	$location=$city['country'];
	$regi=mysqli_query($con,"SELECT * FROM categories WHERE id='".$location."'");
	$regio = mysqli_fetch_assoc($regi);
	$region=$regio['master'];
	$cou=mysqli_query($con,"SELECT * FROM categories WHERE id='".$region."'");
	$coun = mysqli_fetch_assoc($cou);
	$country=$coun['master'];

if(isset($_POST['uploadpic'])){
	
		/*xxx*/$filtrado = test_input($_POST['solicat']);
	$uid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['title']);
	$title = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['tags']);
	$tags = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['owner']);
	$owner = mysqli_real_escape_string($con,$filtrado);
	$date_posted=date("ymdhis");
		/*xxx*/$filtrado = test_input($_POST['description']);
	$description = mysqli_real_escape_string($con,$filtrado);
			/*xxx*/$filtrado = test_input($_POST['locatio']);
	$locatio = mysqli_real_escape_string($con,$filtrado);

	if($uid=="0"){
		echo"</br></br> * Please, select a category";
	}
	else{


						if (isset($_FILES['uploadphoto'])) {
							if((@$_FILES["uploadphoto"]["size"] > 4000000)){
									echo "</br></br>Image size is bigger than 4Mb.";
								}
							else{
								if (((@$_FILES["uploadphoto"]["type"]=="image/jpeg") || (@$_FILES["uploadphoto"]["type"]=="image/png")|| (@$_FILES["uploadphoto"]["type"]=="image/gif")) && (@$_FILES["uploadphoto"]["size"] < 4048576))
							{
							$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$rand_dir_name = $date_posted.(substr(str_shuffle($chars), 0, 8));
							mkdir("userdata/user_photos/photossoli/$rand_dir_name");
							
							if(file_exists ("userdata/user_photos/photossoli/$rand_dir_name/".@$_FILES["uploadphoto"]["name"]))
							{
							echo @$_FILES["uploadphoto"]["name"]." already exists";
							}
							else
							{
							move_uploaded_file (@$_FILES["uploadphoto"]["tmp_name"],"userdata/user_photos/photossoli/$rand_dir_name/".$_FILES["uploadphoto"]["name"]);
							//echo "Uploaded and stored in: userdata/user_photos/$rand_dir_name".$_FILES["uploadphoto"]["name"])";
							$profile_pic_name=@$_FILES["uploadphoto"]["name"];
							$profile_pic_query=mysqli_query($con,"INSERT INTO photos_soli VALUES ('','$uid','$username','$date_posted','$description','http://$dominio.com/userdata/user_photos/photossoli/$rand_dir_name/$profile_pic_name','$title','$tags','$owner','$locatio','$location','$region','$country','no')");//
							
							
							$folder="userdata/user_photos/photossoli/$rand_dir_name/";
							$uploadimage=$folder.@$_FILES["uploadphoto"]["name"];;
							$newname=@$_FILES["uploadphoto"]["name"];
							// Set the resize_image name
$resize_image = $folder.$newname; 
$actual_image = $folder.$newname;
// It gets the size of the image
list( $width,$height ) = getimagesize( $uploadimage );

$ratico=$height/$width;

if($ratico>=0.75){
	if($height>=600){
		$height2=600;
		$width2=600/$ratico;
	}
	else{
		$height2=$height;
		$width2=$width;
	}
}
else{
	if($width>=800){
		$width2=800;
		$height2=800*$ratico;
	}
	else{
		$height2=$height;
		$width2=$width;
	}
}	
$newwidth = $width2;
$newheight = $height2;
// It loads the images we use jpeg function you can use any function like imagecreatefromjpeg
$thumb = imagecreatetruecolor( $newwidth, $newheight );
	if(exif_imagetype($uploadimage)==IMAGETYPE_JPEG){		
		$source=imagecreatefromjpeg( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg( $thumb, $resize_image, 100 );
	}
	if(exif_imagetype($uploadimage)==IMAGETYPE_GIF){		
		$source=imagecreatefromgif( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagegif( $thumb, $resize_image, 100 );
	}
	if(exif_imagetype($uploadimage)==IMAGETYPE_PNG){		
		$source=imagecreatefrompng( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng( $thumb, $resize_image, 3 );
	}	
$out_image=addslashes(file_get_contents($resize_image));
							
							
							
							echo"</br></br></br> * Photo successfully uploaded! </br></br>";
							//	header ("Location:upload_photo.php");
	}
}}}}}
?>
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> UPLOAD YOUR PHOTOS - <i class="fa fa-heart fa-lg" aria-hidden="true"> Solidarity</i></center></h2></b></br>
<hr/>
<form action="" method="POST" enctype="multipart/form-data"><center>
	<br/><br/><input type="file" name="uploadphoto" /><br/><br/>
	<input style="border:2px solid purple;" type="text" name="title" size="25" placeholder="Photo Title...*" required="required"/><br /><br />
	<select name="solicat" required="required">
		<option value="0"> SOLIDARITY CATEGORY* </option>
		<option value="02"> Charities </option>		
		<option value="04"> Donations </option>		
		<option value="06"> Events </option>		
		<option value="08"> Fundations </option>
		<option value="10"> Honorable Actions </option>
		<option value="12"> Picture </option>
		<option value="14"> Research </option>
		<option value="16"> Sponsors </option>
		<option value="18"> Other... </option>
	</select><br/><br/>
	<input type="text" name="tags" style="border:2px solid purple;" size="25" placeholder="Tag..."/><br /><br />
	<input type="text" name="owner" style="border:2px solid purple;" size="25" placeholder="Owner / Responsible..."/><br /><br />
	<input type="text" name="locatio" style="border:2px solid purple;" size="25" placeholder="Location..."/><br /><br />
	<input type="text" name="description" style="border:2px solid purple;" size="25" placeholder="Description / About the photo ..."/><br /><br />
	<br/><input type="submit" class="soli" name="uploadpic" value="UPLOAD IMAGE"/> <br/>
	</center>
</form> 
<br/><br/><hr/><br/>