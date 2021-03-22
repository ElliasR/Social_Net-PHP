<?php
include("./inc/header.inc.php"); 
echo "</br></br><h3> Hello <b>".htmlspecialchars($username, ENT_QUOTES)."</b>, Welcome to ChiguitoJudas.</h3><br/>"; 

if( $_SESSION['user_login']=="And66") {
	    $date= date('Y-m-d H:i:s');
		$dater= date('2018-03-18 21:30:01');
/*		if(isset($_POST['dale'])){
			$mo=strip_tags($_POST['mo']);
			$da=strip_tags($_POST['da']);
			$dater= date('2016-'.$mo.'-'.$da.' 00:00:01');
		}*/
		echo "ahora son las ".$date."</br>";
		$day="today"; // today yesterday week month
		echo $dater." date updates</br>";
	

		
/* ----------------------------------------------	 
A diario:
	1.- Actualizo fecha de DATER y de YESTERDAY
	2.- Boton actualizo TODAY		
	3.- fecha yesterday -> Boton actualizo YESTERDAY

DOMINGO.- 
	1, 2, 3 
	fecha wee -> Boton actualizo WEEK. 
	
ULTIMO DIA MES.- 
	1, 2, 3, 
	fecha mon -> Boton actualizo MONTH	

Descargo la tabla de ese dia, 
cambio el nombre a la fecha del dia, 
verifico en tabla ranking dateupdate las fechas
----------------------------------------------	*/		


		
		
//UPDATES VALUES OF TODAYS ACTIVITY
	if(isset($_POST['uploadTODAY'])){
		$get_users=mysqli_query($con,"SELECT * FROM users WHERE closed='no'");
		$numrows=mysqli_num_rows($get_users);

		while($row=mysqli_fetch_assoc($get_users)){
			$id=$row['id'];
			$username=$row['username'];
			$country=$row['country'];	
					
			//No people you are fav for
				$no_fav_for=mysqli_query($con,"SELECT * FROM friend_requests WHERE user_to='$username' AND removed='n' AND date_fav<'$dater'");
				$count_no_fav_for=mysqli_num_rows($no_fav_for);
			//No another's photos commented
				$no_photos_commented=mysqli_query($con,"SELECT * FROM post_comments WHERE posted_by='$username' AND date<'$dater'");
				$count_no_photos_commented=mysqli_num_rows($no_photos_commented);
			//No profiles commented
				$no_profiles_commented=mysqli_query($con,"SELECT * FROM posts WHERE added_by='$username' AND date_added<'$dater'");
				$count_no_profiles_commented=mysqli_num_rows($no_profiles_commented);
				
			//-------------------- BODY	--------------------------------------
				
			//No photos uploaded
				$no_photos=mysqli_query($con,"SELECT * FROM photos WHERE username='$username' AND date_posted<'$dater'");
				$count_no_photos=mysqli_num_rows($no_photos); 
			//No scores of your photos
				$no_been_scored=mysqli_query($con,"SELECT * FROM rate_body WHERE owner='$username' AND date<'$dater'");
				$count_no_been_scored=mysqli_num_rows($no_been_scored);
			//No another's photos scored
				$no_scored=mysqli_query($con,"SELECT * FROM rate_body WHERE scorer='$username' AND date<'$dater'");
				$count_no_scored=mysqli_num_rows($no_scored);
			//No scored and sum 
				$sum_query=mysqli_query($con,"SELECT score FROM rate_body WHERE owner='$username' AND date<'$dater'");
				$count_array=mysqli_num_rows($sum_query);
				while ($array=mysqli_fetch_array($sum_query)){
				$sum_array +=$array['score'];}
				$avg=@($sum_array/$count_array);
				if($count_array==0){$avg=0;$sum_array=0;}
				
			//-------------------- CAR	--------------------------------------
				
			//No photos uploaded
				$no_photos_car=mysqli_query($con,"SELECT * FROM photos_car WHERE username='$username' AND date_posted<'$dater'");
				$count_no_photos_car=mysqli_num_rows($no_photos_car); 
			//No scores of your photos
				$no_been_scored_car=mysqli_query($con,"SELECT * FROM rate_car WHERE owner='$username' AND date<'$dater'");
				$count_no_been_scored_car=mysqli_num_rows($no_been_scored_car);
			//No another's photos scored
				$no_scored_car=mysqli_query($con,"SELECT * FROM rate_car WHERE scorer='$username' AND date<'$dater'");
				$count_no_scored_car=mysqli_num_rows($no_scored_car);
			//No scored and sum 
				$sum_query_car=mysqli_query($con,"SELECT score FROM rate_car WHERE owner='$username' AND date<'$dater'");
				$count_array_car=mysqli_num_rows($sum_query_car);
				while ($array_car=mysqli_fetch_array($sum_query_car)){
				$sum_array_car +=$array_car['score'];}
				$avg_car=@($sum_array_car/$count_array_car);
				if($count_array_car==0){$avg_car=0;$sum_array_car=0;}

			//-------------------- CLOTHE	--------------------------------------
				
			//No photos uploaded
				$no_photos_clo=mysqli_query($con,"SELECT * FROM photos_clo WHERE username='$username' AND date_posted<'$dater'");
				$count_no_photos_clo=mysqli_num_rows($no_photos_clo); 
			//No scores of your photos
				$no_been_scored_clo=mysqli_query($con,"SELECT * FROM rate_clothe WHERE owner='$username' AND date<'$dater'");
				$count_no_been_scored_clo=mysqli_num_rows($no_been_scored_clo);
			//No another's photos scored
				$no_scored_clo=mysqli_query($con,"SELECT * FROM rate_clothe WHERE scorer='$username' AND date<'$dater'");
				$count_no_scored_clo=mysqli_num_rows($no_scored_clo);
			//No scored and sum 
				$sum_query_clo=mysqli_query($con,"SELECT score FROM rate_clothe WHERE owner='$username' AND date<'$dater'");
				$count_array_clo=mysqli_num_rows($sum_query_clo);
				while ($array_clo=mysqli_fetch_array($sum_query_clo)){
				$sum_array_clo +=$array_clo['score'];}
				$avg_clo=@($sum_array_clo/$count_array_clo);
				if($count_array_clo==0){$avg_clo=0;$sum_array_clo=0;}
				
			//-------------------- SOLIDARITY	--------------------------------------
				
			//No photos uploaded
				$no_photos_soli=mysqli_query($con,"SELECT * FROM photos_soli WHERE username='$username' AND date_posted<'$dater'");
				$count_no_photos_soli=mysqli_num_rows($no_photos_soli); 
			//No scores of your photos
				$no_been_scored_soli=mysqli_query($con,"SELECT * FROM rate_soli WHERE owner='$username' AND date<'$dater'");
				$count_no_been_scored_soli=mysqli_num_rows($no_been_scored_soli);
			//No another's photos scored
				$no_scored_soli=mysqli_query($con,"SELECT * FROM rate_soli WHERE scorer='$username' AND date<'$dater'");
				$count_no_scored_soli=mysqli_num_rows($no_scored_soli);
			//No scored and sum 
				$sum_query_soli=mysqli_query($con,"SELECT score FROM rate_soli WHERE owner='$username' AND date<'$dater'");
				$count_array_soli=mysqli_num_rows($sum_query_soli);
				while ($array_soli=mysqli_fetch_array($sum_query_soli)){
				$sum_array_soli +=$array_soli['score'];}
				$avg_soli=@($sum_array_soli/$count_array_soli);
				if($count_array_soli==0){$avg_soli=0;$sum_array_soli=0;}

//				$ffav=5 te siguen; $fupl=5 subidas; $fvot=0.5 valor total votos; $fcarvot=0.5 No fotos te han votado; $fotrvot=3 No tu votaste; $fotrcom=0.5 comments;$fotrperfcom=0.5 comment perfiles;				
				$ffav=5; $fupl=5; $fvot=0.5; $fcarvot=0.5; $fotrvot=3; $fotrcom=0.5;$fotrperfcom=0.5;
			$suma_fijo=$ffav*$count_no_fav_for + $fotrcom*$count_no_photos_commented+$fotrperfcom*$count_no_profiles_commented;	
			$suma_body=$fupl*$count_no_photos+$fcarvot*$count_no_been_scored+$fotrvot*$count_no_scored+$fvot*$sum_array;	
			$suma_car=$fupl*$count_no_photos_car+$fcarvot*$count_no_been_scored_car+$fotrvot*$count_no_scored_car+$fvot*$sum_array_car;
			$suma_clothe=$fupl*$count_no_photos_clo+$fcarvot*$count_no_been_scored_clo+$fotrvot*$count_no_scored_clo+$fvot*$sum_array_clo;	
			$suma_soli=$fupl*$count_no_photos_soli*3+$fcarvot*$count_no_been_scored_soli*3+$fotrvot*$count_no_scored_soli*3+$fvot*$sum_array_soli*3;
			$suma_total=$suma_fijo+$suma_body+$suma_car+$suma_clothe+$suma_soli;	
			
			//echo "--".$count_no_photos_soli."--".$count_no_been_scored_soli."--".$count_no_scored_soli."--".$sum_array_soli;
			
			
			$r4=$suma_fijo;$r5=$suma_body;$r6=$suma_car;$r7=$suma_clothe;$r8=$suma_soli;
			$r9=$suma_total;$r10=0;$r11=0;$r12=0;$r13=0;
			$r14=0;$r15=0;$r16=0;$r17=0;$r18=0;
			$r19=0;$r20=0;$r21=0;$r22=0;$r23=0;
			$r24=0;$r25=0;$r26=0;$r27=0;$r28=0;
			$r29=0;$r30=0;$r31=0;$r32=0;$r33=0;
			$r34=0;$r35=0;$r36=0;$r37=0;$r38=0;
			$r39=0;$r40=0;$r41=0;$r42=0;$r43=0;
			
			
			echo $username." -country- ".$country." -fijo- ".$suma_fijo." -body- ".$suma_body." -car- ".$suma_car." -clothe- ".$suma_clothe."  -soli- ".$suma_soli." -total- ".$suma_total."</br>";
		
			$ranking_query=mysqli_query($con,"SELECT username FROM ranking WHERE username='$username'");
			$count_ranking=mysqli_num_rows($ranking_query);
			if($count_ranking==0){ //update first day values for new user, first day. 
				mysqli_query($con,"INSERT INTO ranking VALUES ('$id','$username','$country','$r4','$r5','$r6','$r7','$r8','$r9','$r10','$r11','$r12','$r13','$r14','$r15','$r16','$r17','$r18','$r19','$r20','$r21','$r22','$r23','$r24','$r25','$r26','$r27','$r28','$r29','$r30','$r31','$r32','$r33','$r34','$r35','$r36','$r37','$r38','$r39','$r40','$r41','$r42','$r43','0','0','0','0','0','0','0','0')");
			}
			else{
				mysqli_query($con,"UPDATE ranking SET fijo_$day='$suma_fijo', body_$day='$suma_body', car_$day='$suma_car', clothe_$day='$suma_clothe', soli_$day='$suma_soli', total_$day='$suma_total' WHERE username='$username'");
			}
				
		}
		mysqli_query($con,"INSERT INTO rankingdateupdate VALUES ('','day','$dater')");
			
	}	
	
	
	
	
}	
else {	
	header("Location: index.php");
}
?>
<form action="" method="post">
<p><b>CHANGE:</b></p><br/>
	<input type="text" name="mo" id="mo" size="2" placeholder="me"> <br />
	<input type="text" name="da" id="da" size="2" placeholder="di"> <br />
	<br/><input type="submit" name="dale" value="dale"/> <br/>
</form>
	<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadTODAY" value="1.- FECHA ACTUALIZADA->TODAY"/> <br/>
<br/>
</form>
<br/>


<div class="yourscore24"><h2>Last 24 hours update: </h2><br/>
	<h3>TU PUNTUACION</h3></br>
		
 </div>
 
 <div class="yourscore365"><h2>ELEMENTOS AFECTADOS</h2><br/> 
 </br>Imagenes votadas
 </br>Imagenes comentadas
 </br>Fav de...
 </br>Like de...
 		</br>Suma fijo---------------------<?echo $suma_fijo;?>
		</br>Suma body---------------------<?echo $suma_body;?>
		</br>Suma car---------------------<?echo $suma_car;?>
		</br>Suma clothe---------------------<?echo $suma_clothe;?>
		</br>Suma soli---------------------<?echo $suma_soli;?>
		</br>Suma TOTAL---------------------<?echo $suma_total;?>
		
</div>

<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" style="background-color:green;" name="uploadYESTERDAY" value="PRIMERO TODAY -> YESTERDAY"/> <br/>
<br/>
</form>
<br/>

<?php 

if(isset($_POST['uploadYESTERDAY'])){
	$get_usenam=mysqli_query($con,"SELECT * FROM ranking WHERE id>'0'");
	
	while($row=mysqli_fetch_assoc($get_usenam)){
		$username=$row['username'];
			$fijo_today=$row['fijo_today'];
		$body_today=$row['body_today'];
		$car_today=$row['car_today'];
		$clothe_today=$row['clothe_today'];
		$soli_today=$row['soli_today'];
		$total_today=$row['total_today'];
			$fijo_total=$row['fijo_total'];
		$body_total=$row['body_total'];
		$car_total=$row['car_total'];
		$clothe_total=$row['clothe_total'];
		$soli_total=$row['soli_total'];
		$total_total=$row['total_total'];
			$fijo_varday=$fijo_today-$fijo_total;
		$body_varday=$body_today-$body_total;
		$car_varday=$car_today-$car_total;
		$clothe_varday=$clothe_today-$clothe_total;
		$soli_varday=$soli_today-$soli_total;
		$total_varday=$total_today-$total_total;
//				$fijo_=$row['fijo_'];
//		$body_=$row['body_'];
//		$car_=$row['car_'];
//		$clothe_=$row['clothe_'];
//		$total_=$row['total_'];
		mysqli_query($con,"UPDATE ranking SET fijo_total='$fijo_today', body_total='$body_today', car_total='$car_today', clothe_total='$clothe_today', soli_total='$soli_today', total_total='$total_today', 
											  fijo_yesterday='$fijo_total', body_yesterday='$body_total', car_yesterday='$car_total', clothe_yesterday='$clothe_total', soli_yesterday='$soli_total', total_yesterday='$total_total',
											  fijo_varday='$fijo_varday', body_varday='$body_varday', car_varday='$car_varday', clothe_varday='$clothe_varday', soli_varday='$soli_varday', total_varday='$total_varday' WHERE username='$username'");
		echo $username." -total today- ".$total_today."</br>";										
	}
	mysqli_query($con,"INSERT INTO rankingdateupdate VALUES ('','yes','2018-03-18 21:30:01')");
}		
?>

<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadweek" value="UPLOAD Week"/> <br/>
<br/>
</form>
<br/>

<?php 

if(isset($_POST['uploadweek'])){
	$get_usenam=mysqli_query($con,"SELECT * FROM ranking WHERE id>'0'");
	
	while($row=mysqli_fetch_assoc($get_usenam)){
		$username=$row['username'];
			$fijo_today=$row['fijo_today'];
		$body_today=$row['body_today'];
		$car_today=$row['car_today'];
		$clothe_today=$row['clothe_today'];
		$soli_today=$row['soli_today'];
		$total_today=$row['total_today'];
			$fijo_week=$row['fijo_week'];
		$body_week=$row['body_week'];
		$car_week=$row['car_week'];
		$clothe_week=$row['clothe_week'];
		$soli_week=$row['soli_week'];
		$total_week=$row['total_week'];
			$fijo_varweek=$fijo_today-$fijo_week;
		$body_varweek=$body_today-$body_week;
		$car_varweek=$car_today-$car_week;
		$clothe_varweek=$clothe_today-$clothe_week;
		$soli_varweek=$soli_today-$soli_week;
		$total_varweek=$total_today-$total_week;

		mysqli_query($con,"UPDATE ranking SET fijo_week='$fijo_today', body_week='$body_today', car_week='$car_today', clothe_week='$clothe_today', soli_week='$soli_today', total_week='$total_today', 
											  fijo_varweek='$fijo_varweek', body_varweek='$body_varweek', car_varweek='$car_varweek', clothe_varweek='$clothe_varweek', soli_varweek='$soli_varweek', total_varweek='$total_varweek'
											  WHERE username='$username'");
		echo $username." -total today- ".$total_today."</br>";										
	}
	mysqli_query($con,"INSERT INTO rankingdateupdate VALUES ('','wee','2018-03-18 21:30:01')");
}		
?>

<br/>
<form action="" method="POST" enctype="multipart/form-data">
<br/><input type="submit" name="uploadmonth" value="UPLOAD Month"/> <br/>
<br/>
</form>
<br/>

<?php 

if(isset($_POST['uploadmonth'])){
	$get_usenam=mysqli_query($con,"SELECT * FROM ranking WHERE id>'0'");
	
	while($row=mysqli_fetch_assoc($get_usenam)){
		$username=$row['username'];
			$fijo_today=$row['fijo_today'];
		$body_today=$row['body_today'];
		$car_today=$row['car_today'];
		$clothe_today=$row['clothe_today'];
		$soli_today=$row['soli_today'];
		$total_today=$row['total_today'];
			$fijo_month=$row['fijo_month'];
		$body_month=$row['body_month'];
		$car_month=$row['car_month'];
		$clothe_month=$row['clothe_month'];
		$soli_month=$row['soli_month'];
		$total_month=$row['total_month'];
			$fijo_varmonth=$fijo_today-$fijo_month;
		$body_varmonth=$body_today-$body_month;
		$car_varmonth=$car_today-$car_month;
		$clothe_varmonth=$clothe_today-$clothe_month;
		$soli_varmonth=$soli_today-$soli_month;
		$total_varmonth=$total_today-$total_month;

		mysqli_query($con,"UPDATE ranking SET fijo_month='$fijo_today', body_month='$body_today', car_month='$car_today', clothe_month='$clothe_today', soli_month='$soli_today', total_month='$total_today', 
											  fijo_varmonth='$fijo_varmonth', body_varmonth='$body_varmonth', car_varmonth='$car_varmonth', clothe_varmonth='$clothe_varmonth', soli_varmonth='$soli_varmonth', total_varmonth='$total_varmonth'
											  WHERE username='$username'");
		echo $username." -total today- ".$total_today."</br>";										
	}
	mysqli_query($con,"INSERT INTO rankingdateupdate VALUES ('','mon','2018-02-28 21:30:01')");
}		
?>

-->