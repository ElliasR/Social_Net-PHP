<?php
		$color="purple";
include("inc/noheader.inc.php");
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}

if (isset($_GET['indiv'])){ //Ver fotos desde  albunes individuales de usuarios
	/*xxx*/$filtrado = test_input($_GET['indiv']);
	$findividual = mysqli_real_escape_string($con,$filtrado);
	$individual= round (2184/($findividual-431160));
}
else{
	$page = 1;
	if (isset($_GET['page'])) {
		/*xxx*/$filtrado = test_input($_GET['page']);
		$page = mysqli_real_escape_string($con,$filtrado);
	}
		/*xxx*/$filtrado = test_input($_GET['solicat']);
	$solicat = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['username2']);
	$username2 = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['favs']);
	$favs = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['tags']);
	$tags = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['country']);
	$country = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['category']);
	$category = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['colour']);
	$colour = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['daysago']);
	$daysago = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['scored']);
	$scored = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['random']);
	$random = mysqli_real_escape_string($con,$filtrado);


	//*******************FILTERS**********************
	// filters info or help: 1(Compulsory) SELECT A CATEGORY . 2 (Optional) Type an username or select a fav: you'll see their photos within the selected BODY CATEGORY. 3 (Optional, works if no username nor fav selected) See the different photos within the selected BODY CATEGORY in the selected TOWN or REGION or COUNTRY.
	//   NAME AND FAVS FILTER
	if ($username2==""){
		if ($favs=="0"){
			$usernamefilter= "";
			//   LOCATION FILTER: this filter only works when no username2 and fav don't exist. 
			if ($country==""){
				$cit=mysqli_query($con,"SELECT * FROM users WHERE username='$username'");
				$city = mysqli_fetch_assoc($cit);
				$userlocation=$city['country'];	
				$locationfilter=" && location='" .$userlocation. "' ";
			}
			else{
				if($category==""){
					$locationfilter=" && coun='" .$country. "' ";
				}
				else{
					if($colour==""){
						$locationfilter=" && reg='" .$category. "' ";
					}
					else{
						$locationfilter=" && location='" .$colour. "' ";
					}
				}
			}
		}
		else{
			$usernamefilter= " && username='" .$favs. "' ";
			$locationfilter="";
		}
	}
	else{
		$usernamefilter= " && username='" .$username2. "' ";
		$locationfilter="";
	}
	//   ADDED ANYTIME FILTER
	if($daysago=="0"){
		$daysagofilter="";
	}
	else{
		$date= date('Y-m-d H:i:s');
		$daysag="-$daysago hour";
		$date_24=date('Y-m-d H:i:s', strtotime($daysag));
		$daysagofilter= " && date_posted>'$date_24'";
	}
	//   TAG FILTER
	if($tags==""){
		$tagfilter="";
	}
	else{
		$tagfilter= " && tags='" .$tags. "' ";
	}
}

//BODY ID OBLIGATORIO
if (($solicat==0)&&($individual=="")){
	echo "</br></br></br> You have to select at least a SOLIDARITY CATEGORY!</br></br></br>Please, <a href='photodisplay_soli.php'><b> TRY AGAIN</b></a>.</br>";//errormsg
}
else{
		if ($country=="4ny"){ //Filter for any region if no photos matching that criteria.
		$locationfilter="";
	}	
	if($individual!=""){
		$row_count="1";
		$sql = "SELECT * FROM photos_soli WHERE id=".$individual." && removed='no' ";
		$get_photos=mysqli_query($con,$sql);
	}
	else{
		// set the number of items to display per page
		$items_per_page = 1;
		// build query
		$offset = ($page - 1) * $items_per_page;
		$sql = "SELECT * FROM photos_soli WHERE uid='" .$solicat. "'$usernamefilter$locationfilter$tagfilter$daysagofilter && removed='no' ORDER BY id DESC LIMIT " . $offset . "," . $items_per_page . " ";
		$get_photos=mysqli_query($con,$sql);
		$get_all_photos=mysqli_query($con,"SELECT * FROM photos_soli WHERE uid='" .$solicat. "'$usernamefilter$locationfilter$tagfilter$daysagofilter && removed='no' ");
		$row_count=mysqli_num_rows($get_all_photos);
	}
	if($row_count==0){
		echo "</br></br><center>There are no photos matching that criteria. </br>Please, <a href='photodisplay_soli.php'> try again.</a>";//errormsg
		echo '</br><a href="rate_soli.php?solicat=' .$solicat. '&username2=&favs=0&tags=&country=4ny&daysago=0&gender=0"><input type="submit" value="Any region"/></a></center>
		'; 
	}
	else{
		while($row=mysqli_fetch_array($get_photos)){
			$id=$row['id'];
			$uid=$row['uid'];
			$owner = $row['username'];
			$description = $row['description'];
			$image_url = $row['image_url'];
			$title=$row['title'];
			$tag=$row['tags'];
			$association=$row['owner'];
			$locatio=$row['locatio'];
	
				if($uid =="02"){$catego="Charities";}
				if($uid =="04"){$catego="Donations";}
				if($uid =="06"){$catego="Events";}
				if($uid =="08"){$catego="Fundations";}
				if($uid =="10"){$catego="Honorable Actions";}
				if($uid =="12"){$catego="Picture";}
				if($uid =="14"){$catego="Research";}
				if($uid =="16"){$catego="Sponsors";}
				if($uid =="18"){$catego="Other";}
			
			echo"
			<div class='photoframe2' style='border:2px solid purple;'>
				</br><img src='$image_url' style='max-height:560px; max-width:98%; margin-top:10px;'><br />
				<form class='frame2' action='' method='POST'>	
					<center class='frame2' style='background-color:purple;'>
					<select name='scores' style='height:38px; width:115px; margin:15px;'><option value='0'>VALUES</option>
						<option value='5'>5 &#9734;&#9734;&#9734;&#9734;&#9734;</option>
						<option value='4'>4 &#9734;&#9734;&#9734;&#9734;</option>
						<option value='3'>3 &#9734;&#9734;&#9734;</option>
						<option value='2'>2 &#9734;&#9734;</option>
						<option value='1'>1 &#9734;</option>
					</select>
					<input type='submit' name='score' value='RATE' style='height:38px; width:80px; margin:15px;'/>
					</center>
				</form>
		
		
			";
		}
?>
	<script language="javascript">
	function toggle<? echo $id;?>(){
		var ele = document.getElementById("toggleComment<?php echo $id;?>");
		var text = document.getElementById("displayComment<?php echo $id;?>");
		if(ele.style.display =="block"){
			ele.style.display="none";
		}
		else{
			ele.style.display="block";
		}
	}
</script>
<?php

		$page_count = 0;
		if (0 === $row_count) {  
			// maybe show some error since there is nothing in your table
		} 
		else {
		   // determine page_count
		   @$page_count = (int)ceil($row_count / $items_per_page);
		   // double check that request page is in range
		   if($page > $page_count) {
				// error to user, maybe set page to 1
				$page = 1;
		   }
		}
	}

$i=$page+1;
if ($i > $row_count){
	$i=1;
}
$j=$page-1;
if ($page == 1 ){
	$j=$row_count;
}


	$marca=	"<tr>
				<td class='solitable'>Category</td>
				<td class='solitable'>$catego</td>
			</tr>";
	$phowner="<tr>
					<td class='solitable'>Photo Owner</td>
					<td class='solitable'>$owner</td>
				</tr>";
	if($description !=""){
		$spec="<tr>
					<td class='solitable'>Description</td>
					<td class='solitable'>$description</td>
				</tr>";
	}		
	if($title !=""){
		$titlee="<tr>
					<td class='solitable'>Title</td>
					<td class='solitable'>$title</td>
				</tr>";
	}	
	if($tag !=""){
		$tagg="<tr>
					<td class='solitable'>Tag</td>
					<td class='solitable'>$tag</td>
				</tr>";
	}
	if($association !=""){
		$asso="<tr>
					<td class='solitable'>Responsible</td>
					<td class='solitable'>$association</td>
				</tr>";
	}
	if($locatio !=""){
		$locati="<tr>
					<td class='solitable'>Location</td>
					<td class='solitable'>$locatio</td>
				</tr>";
	}



$alreadyrated=mysqli_query($con,"SELECT * FROM rate_soli WHERE img_id='$id' and scorer='$username'");
$count_alreadyrated=mysqli_num_rows($alreadyrated);
	if($count_alreadyrated>=1){			//***************SI YA SE HA VOTADO, MUESTRA TODO Y DICE QUE YA SE HA VOTADO. *********************
		$sum_query=mysqli_query($con,"SELECT score FROM rate_soli WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];}
		$avg=round($sum_array/$count_array,1);
		echo "<br><br>Photo already rated<br><br><hr><br>";
		echo "</br></br><center><table>
					<tr>
						<td class='solitable'>NO VOTES</td>
						<td class='solitable'>$count_array</td>
					</tr>
					<tr>
						<td class='solitable'>AVERAGE</td>
						<td class='solitable'>$avg<span class='starsoli'>&#9733;</span></td>
					</tr>
			</table></center>
			</br><center><table>".$marca.$phowner.$titlee.$asso.$spec.$locati.$tagg.
			"</table></center></br>";

		if($individual!=""){
			echo '<a style="float:right;" href="photodisplay_soli.php">Search more&rarr;</a>
				   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
		}
		else{
			echo '<a style="float:right;" href="rate_soli.php?solicat=' .$solicat. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_soli.png"></a> 
				   <a style="float:left;" href="rate_soli.php?solicat=' .$solicat. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_soli.png"></a><br><br><br>';
		}
		
		//Get comments:-------------COMMENTS MENU-------------------------
		$get_comments = mysqli_query($con,"SELECT * FROM post_comments_soli WHERE post_id='$id' ORDER BY id DESC");
		$comment=mysqli_fetch_assoc($get_comments);
			$comment_body=$comment['post_body'];
			$posted_to=$comment['posted_to'];
			$posted_by=$comment['posted_by'];
			$removed=$comment['removed'];
		
		
		echo "
			<div class='newsFeedPostsoli'></br>
				<div class='newsfeedoptions'>
					<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
				</div>
				<div id='toggleComment$id' style='display:none'>
					<iframe src='./comment_frame_soli.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:100px;'></iframe>
				</div>
					<p />
			</div><br />
					<p />
		";
	}
	else{				//*******************SI AUN NO SE HA VOTADO, SE MUESTRA RECOGE EL VOTO Y, UNA VEZ HECHO, SE MUESTRA TODO. **********************************

if(isset($_POST['score'])){
	$scores = $_POST['scores'];
	$date_scored=date("ymdhis");
	$introduce_score=mysqli_query($con,"INSERT INTO rate_soli VALUES ('','$scores','$username','$id','$owner','$date_scored')");
	$i=$page+1;
	if ($i > $row_count){
		$i=1;
	}
	$j=$page-1;
	if ($page == 1 ){
		$j=$row_count;
	}

	$sum_query=mysqli_query($con,"SELECT score FROM rate_soli WHERE img_id=$id");
	$count_array=mysqli_num_rows($sum_query);
	while ($array=mysqli_fetch_array($sum_query)){
	$sum_array +=$array['score'];}
	$avg=round($sum_array/$count_array,1);
			echo "<br><br>Photo already rated<br><br><hr><br>";
			echo "</br></br><center><table>
						<tr>
							<td class='solitable'>NO VOTES</td>
							<td class='solitable'>$count_array</td>
						</tr>
						<tr>
							<td class='solitable'>AVERAGE</td>
							<td class='solitable'>$avg<span class='starsoli'>&#9733;</span></td>
						</tr>
				</table></center>
				</br><center><table>".$marca.$phowner.$titlee.$asso.$spec.$locati.$tagg.
				"</table></center></br>";
	echo '<a style="float:right;" href="rate_soli.php?solicat=' .$solicat. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_soli.png"></a>
		  <a style="float:left;" href="rate_soli.php?&solicat=' .$solicat. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_soli.png"></a><br><br><br>';
			
			//Get comments:-------------COMMENTS MENU-------------------------
			$get_comments = mysqli_query($con,"SELECT * FROM post_comments_soli WHERE post_id='$id' ORDER BY id DESC");
			$comment=mysqli_fetch_assoc($get_comments);
				$comment_body=$comment['post_body'];
				$posted_to=$comment['posted_to'];
				$posted_by=$comment['posted_by'];
				$removed=$comment['removed'];
			
			
			echo "
			<div class='newsFeedPostsoli'></br>
				<div class='newsfeedoptions'>
					<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
				</div>
				<div id='toggleComment$id' style='display:none'>
					<iframe src='./comment_frame_soli.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:100px;'></iframe>
				</div>
					<p />
			</div><br />
					<p />
			";

	}
	}
}

?>
</div>
</td>