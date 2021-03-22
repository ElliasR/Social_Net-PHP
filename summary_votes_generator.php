<?php
include ("./inc/header.inc.php"); 
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
$ae=$_SESSION["user_login"];
?>
<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadpicbody" value="UPLOAD Body"/> <br/>
<br/>
</form>
<br/>
<?php
if(isset($_POST['uploadpicbody'])){
	$get_photos=mysqli_query($con,"SELECT * FROM photos WHERE removed='no'");
	$numrows=mysqli_num_rows($get_photos);

	while($row=mysqli_fetch_assoc($get_photos)){
		$id=$row['id'];
		$location=$row['location'];
		$reg=$row['reg'];
		$coun=$row['coun'];
		$userowner=$row['username'];	

		$sum_query=mysqli_query($con,"SELECT score FROM rate_body WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		if($count_array==0){
			$avg=0;
		}
		else{
		$avg=(round($sum_array/$count_array,2));
		}

	
	
		echo $id."-username-".$userowner."-location-".$location."-reg-".$reg."-coun-".$coun."-sum-".$sum_array."-counvotes-".$count_array."-avg-> ".$avg."</br>";
		$sum_array=0;;
	
		$sum_body_table_query=mysqli_query($con,"SELECT img_id FROM sum_body_table WHERE img_id=$id");
		$count_summtable=mysqli_num_rows($sum_body_table_query);
		if($count_summtable==0){
			mysqli_query($con,"INSERT INTO sum_body_table VALUES ('$id','$userowner','$location','$reg','$coun','$count_array','$avg')");
		}
		else{
			mysqli_query($con,"UPDATE sum_body_table SET votes='$count_array', avg='$avg' WHERE img_id='$id'");
		}
	
	}
}
?>
<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadpiccar" value="UPLOAD Car"/> <br/>
<br/>
</form>
<br/>
<?php
if(isset($_POST['uploadpiccar'])){
	$get_photos=mysqli_query($con,"SELECT * FROM photos_car WHERE removed='no'");
	$numrows=mysqli_num_rows($get_photos);

	while($row=mysqli_fetch_assoc($get_photos)){
		$id=$row['id'];
		$location=$row['location'];
		$reg=$row['reg'];
		$coun=$row['coun'];
		$userowner=$row['username'];	

		$sum_query=mysqli_query($con,"SELECT score FROM rate_car WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		if($count_array==0){
			$avg=0;
		}
		else{
		$avg=(round($sum_array/$count_array,2));
		}

	
	
		echo $id."-username-".$userowner."-location-".$location."-reg-".$reg."-coun-".$coun."-sum-".$sum_array."-counvotes-".$count_array."-avg-> ".$avg."</br>";
		$sum_array=0;;
	
		$sum_body_table_query=mysqli_query($con,"SELECT img_id FROM sum_car_table WHERE img_id=$id");
		$count_summtable=mysqli_num_rows($sum_body_table_query);
		if($count_summtable==0){
			mysqli_query($con,"INSERT INTO sum_car_table VALUES ('$id','$userowner','$location','$reg','$coun','$count_array','$avg')");
		}
		else{
			mysqli_query($con,"UPDATE sum_car_table SET votes='$count_array', avg='$avg' WHERE img_id='$id'");
		}
	
	}
}
?>
<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadpicclothe" value="UPLOAD Clothe"/> <br/>
<br/>
</form>
<br/>
<?php
if(isset($_POST['uploadpicclothe'])){
	$get_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE removed='no'");
	$numrows=mysqli_num_rows($get_photos);

	while($row=mysqli_fetch_assoc($get_photos)){
		$id=$row['id'];
		$location=$row['location'];
		$reg=$row['region'];
		$coun=$row['country'];
		$userowner=$row['username'];	

		$sum_query=mysqli_query($con,"SELECT score FROM rate_clothe WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		if($count_array==0){
			$avg=0;
		}
		else{
		$avg=(round($sum_array/$count_array,2));
		}

	
	
		echo $id."-username-".$userowner."-location-".$location."-reg-".$reg."-coun-".$coun."-sum-".$sum_array."-counvotes-".$count_array."-avg-> ".$avg."</br>";
		$sum_array=0;;
	
		$sum_body_table_query=mysqli_query($con,"SELECT img_id FROM sum_clothe_table WHERE img_id=$id");
		$count_summtable=mysqli_num_rows($sum_body_table_query);
		if($count_summtable==0){
			mysqli_query($con,"INSERT INTO sum_clothe_table VALUES ('$id','$userowner','$location','$reg','$coun','$count_array','$avg')");
		}
		else{
			mysqli_query($con,"UPDATE sum_clothe_table SET votes='$count_array', avg='$avg' WHERE img_id='$id'");
		}
	
	}
}
?>
<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadpicsoli" value="UPLOAD Soli"/> <br/>
<br/>
</form>
<br/>
<?php
if(isset($_POST['uploadpicsoli'])){
	$get_photos=mysqli_query($con,"SELECT * FROM photos_soli WHERE removed='no'");
	$numrows=mysqli_num_rows($get_photos);

	while($row=mysqli_fetch_assoc($get_photos)){
		$id=$row['id'];
		$location=$row['location'];
		$reg=$row['region'];
		$coun=$row['country'];
		$userowner=$row['username'];	

		$sum_query=mysqli_query($con,"SELECT score FROM rate_soli WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		if($count_array==0){
			$avg=0;
		}
		else{
		$avg=(round($sum_array/$count_array,2));
		}

	
	
		echo $id."-username-".$userowner."-location-".$location."-reg-".$reg."-coun-".$coun."-sum-".$sum_array."-counvotes-".$count_array."-avg-> ".$avg."</br>";
		$sum_array=0;;
	
		$sum_body_table_query=mysqli_query($con,"SELECT img_id FROM sum_soli_table WHERE img_id=$id");
		$count_summtable=mysqli_num_rows($sum_body_table_query);
		if($count_summtable==0){
			mysqli_query($con,"INSERT INTO sum_soli_table VALUES ('$id','$userowner','$location','$reg','$coun','$count_array','$avg')");
		}
		else{
			mysqli_query($con,"UPDATE sum_soli_table SET votes='$count_array', avg='$avg' WHERE img_id='$id'");
		}
	
	}
}
?>