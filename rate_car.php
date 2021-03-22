<?php $color="red";
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
	if (isset($_GET['page'])) {	//anything stored in after u= is stored in the get u variable.
		/*xxx*/$filtrado = test_input($_GET['page']);
		$page = mysqli_real_escape_string($con,$filtrado);
	}

	
		/*xxx*/$filtrado = test_input($_GET['carcatid']);
	$carcatid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['carsubid']);
	$carsubid = mysqli_real_escape_string($con,$filtrado);
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
		/*xxx*/$filtrado = test_input($_GET['component']);
	$component = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['random']);
	$random = mysqli_real_escape_string($con,$filtrado);	
		/*xxx*/$filtrado = test_input($_GET['modelyear']);
	$modelyear = mysqli_real_escape_string($con,$filtrado);	
	
	
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
	//   COMPONENT FILTER
	if($component=="0"){
		$componentfilter="";
	}
	else{
		$componentfilter= " && component='" .$component. "' ";
	}
	//   MODELYEAR FILTER
	if($modelyear=="0"){
		$modelyearfilter="";
	}
	else{
		$modelyearfilter= " && modelyear='" .$modelyear. "' ";
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

	//   CARID FILTER
	if($carsubid==0){
		if($carcatid==0){
		}
		else{
			$carsubid=3333;
			$caridsubidfilter= "uid2='" .$carcatid. "' ";
		}
	}
	else{
		$caridsubidfilter= "uid='" .$carsubid. "' ";
	}
}
//BODY ID OBLIGATORIO
if (($carsubid==0)&&($individual=="")){
	echo "</br></br></br> You have to select at least a CAR BRAND!</br><a href='photodisplay_car.php'><h4 style='max-width:110px;'>TRY AGAIN</h4></a></br>";//errormsg
	//echo "<script type='text/javascript'>alert('alert text goes here');</script>";
	}
else{
	if ($country=="4ny"){ //Filter for any region if no photos matching that criteria.
		$locationfilter="";
	}
		
		
		
		
		
	if($individual!=""){
		$row_count="1";
		$sql = "SELECT * FROM photos_car WHERE id=".$individual." && removed='no' ";
		$get_photos=mysqli_query($con,$sql);
	}			
	else{
		if($carsubid==3333){$carsubid=0;}
		// set the number of items to display per page
		$items_per_page = 1;
		// build query
		$offset = ($page - 1) * $items_per_page;
		$sql = "SELECT * FROM photos_car WHERE $caridsubidfilter$usernamefilter$locationfilter$componentfilter$modelyearfilter$tagfilter$daysagofilter && removed='no' ORDER BY id DESC LIMIT " . $offset . "," . $items_per_page . " ";
		$get_photos=mysqli_query($con,$sql);
		$get_all_photos=mysqli_query($con,"SELECT * FROM photos_car WHERE $caridsubidfilter$usernamefilter$locationfilter$componentfilter$modelyearfilter$tagfilter$daysagofilter && removed='no'");
		$row_count=mysqli_num_rows($get_all_photos);
	}	
	
	
	
	
	
		if($row_count==0){
		echo "</br></br>There are no photos matching that criteria. </br><a href='photodisplay_car.php'><h4 style='max-width:110px;'>TRY AGAIN</h4></a></br>";
		echo '</br><a href="rate_car.php?carcatid=' .$carcatid. '&carsubid=' .$carsubid. '&username2=&component=0&modelyear=0&favs=0&tags=&country=4ny&category=&colour=&daysago=0&scored=&random="><input type="submit" value="Any region"/></a></center>';

		}
		else{
			while($row=mysqli_fetch_array($get_photos)){
				$id=$row['id'];
				$uid=$row['uid'];
				$uid2=$row['uid2'];
				$owner = $row['username'];
				//$date_posted = $row['date_posted'];
				$description = $row['description'];
				$image_url = $row['image_url'];
				$title=$row['title'];
				$tag=$row['tags'];
				$componentn=$row['component'];
				$modyear=$row['modelyear'];
				$color=$row['color'];
				$price=$row['price'];			
				$shop=$row['shop'];
				$get_marca=mysqli_query($con,"SELECT model FROM catcars WHERE id='$uid2'");
				$get_model=mysqli_query($con,"SELECT model FROM catcars WHERE id='$uid'");
				$row_mar=mysqli_fetch_assoc($get_marca);
				$row_mod=mysqli_fetch_array($get_model);
				$marc=$row_mar['model'];
				$mode=$row_mod['model'];
				echo"
				
				<div class='photoframe2' style='border:2px solid red;'> 
					</br><img src='$image_url' name='[$id]' id='[$id]' style='max-height:560px; max-width:98%; margin-top:10px;'><br />
					<form class='frame2' action='' method='POST' style='background-color:red;'>	
						<center class='frame2' >
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
			} else {
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
			$marca="<tr>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>Brand</td>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>$marc</td>
					</tr>";
			$modelo="<tr>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>Model</td>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>$mode</td>
					</tr>";
			$phowner="<tr>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>Photo Owner</td>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>$owner</td>
					</tr>";
			$componentt="<tr>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>Component</td>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>$componentn</td>
					</tr>";
			$modyearr="<tr>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>Model Year</td>
						<td class='cartable' style='padding: 5px 15px 5px 15px;'>$modyear</td>
					</tr>";
			if($description !=""){
				$spec="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Specs</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$description</td>
						</tr>";
			}		
			if($title !=""){
				$titlee="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Title</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$title</td>
						</tr>";
			}	
			if($tag !=""){
				$tagg="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Tag</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$tag</td>
						</tr>";
			}
			if($color !=""){
				$colorr="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Color</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$color</td>
						</tr>";
			}
			if($price !=""){
				$pricer="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Price</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$price</td>
						</tr>";
			}
			if($shop !=""){
				$shopr="<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>Shop</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$shop</td>
						</tr>";
			}
	$alreadyrated=mysqli_query($con,"SELECT * FROM rate_car WHERE img_id='$id' and scorer='$username'");
	$count_alreadyrated=mysqli_num_rows($alreadyrated);
		if($count_alreadyrated>=1){			//***************SI YA SE HA VOTADO, MUESTRA TODO Y DICE QUE YA SE HA VOTADO. *********************
			$sum_query=mysqli_query($con,"SELECT score FROM rate_car WHERE img_id=$id");
			$count_array=mysqli_num_rows($sum_query);
			while ($array=mysqli_fetch_array($sum_query)){
				$sum_array +=$array['score'];
			}
			$avg=round($sum_array/$count_array,1);
			echo "<br><br>Photo already rated<br><br><hr><br>";
			echo "</br></br><center><table>
						<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>NO VOTES</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$count_array</td>
						</tr>
						<tr>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>AVERAGE</td>
							<td class='cartable' style='padding: 5px 15px 5px 15px;'>$avg<span class='cartable' style='color:rgb(230,190,0); padding:1px; font-size:20px;'>&#9733;</span></td>
						</tr>
				</table></center>
				</br><center><table>".$marca.$modelo.$phowner.$titlee.$spec.$componentt.$modyearr.$colorr.$pricer.$shopr.$tagg.
				"</table></center></br>";
				
			if($individual!=""){
				echo '<a style="float:right;" href="photodisplay_car.php">Search more&rarr;</a>
					   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
			}
			else{
				echo '<a style="float:right;" href="rate_car.php?carcatid=' .$carcatid. '&carsubid=' .$carsubid. '&username2=' . $username2 . '&component=' . $component . '&modelyear=' . $modelyear . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_car.png"></a> 
					   <a style="float:left;" href="rate_car.php?carcatid=' .$carcatid. '&carsubid=' .$carsubid. '&username2=' . $username2 . '&component=' . $component . '&modelyear=' . $modelyear . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_arr_car.png"></a><br><br></br>';
			}
			//Get comments:-------------COMMENTS MENU-------------------------
	/*!!!!!!CHEQUEAR SI AQUI PUEDE COGER LOS COMMENTS DE OTRA FOTO CON IGUAL ID DE DIFERENTE CATEGORIA!!!!!!*/		
			$get_comments = mysqli_query($con,"SELECT * FROM post_comments_car WHERE post_id='$id' ORDER BY id DESC");
			$comment=mysqli_fetch_assoc($get_comments);
				$comment_body=$comment['post_body'];
				$posted_to=$comment['posted_to'];
				$posted_by=$comment['posted_by'];
				$removed=$comment['removed'];
			
			
			echo "
			<div class='newsFeedPostcar'></br>
				<div class='newsfeedoptions'>
					<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
				</div>
				<div id='toggleComment$id' style='display:none'>
					<iframe src='./comment_frame_car.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:300px;'></iframe>
				</div>
					<p />
			</div>
					<p />
			";
		}
		else{				//*******************SI AUN NO SE HA VOTADO, SE MUESTRA RECOGE EL VOTO Y, UNA VEZ HECHO, SE MUESTRA TODO. **********************************

	if(isset($_POST['score'])){
		$scores = $_POST['scores'];
		if ($scores==0){
			$ratezero='</br><h5>You have to select a VALUE to RATE the photo</h5></br></br>';
			echo $ratezero;
		}
		else{
		$date_scored=date("ymdhis");
		$introduce_score=mysqli_query($con,"INSERT INTO rate_car VALUES ('','$scores','$username','$id','$owner','$date_scored')");
	$i=$page+1;
	if ($i > $row_count){
		$i=1;
	}
	$j=$page-1;
	if ($page == 1 ){
		$j=$row_count;
	}

	$sum_query=mysqli_query($con,"SELECT score FROM rate_car WHERE img_id=$id");
	$count_array=mysqli_num_rows($sum_query);
	while ($array=mysqli_fetch_array($sum_query)){
	$sum_array +=$array['score'];}
	$avg=round($sum_array/$count_array,1);

	echo "<br><br>Photo already rated<br><br><hr><br>";
	echo "</br></br>
		<center>
			<table>
				<tr>
					<td class='cartable' style='padding: 5px 15px 5px 15px;'>NO VOTES</td>
					<td class='cartable' style='padding: 5px 15px 5px 15px;'>$count_array</td>
				</tr>
				<tr>
					<td class='cartable' style='padding: 5px 15px 5px 15px;'>AVERAGE</td>
					<td class='cartable' style='padding: 5px 15px 5px 15px;'>$avg<span style='color:rgb(230,190,0); padding:1px; font-size:20px;'>&#9733;</span></td>
				</tr>
			</table>
		</center></br>
		<center>
			<table>".$marca.$modelo.$phowner.$titlee.$spec.$componentt.$modyearr.$colorr.$pricer.$shopr.$tagg.
			"</table>
		</center></br>";
		
		
			if($individual!=""){
				echo '<a style="float:right;" href="photodisplay_car.php">Search more&rarr;</a>
					   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
			}
			else{
				echo '<a style="float:right;" href="rate_car.php?carcatid=' .$carcatid. '&carsubid=' .$carsubid. '&username2=' . $username2 . '&component=' . $component . '&modelyear=' . $modelyear . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_car.png"></a> 
					   <a style="float:left;" href="rate_car.php?carcatid=' .$carcatid. '&carsubid=' .$carsubid. '&username2=' . $username2 . '&component=' . $component . '&modelyear=' . $modelyear . '&favs=' .$favs. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_arr_car.png"></a><br><br></br>';
			}
			//Get comments:-------------COMMENTS MENU-------------------------
	/*!!!!!!CHEQUEAR SI AQUI PUEDE COGER LOS COMMENTS DE OTRA FOTO CON IGUAL ID DE DIFERENTE CATEGORIA!!!!!!*/		
			$get_comments = mysqli_query($con,"SELECT * FROM post_comments_car WHERE post_id='$id' ORDER BY id DESC");
			$comment=mysqli_fetch_assoc($get_comments);
				$comment_body=$comment['post_body'];
				$posted_to=$comment['posted_to'];
				$posted_by=$comment['posted_by'];
				$removed=$comment['removed'];
			
			
			echo "
			<div class='newsFeedPostcar'></br>
				<div class='newsfeedoptions'>
					<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
				</div>
				<div id='toggleComment$id' style='display:none'>
					<iframe src='./comment_frame_car.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:300px;'></iframe>
				</div>
					<p />
			</div>
					<p />
			";
		}
	}
	}
	
}			echo"</div>";
?>
