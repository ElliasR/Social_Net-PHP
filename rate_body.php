<?php   $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//proteccion variables
	$color="green";
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
		/*xxx*/$filtrado = test_input($_GET['bodycatid']);
	$bodycatid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['bodysubid']);
	$bodysubid = mysqli_real_escape_string($con,$filtrado);
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
		/*xxx*/$filtrado = test_input($_GET['gender']);
	$gender = mysqli_real_escape_string($con,$filtrado);
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
	//   GENDER FILTER
	if($gender=="0"){
		$modelgenderfilter="";
	}
	else{
		$modelgenderfilter= " && modelgender='" .$gender. "' ";
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
	//   UID FILTER
	$uidfilter= " uid='" .$bodysubid. "' ";
	$catidfilter= "";
	if (($bodysubid==0)&&($bodycatid!=0)){
		$catidfilter= " catid='" .$bodycatid. "' ";
		$uidfilter= "";
	}
}//else arriba----------------------------------------------------------------------------------------------


//BODY ID OBLIGATORIO
if (($bodycatid==0)&&($individual=="")){
	echo "</br></br></br> You have to select a BODY CATEGORY and SUBCATEGORY!</br></br></br>Please, <a href='photodisplay_body.php'><b> TRY AGAIN</b></a>.</br>";//errormsg
}
else{
	if ($country=="4ny"){ //Filter for any region if no photos matching that criteria.
		$locationfilter="";
	}
	
	
	
	
	
	if($individual!=""){
		$row_count="1";
		$sql = "SELECT * FROM photos WHERE id=".$individual." && removed='no' ";
		$get_photos=mysqli_query($con,$sql);
	}
	else{
		$daysagofilter= " && date_posted>'$date_24'";
		// set the number of items to display per page
		$items_per_page = 1;
		// build query
		$offset = ($page - 1) * $items_per_page;
		$sql = "SELECT * FROM photos WHERE $uidfilter$catidfilter$usernamefilter$locationfilter$modelgenderfilter$tagfilter$daysagofilter && removed='no' ORDER BY id DESC LIMIT " . $offset . "," . $items_per_page . " ";
		$get_photos=mysqli_query($con,$sql);
		$get_all_photos=mysqli_query($con,"SELECT * FROM photos WHERE $uidfilter$catidfilter$usernamefilter$locationfilter$modelgenderfilter$tagfilter$daysagofilter && removed='no' ");
		$row_count=mysqli_num_rows($get_all_photos);
	}
	
	
	
	
	
	
	
	
	if($row_count==0){
		echo "<center></br></br>There are no photos matching that criteria. </br>Please,</br> </br><a href='photodisplay_body.php'><input type='submit' value='Try again'/></a>";
		echo '</br><a href="rate_body.php?bodycatid=' .$bodycatid. '&bodysubid=' .$bodysubid. '&username2=&favs=0&tags=&country=4ny&category=&colour=&daysago=&scored=&gender=0&random="><input type="submit" value="Any region"/></a></center>
		';
	}
	else{
		while($row=mysqli_fetch_array($get_photos)){
			$id=$row['id'];
			$uid=$row['uid'];
			$owner = $row['username'];
			$description = $row['description'];
			$image_url = $row['image_url'];//----------------MAKE SURE HERE THE NAME OF THE PIC IS PROTECTED
			$title=$row['title'];
			$tagsw=$row['tags'];
			$modelnamew=$row['modelname'];
			$modelgenderw=$row['modelgender'];
			$modelagew=$row['modelage'];
			
			
			$get_marca=mysqli_query($con,"SELECT bodysub FROM catbody2nd WHERE bodyid='$uid'");
			$row_mar=mysqli_fetch_assoc($get_marca);
			$marc=$row_mar['bodysub'];


			echo"
			<td>
			<div class='photoframe2' name='$row[$i]'>
				</br><img src='$image_url' name='[$id]' id='[$id]' style='max-height:560px; max-width:98%; margin-top:10px;'><br />
				<form class='frame2' action='' method='POST'>	
					<center class='frame2' style='background-color:green;'>
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
				<td class='bodytable'>Body part</td>
				<td class='bodytable'>$marc</td>
			</tr>";
	$phowner="<tr>
				<td class='bodytable'>Photo Owner</td>
				<td class='bodytable'>$owner </td>
			</tr>";
	if($description !=""){
		$spec="<tr>
				<td class='bodytable'>Description</td>
				<td class='bodytable'>$description </td>
			</tr>";
	}	
	if($title !=""){
		$titlee="<tr>
				<td class='bodytable'>Title</td>
				<td class='bodytable'>$title </td>
			</tr>";
	}
	if($tagsw !=""){
			$tagg="<tr>
						<td class='bodytable'>Tag</td>
						<td class='bodytable'>$tagsw </td>
					</tr>";
	}
	if($modelnamew !=""){
			$moname="<tr>
						<td class='bodytable'>Model name</td>
						<td class='bodytable'>$modelnamew </td>
					</tr>";
	}
	if($modelgenderw !=""){
			$mogender="<tr>
						<td class='bodytable'>Model gender</td>
						<td class='bodytable'>$modelgenderw </td>
					</tr>";
	}
	if($modelagew !=""){
		if($modelagew =="2.5"){$agerange="0 - 5";}
		if($modelagew =="8"){$agerange="6 - 10";}
		if($modelagew =="13"){$agerange="11 - 15";}
		if($modelagew =="18"){$agerange="16 - 20";}
		if($modelagew =="23"){$agerange="21 - 25";}
		if($modelagew =="28"){$agerange="26 - 30";}
		if($modelagew =="35.5"){$agerange="31 - 40";}
		if($modelagew =="45.5"){$agerange="41 - 50";}
		if($modelagew =="55.5"){$agerange="51 - 60";}
		if($modelagew =="+60"){$agerange="+60";}
			$moage="<tr>
						<td class='bodytable'>Model age</td>
						<td class='bodytable'>$agerange </td>
					</tr>";
	}
		


$alreadyrated=mysqli_query($con,"SELECT * FROM rate_body WHERE img_id='$id' and scorer='$username'");
$count_alreadyrated=mysqli_num_rows($alreadyrated);
	if($count_alreadyrated>=1){			//***************SI YA SE HA VOTADO, MUESTRA TODO Y DICE QUE YA SE HA VOTADO. *********************
		$sum_query=mysqli_query($con,"SELECT score FROM rate_body WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		$avg=round($sum_array/$count_array,1);
		echo "<br><br>Photo already rated<br><br><hr><br>";
		echo "</br></br><center><table>
					<tr>
						<td class='bodytable'>NO VOTES</td>
						<td class='bodytable'>$count_array</td>
					</tr>
					<tr>
						<td class='bodytable'>AVERAGE</td>
						<td class='bodytable'>$avg<span class='starbody'>&#9733;</span></td>
					</tr>
			</table></center>
			</br><center><table>".$marca.$phowner.$titlee.$spec.$moname.$mogender.$moage.$tagg.
			"</table></center></br>";
		

		if($individual!=""){
			echo '<a style="float:right;" href="photodisplay_body.php">Search more&rarr;</a>
				   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
		}
		else{
			
			
			echo '<a style="float:right;" href="rate_body.php?bodycatid=' .$bodycatid. '&bodysubid=' .$bodysubid. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&gender=' .$gender. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_body.png"></a>
				   <a style="float:left;" href="rate_body.php?bodycatid=' .$bodycatid. '&bodysubid=' .$bodysubid. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&gender=' .$gender. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_body.png"></a><br><br></br>';
		}
		
		//Get comments:-------------COMMENTS MENU-------------------------
		$get_comments = mysqli_query($con,"SELECT * FROM post_comments WHERE post_id='$id' ORDER BY id DESC");
		$comment=mysqli_fetch_assoc($get_comments);
			$comment_body=$comment['post_body'];
			$comment_body=$comment_body;
			$posted_to=$comment['posted_to'];
			$posted_by=$comment['posted_by'];
			$removed=$comment['removed'];
		
		
		echo "
		<div class='newsFeedPostbody'></br>
			<div class='newsfeedoptions'>
				<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
			</div>
			<div id='toggleComment$id' style='display:none'>
				<iframe src='./comment_frame.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:250px;'></iframe>
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
			$introduce_score=mysqli_query($con,"INSERT INTO rate_body VALUES ('','$scores','$username','$id','$owner','$date_scored')");
			$i=$page+1;
			if ($i > $row_count){
				$i=1;
			}
			$j=$page-1;
			if ($page == 1 ){
				$j=$row_count;
			}

			$sum_query=mysqli_query($con,"SELECT score FROM rate_body WHERE img_id=$id");
			$count_array=mysqli_num_rows($sum_query);
			while ($array=mysqli_fetch_array($sum_query)){
				$sum_array +=$array['score'];
			}
			$avg=round($sum_array/$count_array,1);
				echo "<br><br>Photo already rated<br><br><hr><br>";
				echo "</br></br><center><table>
							<tr>
								<td class='bodytable'>NO VOTES</td>
								<td class='bodytable'>$count_array</td>
							</tr>
							<tr>
								<td class='bodytable'>AVERAGE</td>
								<td class='bodytable'>$avg<span class='starbody'>&#9733;</span></td>
							</tr>
					</table></center>
					</br><center><table>".$marca.$phowner.$titlee.$spec.$moname.$mogender.$moage.$tagg.
					"</table></center></br>";
					
				if($individual!=""){
					echo '<a style="float:right;" href="photodisplay_body.php">Search more&rarr;</a>
				   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
				}
				else{
								
					echo '<a style="float:right;" href="rate_body.php?bodycatid=' .$bodycatid. '&bodysubid=' .$bodysubid. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&gender=' .$gender. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_body.png"></a>
					       <a style="float:left;" href="rate_body.php?bodycatid=' .$bodycatid. '&bodysubid=' .$bodysubid. '&username2=' . $username2 . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&gender=' .$gender. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_body.png"></a><br><br></br>';
				}

					//Get comments:-------------COMMENTS MENU-------------------------
					$get_comments = mysqli_query($con,"SELECT * FROM post_comments WHERE post_id='$id' ORDER BY id DESC");
					$comment=mysqli_fetch_assoc($get_comments);
						$comment_body=$comment['post_body'];
						$comment_body=$comment_body;
						$posted_to=$comment['posted_to'];
						$posted_by=$comment['posted_by'];
						$removed=$comment['removed'];
					
					
					echo "
					<div class='newsFeedPostbody'></br>
						<div class='newsfeedoptions'>
							<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
						</div>
						<div id='toggleComment$id' style='display:none'>
							<iframe src='./comment_frame.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:250px;'></iframe>
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

		<?php
			
			$urlphoto=urlencode($image_url);
			$urlurl=urlencode($actual_link);
			$title2=urlencode($title);
			$summary=urlencode($description);
			
			@$indiv=3*728/$id +431160;
			$indilink="http://rankpion.com/rate_body.php?indiv=$indiv";
			$urlindilink=urlencode($indilink);
			
			//echo $urlphoto.'<br/>'.$urlurl.'<br/>'.$title.'<br/>'.$urlindilink;
		?>
				<meta property="og:title"              content="<?php echo $title;?>" />
				<meta name="title"              content="<?php echo $title2;?>" />
				<meta property="og:description"        content="<?php echo $description;?>" />
				<meta property="og:image"              content="<?php echo $image_url;?>" />

		</br>				
		<a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title2;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $urlindilink; ?>&amp;p[images][0]=<?php echo $urlphoto;?>','sharer','toolbar=0,status=0,width=550,height=300');" href="javascript: void(0)"><img src="./img/facebook/share.PNG" style="background-color:transparent; max-width:80px;max-height:40px;"/></a>
		
		


<!--<div class="fb-share-button" data-href="<?php echo $actual_link;?>" 
	data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" 
	href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlindilink;?>&amp;
	src=sdkpreparse">Share</a>
</div>

!-->



</br></br> 
<?php
include("inc/footer.inc.php");
?>