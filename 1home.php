<?php
include ( "./inc/header.inc.php");

if(!isset( $_SESSION['user_login'])) {
	header("Location: index.php");
	}
else {

	//User values
	$puntuation=mysqli_query($con,"SELECT * FROM ranking WHERE username='$username'");
	$puntaco=mysqli_fetch_assoc($puntuation);
	$city=$puntaco['country'];
		$body_total=$puntaco['body_total'];
	$clothe_total=$puntaco['clothe_total'];
	$car_total=$puntaco['car_total'];
	$soli_total=$puntaco['soli_total'];
	$total_total=$puntaco['total_total'];
		$body_varday=$puntaco['body_varday'];
	$clothe_varday=$puntaco['clothe_varday'];
	$car_varday=$puntaco['car_varday'];
	$soli_varday=$puntaco['soli_varday'];
	$total_varday=$puntaco['total_varday'];
		$body_varweek=$puntaco['body_varweek'];
	$clothe_varweek=$puntaco['clothe_varweek'];
	$car_varweek=$puntaco['car_varweek'];
	$soli_varweek=$puntaco['soli_varweek'];
	$total_varweek=$puntaco['total_varweek'];
		$body_varmonth=$puntaco['body_varmonth'];
	$clothe_varmonth=$puntaco['clothe_varmonth'];
	$car_varmonth=$puntaco['car_varmonth'];
	$soli_varmonth=$puntaco['soli_varmonth'];
	$total_varmonth=$puntaco['total_varmonth'];
	//Ranking user in area
	$samecity=mysqli_query($con,"SELECT * FROM ranking WHERE country='$city'");
	$count_no_city=mysqli_num_rows($samecity);

	$body_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE body_total>'$body_total' AND country='$city'");
	$body_total_rank=mysqli_num_rows($body_total_poss)+1;
	$clothe_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE clothe_total>'$clothe_total' AND country='$city'");
	$clothe_total_rank=mysqli_num_rows($clothe_total_poss)+1;
	$car_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE car_total>'$car_total' AND country='$city'");
	$car_total_rank=mysqli_num_rows($car_total_poss)+1;
	$soli_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE soli_total>'$soli_total' AND country='$city'");
	$soli_total_rank=mysqli_num_rows($soli_total_poss)+1;
	$total_total_poss=mysqli_query($con,"SELECT username FROM ranking WHERE total_total>'$total_total' AND country='$city'");
	$total_total_rank=mysqli_num_rows($total_total_poss)+1;

	$body_varday_poss=mysqli_query($con,"SELECT username FROM ranking WHERE body_varday>'$body_varday' AND country='$city'");
	$body_varday_rank=mysqli_num_rows($body_varday_poss)+1;
	$clothe_varday_poss=mysqli_query($con,"SELECT username FROM ranking WHERE clothe_varday>'$clothe_varday' AND country='$city'");
	$clothe_varday_rank=mysqli_num_rows($clothe_varday_poss)+1;
	$car_varday_poss=mysqli_query($con,"SELECT username FROM ranking WHERE car_varday>'$car_varday' AND country='$city'");
	$car_varday_rank=mysqli_num_rows($car_varday_poss)+1;
	$soli_varday_poss=mysqli_query($con,"SELECT username FROM ranking WHERE soli_varday>'$soli_varday' AND country='$city'");
	$soli_varday_rank=mysqli_num_rows($soli_varday_poss)+1;
	$total_varday_poss=mysqli_query($con,"SELECT username FROM ranking WHERE total_varday>'$total_varday' AND country='$city'");
	$total_varday_rank=mysqli_num_rows($total_varday_poss)+1;

	$body_varweek_poss=mysqli_query($con,"SELECT username FROM ranking WHERE body_varweek>'$body_varweek' AND country='$city'");
	$body_varweek_rank=mysqli_num_rows($body_varweek_poss)+1;
	$clothe_varweek_poss=mysqli_query($con,"SELECT username FROM ranking WHERE clothe_varweek>'$clothe_varweek' AND country='$city'");
	$clothe_varweek_rank=mysqli_num_rows($clothe_varweek_poss)+1;
	$car_varweek_poss=mysqli_query($con,"SELECT username FROM ranking WHERE car_varweek>'$car_varweek' AND country='$city'");
	$car_varweek_rank=mysqli_num_rows($car_varweek_poss)+1;
	$soli_varweek_poss=mysqli_query($con,"SELECT username FROM ranking WHERE soli_varweek>'$soli_varweek' AND country='$city'");
	$soli_varweek_rank=mysqli_num_rows($soli_varweek_poss)+1;
	$total_varweek_poss=mysqli_query($con,"SELECT username FROM ranking WHERE total_varweek>'$total_varweek' AND country='$city'");
	$total_varweek_rank=mysqli_num_rows($total_varweek_poss)+1;

	$body_varmonth_poss=mysqli_query($con,"SELECT username FROM ranking WHERE body_varmonth>'$body_varmonth' AND country='$city'");
	$body_varmonth_rank=mysqli_num_rows($body_varmonth_poss)+1;
	$clothe_varmonth_poss=mysqli_query($con,"SELECT username FROM ranking WHERE clothe_varmonth>'$clothe_varmonth' AND country='$city'");
	$clothe_varmonth_rank=mysqli_num_rows($clothe_varmonth_poss)+1;
	$car_varmonth_poss=mysqli_query($con,"SELECT username FROM ranking WHERE car_varmonth>'$car_varmonth' AND country='$city'");
	$car_varmonth_rank=mysqli_num_rows($car_varmonth_poss)+1;
	$soli_varmonth_poss=mysqli_query($con,"SELECT username FROM ranking WHERE soli_varmonth>'$soli_varmonth' AND country='$city'");
	$soli_varmonth_rank=mysqli_num_rows($soli_varmonth_poss)+1;
	$total_varmonth_poss=mysqli_query($con,"SELECT username FROM ranking WHERE total_varmonth>'$total_varmonth' AND country='$city'");
	$total_varmonth_rank=mysqli_num_rows($total_varmonth_poss)+1;

	$position_body=mysqli_query($con,"SELECT body FROM ranking WHERE country='$city'");
	$count_no_city=mysqli_num_rows($samecity);

//	echo "</br> No city --".$count_no_city."-- body total --".$body_total_rank."/".$count_no_city."-- clothe total --".$clothe_total_rank."/".$count_no_city."-- car total --".$car_total_rank."/".$count_no_city."-- soli total --".$soli_total_rank."/".$count_no_city."-- TOTAL --".$total_total_rank."/".$count_no_city;
//	echo "</br> No city --".$count_no_city."-- body varday --".$body_varday_rank."/".$count_no_city."-- clothe varday --".$clothe_varday_rank."/".$count_no_city."-- car varday --".$car_varday_rank."/".$count_no_city."-- soli varday --".$soli_varday_rank."/".$count_no_city."-- TOTAL --".$total_varday_rank."/".$count_no_city;
//	echo "</br> No city --".$count_no_city."-- body varweek --".$body_varweek_rank."/".$count_no_city."-- clothe varweek --".$clothe_varweek_rank."/".$count_no_city."-- car varweek --".$car_varweek_rank."/".$count_no_city."-- soli varweek --".$soli_varweek_rank."/".$count_no_city."-- TOTAL --".$total_varweek_rank."/".$count_no_city;
//	echo "</br> No city --".$count_no_city."-- body varmonth --".$body_varmonth_rank."/".$count_no_city."-- clothe varmonth --".$clothe_varmonth_rank."/".$count_no_city."-- car varmonth --".$car_varmonth_rank."/".$count_no_city."-- soli varmonth --".$soli_varmonth_rank."/".$count_no_city."-- TOTAL --".$total_varmonth_rank."/".$count_no_city."</br>";

	$category="total_total";
	$colorcat="white".";'"."class='deg90goldbackground'";
	$colorcat2="white".";'"."class='deg90silverbackground'";
	$colorcat3="white".";'"."class='deg90bronzebackground'";
	if(isset($_POST['uploadpic'])){
		$period = strip_tags(@$_POST['period']);
		$categ = strip_tags(@$_POST['category']);
		if($categ=="body"){
			$colorcat="green";
		$colorcat2=$colorcat3=$colorcat;	
		}
		if($categ=="car"){
			$colorcat="red";$colorcat2=$colorcat3=$colorcat;
		}
		if($categ=="clothe"){
			$colorcat="blue";$colorcat2=$colorcat3=$colorcat;
		}
		if($categ=="soli"){
			$colorcat="purple";$colorcat2=$colorcat3=$colorcat;
		}		
	}
	

	//1ST 2ND AND 3RD
	$total_total_1st=mysqli_query($con,"SELECT username FROM ranking WHERE country='$city' ORDER BY $category DESC LIMIT 1 OFFSET 0");
	$row1st=mysqli_fetch_assoc($total_total_1st);
	$user1st=$row1st['username'];
		$total_total_2nd=mysqli_query($con,"SELECT username FROM ranking WHERE country='$city' ORDER BY $category DESC LIMIT 1 OFFSET 1");
	$row2nd=mysqli_fetch_assoc($total_total_2nd);
	$user2nd=$row2nd['username'];
		$total_total_3rd=mysqli_query($con,"SELECT username FROM ranking WHERE country='$city' ORDER BY $category DESC LIMIT 1 OFFSET 2");
	$row3rd=mysqli_fetch_assoc($total_total_3rd);
	$user3rd=$row3rd['username'];


	$get_user_info1st = mysqli_query($con,"SELECT * FROM users WHERE username='$user1st'");
		$get_info1st=mysqli_fetch_assoc($get_user_info1st);
		$profilepic_info1st=$get_info1st['profile_pic'];
		if ($profilepic_info1st==""){
			$profilepic_info1st = "./img/imgpic.jpg";
		}
		else{
			$profilepic_info1st = "./userdata/profile_pics/".$profilepic_info1st;
		}
	$get_user_info2nd = mysqli_query($con,"SELECT * FROM users WHERE username='$user2nd'");
		$get_info2nd=mysqli_fetch_assoc($get_user_info2nd);
		$profilepic_info2nd=$get_info2nd['profile_pic'];
		if ($profilepic_info2nd==""){
			$profilepic_info2nd = "./img/imgpic.jpg";
		}
		else{
			$profilepic_info2nd = "./userdata/profile_pics/".$profilepic_info2nd;
		}
	$get_user_info3rd = mysqli_query($con,"SELECT * FROM users WHERE username='$user3rd'");
		$get_info3rd=mysqli_fetch_assoc($get_user_info3rd);
		$profilepic_info3rd=$get_info3rd['profile_pic'];
		if ($profilepic_info3rd==""){
			$profilepic_info3rd = "./img/imgpic.jpg";
		}
		else{
			$profilepic_info3rd = "./userdata/profile_pics/".$profilepic_info3rd;
		}		
}

$cityquery=mysqli_query($con,"SELECT name FROM categories WHERE id='$city'");
	$punta=mysqli_fetch_assoc($cityquery);
	$area=$punta['name'];

if(isset($_POST['uploadpic'])){
	$period = strip_tags(@$_POST['period']);
	$categ = strip_tags(@$_POST['category']);
	//$category=$categ._.$period;
	//echo "</br>".$category;
}

$updateinfo= @$_POST['updateinfo'];
if($updateinfo){ //update values
	
	$firstname = test_input($_POST['fname']);
		/*xxx*/ $firstname = mysqli_real_escape_string($con,$firstname);
	$finduser=mysqli_query($con,"SELECT username FROM users WHERE username='$firstname'");
	$numuser=mysqli_num_rows($finduser);
	if ($numuser==1){
		header("Location: $firstname");
	}
	else{
		echo "<p style='border:2px solid red;padding:3px;'>We couldn't find a username matching that critetia. Please, check the spelling and try again!</p>";//errormsg
	}
}	
?>
</br>
<b><h2><center><i class="fa fa-user-secret fa-lg" aria-hidden="true"></i>  GOSSIP </center></h2></b></br>
	<hr />	<a><h2 class="hidingborder"><i class="fa fa-cubes fa-lg" aria-hidden="true"></i>  <?php echo $area;?>'s  Top 3</h2></a>
		<center id='content4'></br>
		<p><b>See the TOP 3 in <?php echo $area;?> </b>(Select period and category):</p>
		<a id="form"></a><form action="#form" method="post">
			</br>
			<select name="period">
				<option value="total"> OVERALL </option>
				<option value="varday"> Yesterday </option>
				<option value="varweek"> Last week </option>
				<option value="varmonth"> Last month </option>
			</select>   &rarr;   
			<select name="category">
				<option value="total">TOTAL ALL</option>
				<option value="body"> BODY </option>
				<option value="car"> CARS </option>
				<option value="clothe"> CLOTHES </option>
				<option value="soli"> SOLIDARITY </option>
			</select>   &rarr;   
			<input type="submit" name="uploadpic" value="See Top 3"/></br></br>
		</form>
		<div id="WSTitleDL"><?php echo $lang['HEADER_TITLE']; ?></div>
		<table style="border-collapse: collapse;">
			<tr>
				<td style="padding: 5px 15px 5px 15px;"></td>
				<td style="padding: 5px;"></td>
				<td style="padding: 5px 15px 5px 15px;"><?php echo"<a href='$user1st'><img src='$profilepic_info1st' height='40' style='border-width:2px; border-style:inset;box-shadow: 7px 7px 8px rgb(80,80,80);'><br/></a>";?></td>
				<td style="padding: 5px;"></td>
				<td style="padding: 5px 15px 5px 15px;"></td>
			</tr>
			<tr>
				<td style="padding: 5px 15px 5px 15px;"><?php echo"<a href='$user2nd'><img src='$profilepic_info2nd' height='40' style='border-width:2px; border-style:inset;box-shadow: 7px 7px 8px rgb(80,80,80);'><br/></a>";?></td>
				<td style="padding: 5px;"></td>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);font-size:200%;text-align:center;font-weight: 900;background-color:<?php echo $colorcat;?>'>1</td>
				<td style="padding: 5px;"></td>
				<td style="padding: 5px 15px 5px 15px;"></td>
			</tr>
			<tr>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);font-size:200%;text-align:center;font-weight: 900;background-color:<?php echo $colorcat2;?>'>2</td>
				<td style="padding: 5px;"></td>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);background-color:<?php echo $colorcat;?>'></td>
				<td style="padding: 5px;"></td>
				<td style="padding: 5px 15px 5px 15px;"><?php echo"<a href='$user3rd'><img src='$profilepic_info3rd' height='40' style='border-width:2px; border-style:inset;box-shadow: 7px 7px 8px rgb(80,80,80);'><br/></a>";?></td>
			</tr>
			<tr>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);background-color:<?php echo $colorcat2;?>'></td>
				<td style="padding: 5px;"></td>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);background-color:<?php echo $colorcat;?>'></td>
				<td style="padding: 5px;"></td>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);font-size:200%;text-align:center;font-weight: 900;background-color:<?php echo $colorcat3;?>'>3</td>
			</tr>
			<tr>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);background-color:<?php echo $colorcat2;?>'></td>
				<td></td>
				<td style='color:black;text-align:center;box-shadow: 7px 7px 8px rgb(80,80,80);text-align:center;font-weight: 900;background-color:<?php echo $colorcat;?>'><?php echo $categ;?></td>
				<td></td>
				<td style='padding: 5px 15px 5px 15px;color:black;box-shadow: 7px 7px 8px rgb(80,80,80);background-color:<?php echo $colorcat3;?>'></td>
			</tr>				
		</table></br></br>
		
		<br/><center><a href='other_area.php'>See all</a></center><br/>
		
	</center>
	<!--<hr />-->	
	<a onclick="document.getElementById('content0').style.display=(document.getElementById('content0').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-line-chart fa-lg" aria-hidden="true"></i>   Your Position</h2></a>
	<center id='content0' style="display:none;"></br>
		<p><b>Your OVERALL positions in <?php echo $area;?>'s Ranking:</b></p><br/>
			<div class="goldbackground" id="myBtn">
				<span style="color:green; margin-left:15px;"><?php echo $body_total_rank;?> / </span>
				<span style="color:red;"><?php echo $car_total_rank;?> / </span>
				<span style="color:blue;"><?php echo $clothe_total_rank;?> / </span> 
				<span style="color:purple;"><?php echo $soli_total_rank;?> / </span> 
				<span style="font-size:150%;"><?php echo $total_total_rank;?>/</span>
				<span style="font-size:150%;"><?php echo $count_no_city;?></span>
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
									<p>- Your Ranking in BODY TOTAL: position <?php echo $body_total_rank;?> over <?php echo $count_no_city;?> total people in <?php echo $area;?>.<br/><br/></p>
									<p>- Your Ranking in CAR TOTAL: position <?php echo $car_total_rank;?> over <?php echo $count_no_city;?> total people in <?php echo $area;?>.<br/><br/></p>
									<p>- Your Ranking in CLOTHES TOTAL: position <?php echo $clothe_total_rank;?> over <?php echo $count_no_city;?> total people in <?php echo $area;?>.<br/><br/></p>
									<p>- Your Ranking in SOLIDARITY TOTAL: position <?php echo $soli_total_rank;?> over <?php echo $count_no_city;?> total people in <?php echo $area;?>.<br/><br/></p>
									<p>- Your Ranking in TOTAL: position <?php echo $total_total_rank;?> over <?php echo $count_no_city;?> total people in <?php echo $area;?>.</p>
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
			
			
			
			
			<br/><br/><br/>
	</center>	
	<!--<hr />--><a onclick="document.getElementById('content2').style.display=(document.getElementById('content2').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i>   Your Data</h2></a>
		<center id='content2' style="display:none;"></br>
		<table class="goldbackground"style="border-collapse:collapse;">
			<tr class="border" >
				<td style="padding: 5px;"></td>
				<td style="padding: 5px;"><i class="fa fa-child fa-lg" aria-hidden="true"></i></td>
				<td style="padding: 5px;"><i class="fa fa-car fa-lg" aria-hidden="true"></i></td>
				<td style="padding: 5px;"><img src="./img/clo.png" style="background-color:transparent; max-width:15px;max-height:15px;"></td>
				<td style="padding: 5px;"><i class="fa fa-heart fa-lg" aria-hidden="true"></i></td>
				<td style="padding: 5px;">TOTAL</td>
			</tr>
			<tr class="border" >
				<td style="padding: 5px;">TOTAL position</td>
				<td style="padding: 5px;"><span style="color:green;" title="Your Ranking BODY TOTAL: <?php echo $body_total_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $body_total_rank;?>/<?php echo $count_no_city;?></span></td>
				<td style="padding: 5px;"><span style="color:red;"title="Your Ranking CAR TOTAL: <?php echo $car_total_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $car_total_rank;?>/<?php echo $count_no_city;?></span></td>
				<td style="padding: 5px;"><span style="color:blue;"title="Your Ranking CLOTHES TOTAL: <?php echo $clothe_total_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $clothe_total_rank;?>/<?php echo $count_no_city;?></span> </td>
				<td style="padding: 5px;"><span style="color:purple;"title="Your Ranking SOLIDARITY TOTAL: <?php echo $soli_total_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $soli_total_rank;?>/<?php echo $count_no_city;?></span> </td>
				<td style="padding: 5px;"><span style="font-size:150%;" title="Your ranking in TOTAL in your area"><?php echo $total_total_rank;?>/<?php echo $count_no_city;?></span></td>
			</tr>
			<tr class="border" >
				<td style="padding: 5px;">TOTAL points</td>
				<td style="padding: 5px;"><span style="color:green;" title="Your BODY TOTAL points: <?php echo $body_total;?>"><?php echo $body_total;?></span></td>
				<td style="padding: 5px;"><span style="color:red;"title="Your CAR TOTAL points: <?php echo $car_total;?>"><?php echo $car_total;?></span></td>
				<td style="padding: 5px;"><span style="color:blue;"title="Your CLOTHES TOTAL points: <?php echo $clothe_total;?>"><?php echo $clothe_total;?></span> </td>
				<td style="padding: 5px;"><span style="color:purple;"title="Your SOLIDARITY TOTAL points: <?php echo $soli_total;?>"><?php echo $soli_total;?></span> </td>
				<td style="padding: 5px;"><span style="font-size:150%;" title="Your points TOTAL in your area: <?php echo $total_total;?>"><?php echo $total_total;?></span></td>
			</tr>
			<tr class="border" >
				<td style="padding: 5px;">Y'DAYs position</td>
				<td style="padding: 5px;"><span style="color:green;" title="Your Ranking BODY Yesterday: <?php echo $body_varday_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $body_varday_rank;?>/<?php echo $count_no_city;?></span></td>
				<td style="padding: 5px;"><span style="color:red;"title="Your Ranking CAR Yesterday: <?php echo $car_varday_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $car_varday_rank;?>/<?php echo $count_no_city;?></span></td>
				<td style="padding: 5px;"><span style="color:blue;"title="Your Ranking CLOTHES Yesterday: <?php echo $clothe_varday_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $clothe_varday_rank;?>/<?php echo $count_no_city;?></span> </td>
				<td style="padding: 5px;"><span style="color:purple;"title="Your Ranking SOLIDARITY Yesterday: <?php echo $soli_varday_rank;?> position OVER <?php echo $count_no_city;?> TOTAL PEOPLE"><?php echo $soli_varday_rank;?>/<?php echo $count_no_city;?></span> </td>
				<td style="padding: 5px;"><span style="font-size:150%;" title="Your  Yesterday's ranking in your area"><?php echo $total_varday_rank;?>/<?php echo $count_no_city;?></span></td>

			</tr>
			<tr class="border" >
				<td style="padding: 5px;">Y'DAYs points</td>
				<td style="padding: 5px;"><span style="color:green;" title="Your BODY points Yesterday: <?php echo $body_varday;?>"><?php echo "+".$body_varday;?></span></td>
				<td style="padding: 5px;"><span style="color:red;"title="Your CAR points Yesterday: <?php echo $car_varday;?>"><?php echo "+".$car_varday;?></span></td>
				<td style="padding: 5px;"><span style="color:blue;"title="Your CLOTHES points Yesterday: <?php echo $clothe_varday;?>"><?php echo "+".$clothe_varday;?></span></td>
				<td style="padding: 5px;"><span style="color:purple;"title="Your SOLIDARITY points Yesterday: <?php echo $soli_varday;?>"><?php echo "+".$soli_varday;?></span> </td>
				<td style="padding: 5px;"><span style="font-size:150%;" title="Your points Yesterday in your area: <?php echo $total_varday;?>"><?php echo "+".$total_varday;?></span></td>
			</tr>
		</table></br></center>
<!--<hr />-->
	<a onclick="document.getElementById('content3').style.display=(document.getElementById('content3').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-search fa-lg" aria-hidden="true"></i>   Find a User</h2></a>
		<form id='content3' style="display:none;" action="" method="post">
			<br/><center><input type="text" name="fname" id="fname" size="40" placeholder="Type the username..."> <br />
			<br/><input type="submit" name="updateinfo" id="updateinfo" Value="Search"></center><br/><br/>
		</form>
<!--<hr />-->
	<a onclick="document.getElementById('content').style.display=(document.getElementById('content').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-list-ol fa-lg" aria-hidden="true"></i>   Other Areas' Ranking</h2></a>
		<form id='content' style="display:none;" action="other_area.php" method="post">
			<br/><center><input type="submit" name="u" Value="SEE RANKING"></center><br/><br/>
		</form>
<hr/><br/>
<?php
include ( "./inc/footer.inc.php");
?>