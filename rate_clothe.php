<?php $color="blue";
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

		/*xxx*/$filtrado = test_input($_GET['clothecatid']);
	$clothecatid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['clothesubid']);
	$clothesubid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['username2']);
	$username2 = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['favs']);
	$favs = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['brand']);
	$brand = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_GET['shop']);
	$shop = mysqli_real_escape_string($con,$filtrado);
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
	//   BRAND FILTER
	if($brand==""){
		$brandfilter="";
	}
	else{
		$brandfilter= " && brand='" .$brand. "' ";
	}
	//   SHOP FILTER
	if($shop==""){
		$shopfilter="";
	}
		else{
		$shopfilter= " && shop='" .$shop. "' ";
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
if (($clothecatid==0)&&($individual=="")){
	echo "</br></br></br><center> You have to select a CLOTHES CATEGORY and SUBCATEGORY!</br></br></br>Please, </center><a href='photodisplay_clothe.php'><h4 style='max-width:110px;'> TRY AGAIN</h4></a>.</br>";//errormsg
//	echo "<script type='text/javascript'>alert('alert text goes here');</script>";
	}
else{
		if ($country=="4ny"){ //Filter for any region if no photos matching that criteria.
		$locationfilter="";
	}
		
		
		
		
		
	if($individual!=""){
		$row_count="1";
		$sql = "SELECT * FROM photos_clo WHERE id=".$individual." && removed='no' ";
		$get_photos=mysqli_query($con,$sql);
	}
	else{
		$idfilter= " uid='" .$clothesubid. "' ";
		if ($clothesubid==0){
			$idfilter=" catid='" .$clothecatid. "' ";
		}
		// set the number of items to display per page
		$items_per_page = 1;
		// build query
		$offset = ($page - 1) * $items_per_page;
		$sql = "SELECT * FROM photos_clo WHERE $idfilter$usernamefilter$locationfilter$brandfilter$shopfilter$tagfilter$daysagofilter && removed='no' ORDER BY id DESC LIMIT " . $offset . "," . $items_per_page . " ";
		$get_photos=mysqli_query($con,$sql);
		$get_all_photos=mysqli_query($con,"SELECT * FROM photos_clo WHERE $idfilter$usernamefilter$locationfilter$brandfilter$shopfilter$tagfilter$daysagofilter && removed='no'");
		$row_count=mysqli_num_rows($get_all_photos);
	}
	
	
	if($row_count==0){
	echo "</center></br></br>There are no photos matching that criteria. </br>Please, <a href='photodisplay_clothe.php'> try again.</a>";//errormsg
	echo '</br><a href="rate_clothe.php?clothecatid=' .$clothecatid. '&clothesubid=' .$clothesubid. '&username2=&favs=0&brand=&shop=&tags=&gender=0&country=4ny&daysago=0"><input type="submit" value="Any region"/></a></center>';
	}                   																			 
	else{
		while($row=mysqli_fetch_array($get_photos)){
			$id=$row['id'];
			$uid=$row['uid'];
			$owner = $row['username'];
			$description = $row['description'];
			$image_url = $row['image_url'];
			$title=$row['title'];
			$tagsw=$row['tags'];
			$brandw=$row['brand'];
			$pricew=$row['price'];
			$shopw=$row['shop'];
			
			
			$get_marca=mysqli_query($con,"SELECT name FROM catclothes WHERE id='$uid'");
			$row_mar=mysqli_fetch_assoc($get_marca);
			$marc=$row_mar['name'];

			echo"
		
			<div class='photoframe2' style='border:2px solid blue;'>
				</br><img src='$image_url' name='[$id]' id='[$id]' style='max-height:560px; max-width:98%; margin-top:10px;'><br />
				<form class='frame2' action='' method='POST' style='background-color:blue;'>	
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
} 
else {
   @$page_count = (int)ceil($row_count / $items_per_page);
   if($page > $page_count) {
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
					<td class='clotable'>Brand</td>
					<td class='clotable'>$marc</td>
				</tr>";
			$phowner="<tr>
				<td class='clotable'>Photo Owner</td>
				<td class='clotable'>$owner</td>
			</tr>";
			if($description !=""){
				$spec="<tr>
						<td class='clotable'>Description</td>
						<td class='clotable'>$description</td>
					</tr>";
			}	
			if($title !=""){
				$titlee="<tr>
						<td class='clotable'>Title</td>
						<td class='clotable'>$title</td>
					</tr>";
			}
			if($tagsw !=""){
					$tagg="<tr>
								<td class='clotable'>Tag</td>
								<td class='clotable'>$tagsw</td>
							</tr>";
			}
			if($brandw !=""){
					$brandname="<tr>
								<td class='clotable'>Brand</td>
								<td class='clotable'>$brandw</td>
							</tr>";
			}
			if($pricew !=""){
					$pricename="<tr>
								<td class='clotable'>Price </td>
								<td class='clotable'>$pricew</td>
							</tr>";
			}
			if($shopw !=""){
					$shopname="<tr>
								<td class='clotable'>Shop</td>
								<td class='clotable'>$shopw</td>
							</tr>";
			}



$alreadyrated=mysqli_query($con,"SELECT * FROM rate_clothe WHERE img_id='$id' and scorer='$username'");
$count_alreadyrated=mysqli_num_rows($alreadyrated);
	if($count_alreadyrated>=1){			//***************SI YA SE HA VOTADO, MUESTRA TODO Y DICE QUE YA SE HA VOTADO. *********************
		$sum_query=mysqli_query($con,"SELECT score FROM rate_clothe WHERE img_id=$id");
		$count_array=mysqli_num_rows($sum_query);
		while ($array=mysqli_fetch_array($sum_query)){
			$sum_array +=$array['score'];
		}
		$avg=round($sum_array/$count_array,1);
		echo "<br><br>Photo already rated<br><br><hr><br>";
		echo "</br></br><center><table>
					<tr>
						<td class='clotable'>NO VOTES</td>
						<td class='clotable'>$count_array</td>
					</tr>
					<tr>
						<td class='clotable'>AVERAGE</td>
						<td class='clotable'>$avg<span class='starclo'>&#9733;</span></td>
					</tr>
			</table></center>
			</br><center><table>".$marca.$phowner.$titlee.$spec.$brandname.$pricename.$shopname.$tagg.
			"</table></center></br>";
		
			if($individual!=""){
				echo '<a style="float:right;" href="photodisplay_clothe.php">Search more&rarr;</a>
					   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
			}
			else{		
			
				echo '<a style="float:right;" href="rate_clothe.php?clothecatid=' .$clothecatid. '&clothesubid=' .$clothesubid. '&username2=' . $username2 . '&favs=' .$favs. '&shop=' .$shop. '&brand=' .$brand. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_clo.png"></a> 
					  <a style="float:left;" href="rate_clothe.php?clothecatid=' .$clothecatid. '&clothesubid=' .$clothesubid. '&username2=' . $username2 . '&favs=' .$favs. '&shop=' .$shop. '&brand=' .$brand. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_clo.png"></a><br><br><br>';
			}
		
		//Get comments:-------------COMMENTS MENU-------------------------
		$get_comments = mysqli_query($con,"SELECT * FROM post_comments_clo WHERE post_id='$id' ORDER BY id DESC");
		$comment=mysqli_fetch_assoc($get_comments);
			$comment_body=$comment['post_body'];
			$posted_to=$comment['posted_to'];
			$posted_by=$comment['posted_by'];
			$removed=$comment['removed'];
		
		
		echo "
		<div class='newsFeedPostclothe'></br>
			<div class='newsfeedoptions'>
				<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
			</div>
			<div id='toggleComment$id' style='display:none'>
				<iframe src='./comment_frame_clo.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:250px;'></iframe>
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
	$introduce_score=mysqli_query($con,"INSERT INTO rate_clothe VALUES ('','$scores','$username','$id','$owner','$date_scored')");
$i=$page+1;
if ($i > $row_count){
	$i=1;
}
$j=$page-1;
if ($page == 1 ){
	$j=$row_count;
}

$sum_query=mysqli_query($con,"SELECT score FROM rate_clothe WHERE img_id=$id");
$count_array=mysqli_num_rows($sum_query);
while ($array=mysqli_fetch_array($sum_query)){
$sum_array +=$array['score'];
}
		$avg=round($sum_array/$count_array,1);
		echo "<br><br>Photo already rated<br><br><hr><br>";
		echo "</br></br><center><table>
					<tr>
						<td class='clotable'>NO VOTES</td>
						<td class='clotable'>$count_array</td>
					</tr>
					<tr>
						<td class='clotable'>AVERAGE</td>
						<td class='clotable'>$avg<span class='starclo'>&#9733;</span></td>
					</tr>
			</table></center>
			</br><center><table>".$marca.$phowner.$titlee.$spec.$brandname.$pricename.$shopname.$tagg.
			"</table></center></br>";
		if($individual!=""){
			echo '<a style="float:right;" href="photodisplay_clothe.php">Search more&rarr;</a>
				   <a style="float:left;" href="view_albums.php">&larr;Albums</a><br><br></br>';
		}
		else{		
			
			echo '<a style="float:right;" href="rate_clothe.php?clothecatid=' .$clothecatid. '&clothesubid=' .$clothesubid. '&username2=' . $username2 . '&favs=' .$favs. '&shop=' .$shop. '&brand=' .$brand. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $i . '"><img style="max-height:35px;float:left;" src="./img/next_cir_clo.png"></a> 
				  <a style="float:left;" href="rate_clothe.php?clothecatid=' .$clothecatid. '&clothesubid=' .$clothesubid. '&username2=' . $username2 . '&favs=' .$favs. '&shop=' .$shop. '&brand=' .$brand. '&tags=' .$tags. '&country=' .$country. '&category=' .$category. '&colour=' .$colour. '&daysago=' .$daysago. '&scored=' .$scored. '&random=' .$random. '&page=' . $j . '"><img style="max-height:35px;float:left;" src="./img/prev_cir_clo.png"></a><br><br><br>';
		}
		//Get comments:-------------COMMENTS MENU-------------------------
		$get_comments = mysqli_query($con,"SELECT * FROM post_comments_clo WHERE post_id='$id' ORDER BY id DESC");
		$comment=mysqli_fetch_assoc($get_comments);
			$comment_body=$comment['post_body'];
			$posted_to=$comment['posted_to'];
			$posted_by=$comment['posted_by'];
			$removed=$comment['removed'];
		
		
		echo "
		<div class='newsFeedPostclothe'></br>
			<div class='newsfeedoptions'>
				<a href='javascript:;' onClick='javascript:toggle$id()'>Show comments
			</div>
			<div id='toggleComment$id' style='display:none'>
				<iframe src='./comment_frame_clo.php?id=$id' frameborder='0' style='width:100%; height:auto; min-height:20px; max-height:250px;'></iframe>
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