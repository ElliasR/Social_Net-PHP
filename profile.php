<?php include("./inc/header.inc.php"); 
if (!isset($_SESSION["user_login"])) { //changed, in is user instead username 15min1
	header("Location: index.php");
	}
?>
<?php			
if (isset($_GET['u'])) {		
		/*xxx*/$filtrado = test_input($_GET['u']);
	$username = mysqli_real_escape_string($con,$filtrado);
}

$puntuation=mysqli_query($con,"SELECT * FROM ranking WHERE username='$username'");
	$puntaco=mysqli_fetch_assoc($puntuation);
	$area=$puntaco['country'];
	$body_total=$puntaco['body_total'];
	$clothe_total=$puntaco['clothe_total'];
	$car_total=$puntaco['car_total'];
	$soli_total=$puntaco['soli_total'];
	$total_total=$puntaco['total_total'];
$samecity=mysqli_query($con,"SELECT * FROM ranking WHERE country='$area'");
	$count_no_city=mysqli_num_rows($samecity);
	$body_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE body_total>'$body_total' AND country='$area'");
	$body_total_rank=mysqli_num_rows($body_total_poss)+1;
	$clothe_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE clothe_total>'$clothe_total' AND country='$area'");
	$clothe_total_rank=mysqli_num_rows($clothe_total_poss)+1;
	$car_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE car_total>'$car_total' AND country='$area'");
	$car_total_rank=mysqli_num_rows($car_total_poss)+1;
	$soli_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE soli_total>'$soli_total' AND country='$area'");
	$soli_total_rank=mysqli_num_rows($soli_total_poss)+1;
	$total_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE total_total>'$total_total' AND country='$area'");
	$total_total_rank=mysqli_num_rows($total_total_poss)+1;


$post = @$_POST['post'];
if ($post != ""){
		/*xxx*/$filtrado = test_input($_POST['post']);
	$post = mysqli_real_escape_string($con,$filtrado);
	$date_added = date("Y-m-d");
	$added_by = $_SESSION["user_login"];//+++++++++++++++++++++++++++++++NECESITA SEGURIDAD?????+++++++++++++++++++++++++++++++++++++++++++
	$user_posted_to = $username;
	$sqlCommand = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$added_by', '$user_posted_to')";
	$query = mysqli_query($con,$sqlCommand) or die (mysqli_error($con));
}
//PROFILE PIC
	$check_pick = mysqli_query ($con , "SELECT profile_pic FROM users WHERE username='$username'");
	$get_pick_row = mysqli_fetch_assoc ($check_pick);
	$profile_pic_db = $get_pick_row ['profile_pic'];
	if($profile_pic_db=="") {
		$profile_pic ="img/imgpic.jpg";
	}
	else{
		$profile_pic="userdata/profile_pics/".$profile_pic_db;
	}
?><br/>
<b><h2><center><i class="fa fa-user fa-lg" aria-hidden="true"></i>  <?php echo$username?>'s PROFILE</center></h2></b></br>
<hr /><br/><br/>
	<center>	<!--RANKING-->	
		<div class="goldbackground" id="myBtn">
			<span style="color:green;"><?php echo $body_total_rank;?> / </span>
			<span style="color:red;"><?php echo $car_total_rank;?> / </span>
			<span style="color:blue;"><?php echo $clothe_total_rank;?> / </span> 
			<span style="color:purple;"><?php echo $soli_total_rank;?> / </span> 
			<span style="font-size:200%;"><?php echo $total_total_rank;?>/</span>
			<span style="font-size:200%;"><?php echo $count_no_city;?></span>
	<br/><br/>	<!--PIC-->
			<img src="<?php echo $profile_pic;?>" style="max-width:200px; max-height:250px;" alt="<?php echo $username; ?>'s Profile" title="<? echo $username; ?>'s Profile" />
	</br></br>
				<!--BIO-->
<?php
	$about_query=mysqli_query($con,"SELECT bio FROM users WHERE username='$username'");
	$get_result = mysqli_fetch_assoc($about_query);
	$about_the_user=$get_result['bio'];
			echo $about_the_user;
?>
		</div>
		
									<!-- The Modal -->
						<div id="myModal" class="modal">

								<!-- Modal content -->
							<div class="modal-content">
								<div class="goldbackground">
									<img src="./img/favicon.png" align="left" style="max-width:25px;max-height:25px;margin:-3px;">
									<b>HELP</b>
									<b class="close"><i class="fa fa-times fa-lg" aria-hidden="true"></i></b>
								</div>
								<div class="modal-body"><br/>							
									<p>- Your Ranking in BODY TOTAL: position <?php echo $body_total_rank;?> over <?php echo $count_no_city;?>  people in total in your area.<br/><br/></p>
									<p>- Your Ranking in CAR TOTAL: position <?php echo $car_total_rank;?> over <?php echo $count_no_city;?> people in total in your area.<br/><br/></p>
									<p>- Your Ranking in CLOTHES TOTAL: position <?php echo $clothe_total_rank;?> over <?php echo $count_no_city;?> people in total in your area.<br/><br/></p>
									<p>- Your Ranking in SOLIDARITY TOTAL: position <?php echo $soli_total_rank;?> over <?php echo $count_no_city;?> people in total in your area.<br/><br/></p>
									<p>- Your Ranking in TOTAL: position <?php echo $total_total_rank;?> over <?php echo $count_no_city;?> people in total in your area.</p>
								</div></br></br>
							</div>

						</div>

						<script>
						// Get the modal
						var modal = document.getElementById('myModal');

						// Get the button that opens the modal
						var btn = document.getElementById("myBtn");

						// Get the <span> element that closes the modal
						var span = document.getElementsByClassName("close")[0];

						// When the user clicks the button, open the modal
						btn.onclick = function() {
							modal.style.display = "block";
						}

						// When the user clicks on <span> (x), close the modal
						span.onclick = function() {
							modal.style.display = "none";
						}

						// When the user clicks anywhere outside of the modal, close it
						window.onclick = function(event) {
							if (event.target == modal) {
								modal.style.display = "none";
							}
						}
						</script>
		
		
		
		
		
		
	</br>	
				<!--ADD FAV-->	
		<form action="<?echo $username; ?>" method="post">	
	<?php
$i=0;
$u = $_SESSION["user_login"];//+++++++++++++++++++++++++++++++SEGURIDAD++++++++++++++++++++++++++
$fav_check=mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$u' && user_to='$username' && removed='n'");
$fav_count=mysqli_num_rows($fav_check);
if ($fav_count>=1){
	$addasfriend='<input type="submit" name="removefriend" value="Remove FAV">';
}
else{
	$addasfriend='<input type="submit" name="addfriend" value="Add as FAV">';
}
echo $addasfriend;
if($_POST['removefriend']){
	$removefriendquery = mysqli_query($con,"UPDATE friend_requests SET removed='y' WHERE user_from='$u' && user_to='$username'");
	echo"FAV removed.";//errormsg
	header("Location:$username");
}
?>
		<?php echo $errorMsg; ?>
		</form>
	</center>	
	<br/>
<!--<hr/>-->
				<!--FAVS-->
<a onclick="document.getElementById('favs').style.display=(document.getElementById('favs').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-user-plus fa-1g"></i> 
<?php echo $username; ?>'s FAVs </h2></a>
	<form id="favs" style="display:none;" action="2-1-Favs.php?u=<?php echo $username;?>" method="post"><br/><center>
<?php
$fav_mini=mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$username' && removed='n'");
$fav_mini_count=mysqli_num_rows($fav_mini);
if ($fav_mini_count !=0){
	$i=0;
	$max=12;
	while (($minifav=mysqli_fetch_assoc($fav_mini) ) and ($i<$max)){	//v21
		$i++;
		$friendusername=$minifav['user_to'];
		$getfriendquery=mysqli_query($con,"SELECT * FROM users WHERE username='$friendusername' LIMIT 1");
		$getfriendrow=mysqli_fetch_assoc($getfriendquery);
		$friendprofilepic=$getfriendrow['profile_pic'];
		if($friendprofilepic == ""){
			echo "<a href='$friendusername'><img src='img/imgpic.jpg' alt=\"$friendusername's Profile\" title=\"$friendusername's Profile\"  style='padding-right:6px;max-height:50px; max-width:40px;'></a>";
		}
		else{
			echo "<a href='$friendusername'><img src='userdata/profile_pics/$friendprofilepic' alt=\"$friendusername's Profile\" title=\"$friendusername's Profile\" style='padding-right:7px;max-height:50px; max-width:40px;'></a>";
		}
	}
}
else{
	echo $username." has no FAVs yet.";
}
?>
		</br><input type="submit" name="closeaccount" id="closeaccount" Value="View All FAVs"></center>
			<br />
	</form>

<!--<hr/>-->
				<!--ALBUMS-->
<a onclick="document.getElementById('alb').style.display=(document.getElementById('alb').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-camera fa-1g"></i> 
<?php echo $username; ?>'s Albums </h2></a>
	<form id="alb" style="display:none;" action="view_albums.php?u=<?php echo $username;?>" method="post">
		</br><center><input type="submit" name="closeaccount" id="closeaccount" Value="View Albums"></center>
		<br />
	</form>

<!--POSTS AREA, SUBMIT AND POSTS-->
<!--<hr/>-->
<a onclick="document.getElementById('posts').style.display=(document.getElementById('posts').style.display=='none')?'block':'none';"><h2 class="hiding"> <i class="fa fa-comments fa-1g"></i>  
COMMENTS</h2></a>
<div id="posts" class="postForm" style="display:none;"><center>
	<form action="<?php echo $username;?>" method="post">
		<br/><br/><textarea id="post" name="post" rows="6 cols"="60"></textarea><br/>
		<input type="submit" name="send" value="Post"/><br />
	</form><br/><hr/><br/></center>

<?php //Displays user's posts in their profile
$getposts = mysqli_query($con,"SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10") or die (mysqli_error(mysqli_connect($con)));
while ($row=mysqli_fetch_assoc($getposts)) {
	$id=$row['id'];
	$body=$row['body'];
//		/*xxx*/$filtrado = test_input($body);
//	$body = mysqli_real_escape_string($con,$filtrado);
	$date_added=$row['date_added'];
	$added_by=$row['added_by'];
	$user_posted_to=$row['user_posted_to'];
	$get_user_info = mysqli_query($con,"SELECT * FROM users WHERE username='$added_by'");
	$get_info=mysqli_fetch_assoc($get_user_info);
	$profilepic_info=$get_info['profile_pic'];
	if ($profilepic_info==""){
		$profilepic_info = "./img/imgpic.jpg";
	}
	else{
		$profilepic_info = "./userdata/profile_pics/".$profilepic_info;
	}
	echo"
		<div style='float: left;'><a href='$added_by'>
		<img src='$profilepic_info' height='40' style='border-width:2px; border-style:inset; margin:5px;'><br/>
		</div>
		<div class='posted_by' style='padding-top:7px;padding-right:7px;'>
		$added_by</a> - $date_added -   </div>
		<div style='max-width: 800px; padding-top:7px;'>
		 $body <br /><br /><br />
		</div>
		<hr /><br />
	";
}

//Add friends and send messages script
$errorMsg="";
$date_fav = date("Y-m-d H:i:s");
	if (isset($_POST['addfriend'])) {
		$friend_request=$_POST['addfriend'];
		
		$user_to = $_SESSION["user_login"];
		$user_from=$username;
		
		if ($user_to == $username){
			$errorMsg = "You can not add yourself as a FAV.</br>";
		}
		else{
			$create_request = mysqli_query($con,"INSERT INTO friend_requests VALUES ('','$user_to','$user_from','$date_fav','n')");
			$errorMsg = "<br/>$user_from is now your FAV";echo"<br/>";
			header("Location:$username");
		}
	}
	else{

	}
?>
</div>
<hr/><br/>
