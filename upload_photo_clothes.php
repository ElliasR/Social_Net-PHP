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
			/*xxx*/$filtrado = test_input($_POST['category']);
	$catid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['colour']);
	$uid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['title']);
	$title = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['brand']);
	$brand = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['price']);
	$price = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['shop']);
	$shop = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['description']);
	$description = mysqli_real_escape_string($con,$filtrado);	
	$date_posted=date("ymdhis");
		/*xxx*/$filtrado = test_input($_POST['tags']);
	$tags = mysqli_real_escape_string($con,$filtrado);	

	
	if($uid=="0"){
		echo"</br></br> * Please, select a category";
	}
	else{
		if($brand=="0"){
			echo"</br></br> * Please, type the brand of the garment";
		}
		else{
			if($shop=="0"){
				echo"</br></br> * Please, select the shop where it was bought";
			}
			else{

						if (isset($_FILES['uploadphoto'])) {
							if((@$_FILES["uploadphoto"]["size"] > 4000000)){
									echo "</br></br>Image size is bigger than 4Mb.";
								}
							else{
								if (((@$_FILES["uploadphoto"]["type"]=="image/jpeg") || (@$_FILES["uploadphoto"]["type"]=="image/png")|| (@$_FILES["uploadphoto"]["type"]=="image/gif")) && (@$_FILES["uploadphoto"]["size"] < 3000000))
							{								
							$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$rand_dir_name = $date_posted.(substr(str_shuffle($chars), 0, 8));
							mkdir("userdata/user_photos/photosclothes/$rand_dir_name");
							
							if(file_exists ("userdata/user_photos/photosclothes/$rand_dir_name/".@$_FILES["uploadphoto"]["name"]))
							{
							echo @$_FILES["uploadphoto"]["name"]." already exists";
							}
							else
							{
							move_uploaded_file (@$_FILES["uploadphoto"]["tmp_name"],"userdata/user_photos/photosclothes/$rand_dir_name/".$_FILES["uploadphoto"]["name"]);
							//echo "Uploaded and stored in: userdata/user_photos/photosclothes/$rand_dir_name".$_FILES["uploadphoto"]["name"])";
							$profile_pic_name=@$_FILES["uploadphoto"]["name"];
							$profile_pic_query=mysqli_query($con,"INSERT INTO photos_clo VALUES ('','$catid','$uid','$username','$date_posted','$description','http://$dominio.com/userdata/user_photos/photosclothes/$rand_dir_name/$profile_pic_name','$title','$tags','$brand','$price','$shop','$location','$region','$country','no')");//
							
							
							$folder="userdata/user_photos/photosclothes/$rand_dir_name/";
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
}}}}}}}
?>
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> UPLOAD YOUR PHOTOS - <img src="./img/clo.png" style="background-color:transparent; max-width:20px;max-height:20px;"> Clothes</center></h2></b></br>



<hr/>
<form action="" method="POST" enctype="multipart/form-data"><center>

	<br/><br/><input type="file" name="uploadphoto" required="required"/><br/><br/>
	<?php	try {
	
		$objDb= new PDO('mysql:host=mysql.hostinger.es;dbname=u437483010_bdmac','u437483010_user', 'syseSu');
		$objDb->exec('SET CHARACTER SET utf8');
	
		$sql = "SELECT * 
				FROM `catclothes`
				WHERE `master` = 50000";
		$statement = $objDb->query($sql);
		$list = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			} catch(PDOException $e) {
			echo 'There was a problem';
			}
	?>
	<select name="country" id="country" class="update" required="required"><option value="" >CLOTH CATEGORY</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?><?php } ?></select> &rarr;
		<select name="category" id="category" class="update" disabled="disabled" required="required"><option value="" >----</option></select> &rarr;
		<select name="colour" id="colour" class="update" disabled="disabled" required="required"><option value="">----</option></select></br></br>	
		<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="/js/core2.js" type="text/javascript"></script>		
	
	<input type="text" name="title" size="25" style="border:2px solid blue;" placeholder="Photo Title..." required="required"/><br /><br />
	<input type="text" name="brand" size="25" style="border:2px solid blue;" placeholder="Brand name...*" required="required"/><br /><br />
	<input type="text" name="price" size="25" style="border:2px solid blue;" placeholder="Price paid..."/><br /><br />
	<input type="text" name="shop" size="25" style="border:2px solid blue;" placeholder="Shop name...*" required="required"/><br /><br />
	<input type="text" name="description" size="25" style="border:2px solid blue;" placeholder="Description / About the photo ..."/><br /><br />
	<input type="text" name="tags" size="25" style="border:2px solid blue;" placeholder="Tag..."/><br /><br />
	<br/><input type="submit" class="clo" name="uploadpic" value="UPLOAD IMAGE"/> <br/>
	</center>
</form> 
<br/><br/><hr/><br/>