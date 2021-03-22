<?php
include ("./inc/header.inc.php"); 
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
if (isset($_GET['uid'])) {	//anything stored in after u= is stored in the get u variable.
		/*xxx*/$filtrado = test_input($_GET['uid']);
	$picture = mysqli_real_escape_string($con,$filtrado);
	if (ctype_alnum($picture)) {
?><br/>
<a href='./view_albums.php' >Albums &larr;</a>
<br/>
<h2>Photos in this album</h2>
<?php
$get_photos=mysqli_query($con,"SELECT * FROM photos_soli WHERE uid='$picture' && username='$username' && removed='no' ORDER BY id DESC");
$numrows=mysqli_num_rows($get_photos);
while($row=mysqli_fetch_array($get_photos)){
	$id=$row['id'];
	$uid=$row['uid'];
	$username = $row['username'];
	$title = $row['title'];
	$tag = $row['tags'];
	$owner = $row['owner'];
	$description = $row['description'];
	$image_url = $row['image_url'];
	if(isset($_POST['confirmation_remove_photo_' . $id . ''])){
		$remove_album=mysqli_query($con,"UPDATE photos_soli SET removed='yes' WHERE id='$id'");
		header("Location:view_albums.php");
	}
	if(isset($_POST['confirmation_modify_photo_' . $id . ''])){
		/*xxx*/$filtrado = test_input($_POST['title']);
	$ntitle = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['tag']);
	$ntag = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['owner']);
	$nowner = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['desc']);
	$ndesc = mysqli_real_escape_string($con,$filtrado);
		if ($ntitle==""){
			$ntitle=$title;
		}
		if ($ntag==""){
			$ntag=$tag;
		}
		if ($nowner==""){
			$nowner=$owner;
		}
		if ($ndesc==""){
			$ndesc=$description;
		}
		$update_pic=mysqli_query($con,"UPDATE photos_soli SET title='$ntitle', tags='$ntag', owner='$nowner', description='$ndesc' WHERE id='$id'");
		header("Location:view_albums.php");
	}
	$sortdesc=substr($title,0,20)." ...";
	$indiv=3*728/$id +431160;
	echo"
		<td>
			<center>
				<a onclick=\"document.getElementById('content$id').style.display=(document.getElementById('content$id').style.display=='none')?'block':'none';\"><h2 class='hiding' style='max-width:200px;'>Delete</h2></a>
					<form id='content$id' style='display:none;' method='POST' action=''>
						<input type='submit' name='confirmation_remove_photo_$id' value='Delete'>
						<input type='submit' name='negation_remove_photo_$id' value='Cancel'>
					</form>	
				<div class='albums' name='$row[$i]'>
					<img src='$image_url' style='max-height:85%; max-width:85%; margin-top:2%;'><br />
					$sortdesc
					<a href='rate_soli.php?indiv=$indiv'><i class='fa fa-arrows-alt fa-lg' aria-hidden='true' style='color:white;float:right;'></i></a>
				</div>
				<a onclick=\"document.getElementById('conten$id').style.display=(document.getElementById('conten$id').style.display=='none')?'block':'none';\"><h2 class='hiding' style='max-width:190px;'>Modify data</h2></a></br>
					<form id='conten$id' style='display:none;' method='POST' action=''>
						<input type='text' name='title' id='title' size='40' placeholder='Photo title*: $title '></br>
						<input type='text' name='tag' id='tag' size='40' placeholder='Tag: $tag '></br>
						<input type='text' name='owner' id='owner' size='40' placeholder='Owner/Org.: $owner '></br>
						<input type='text' name='desc' id='desc' size='40' placeholder='Description / about the photo: $description '></br>
						</br><input type='submit' name='confirmation_modify_photo_$id' value='Modify'>
					</form>
			</center>
			</br>
		</td>
		</br>
		";

	}
	}
	else{
		header("Location:view_albums.php");
	}
}
?>