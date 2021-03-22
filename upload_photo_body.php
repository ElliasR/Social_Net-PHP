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
		/*xxx*/$filtrado = test_input($_POST['bodysubid']);
	$uid = mysqli_real_escape_string($con,$filtrado);
			/*xxx*/$filtrado = test_input($_POST['aa']);
	$catid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['title']);
	$title = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['tags']);
	$tags = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['model']);
	$modelname = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['gender']);
	$modelgender = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['modelage']);
	$modelage = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['description']);
	$description = mysqli_real_escape_string($con,$filtrado);
	$date_posted=date("ymdhis");

	if($uid=="0"){
		echo"</br></br> * Please, select a category";
	}
	else{
		if($modelgender=="0"){
			echo"</br></br> * Please, select a gender";
		}
		else{
			if($modelage=="0"){
				echo"</br></br> * Please, select an age";
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
							mkdir("userdata/user_photos/photosbody/$rand_dir_name");
							
							if(file_exists ("userdata/user_photos/photosbody/$rand_dir_name/".@$_FILES["uploadphoto"]["name"]))
							{
							echo @$_FILES["uploadphoto"]["name"]." already exists";
							}
							else
							{
							move_uploaded_file (@$_FILES["uploadphoto"]["tmp_name"],"userdata/user_photos/photosbody/$rand_dir_name/".$_FILES["uploadphoto"]["name"]);
							//echo "Uploaded and stored in: userdata/user_photos/$rand_dir_name".$_FILES["uploadphoto"]["name"])";
							$profile_pic_name=@$_FILES["uploadphoto"]["name"];
							$profile_pic_query=mysqli_query($con,"INSERT INTO photos VALUES ('','$catid','$uid','$username','$date_posted','$description','http://$dominio.com/userdata/user_photos/photosbody/$rand_dir_name/$profile_pic_name','$title','$tags','$modelname','$modelgender','$modelage','$location','$region','$country','no')");//
							
							
							$folder="userdata/user_photos/photosbody/$rand_dir_name/";
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
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> UPLOAD YOUR PHOTOS - <i class="fa fa-child fa-lg" aria-hidden="true"> Body</i></center></h2></b></br>
<hr/>
<form action="" method="POST" enctype="multipart/form-data"><center>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/JavaScript">
		function State(){ //https://www.youtube.com/watch?v=BWUka71MocU
			$('#stateddl').empty();
			$('#stateddl').append("<option>Loading......</option>");
			$('#districtddl').append("<option value='0'>Select CAT first*</option>");
			$.ajax({
				type:"POST",
				url:"http://rankpion.com/dropdown_body.php",	//call the php file that returns the state name after fetch from the database
				contentType:"application/json; charset=utf-8",
				dataType:"json", 	// Data type has to be json as the received data is on this format
				success: function(data){ 	// a success event fill states by using each loop
					$('#stateddl').empty();
					$('#stateddl').append("<option value=''>BODY CATEGORY*</option>");
					$.each(data,function(i,item){
						$('#stateddl').append('<option value="'+ data[i].id +'">'+ data[i].name+'</option>');
					});
				},
				complete: function(){
				}
			});
			} 

			function District(sid){
				$('#districtddl').empty();
				$('#districtddl').append("<option>Loading......</option>");
				$.ajax({
					type:"POST",
					url:"http://rankpion.com/dropdown_body2nd.php?sid="+sid,//past the state value to the php file that returns the district names after fetch from the database
					contentType:"application/json; charset=utf-8",
					dataType:"json", // Data type has to be json as the received data is on this format
					success: function(data){ //Success event fills the district names by using each loop
						$('#districtddl').empty();
						$('#districtddl').append("<option value=''></option>");
						$.each(data,function(i,item){
							$('#districtddl').append('<option value="'+ data[i].id +'">'+ data[i].name+'</option>');
						});
					},
					complete: function(){
					}
				});
			} 

			$(document).ready(function(){
				State();	//Call state fuction on the page load
				$("#stateddl").change(function(){ //On change function of the state dropdown pass the selected value of the state to the district function
					var stateid = $("#stateddl").val();
					District(stateid);
			});
		});
	</script>



	<br/><br/><input type="file" name="uploadphoto" required="required"/><br/><br/>
	<span></span><select id="stateddl" name="aa" required="required"> </select><span></span>   &rarr;   <select id="districtddl" name="bodysubid" required="required"></select><br/><br/>
	<input style="border:2px solid green;" type="text" name="title" size="25" placeholder="Photo Title...*" required="required"/><br /><br />
	<select name="gender" required="required">
		<option value="">MODEL GENDER*</option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		</select>
	<select name="modelage" required="required">
		<option value="">MODEL AGE*</option>
		<option value="2.5"> 0 - 5 </option>
		<option value="8"> 6 - 10 </option>
		<option value="13">11 - 15</option>
		<option value="18">16 - 20</option>
		<option value="23">21 - 25</option>
		<option value="28">26 - 30</option>
		<option value="35.5">31 - 40</option>
		<option value="45.5">41 - 50</option>
		<option value="55.5">51 - 60</option>
		<option value="+60">+ 60</option>
		</select><br/><br/>
	<input type="text" name="tags" style="border:2px solid green;" size="25" placeholder="Tag..."/><br /><br />
	<input type="text" name="model" style="border:2px solid green;" size="25" placeholder="Name of the model..."/><br /><br />
	<input type="text" name="location" style="border:2px solid green;" size="25" placeholder="Photo location..."/><br /><br />
	<input type="text" name="description" style="border:2px solid green;" size="25" placeholder="Description / About the photo ..."/><br /><br />
	<br/><input type="submit" class="body" name="uploadpic" value="UPLOAD IMAGE"/> <br/>
	</center>
</form> 

<br/><br/><hr/><br/>