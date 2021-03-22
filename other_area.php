<?php
include ("./inc/header.inc.php"); 
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
try {
	
	$objDb= new PDO('mysql:host=mysql.hostinger.es;dbname=u437483010_bdmac','u437483010_user', 'syseSu');
	$objDb->exec('SET CHARACTER SET utf8');
	
	$sql = "SELECT * 
			FROM `categories`
			WHERE `master` = 0";
	$statement = $objDb->query($sql);
	$list = $statement->fetchAll(PDO::FETCH_ASSOC);
	
} catch(PDOException $e) {
	echo 'There was a problem';//errormsg
}
?></br>
<b><h2><center><i class="fa fa-list-ol fa-lg" aria-hidden="true"></i> OTHER AREAS' RANKING </center></h2></b></br><hr/></br>
<form action="#form" method="post"><center>
	<select name="country" id="country" class="update"><option value="">SELECT AREA</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?><?php } ?> 
		</select> &rarr;
		<select name="category" id="category" class="update" disabled="disabled"><option value="">----</option></select> &rarr;
		<select name="colour" id="colour" class="update" disabled="disabled"><option value="">----</option></select></br></br>
	<select name="solicat">
		<option value=""> Ordered by cat: </option>
		<option value="total"> TOTAL </option>
		<option value="body"> Body </option>		
		<option value="car"> Cars </option>		
		<option value="clothe"> Clothes </option>		
		<option value="soli"> Solidarity </option>
	</select><br/><br/>
	<select name="period" required="required">
		<option value="total"> OVERALL Ranking </option>
		<option value="yesterday"> Y'DAYs Ranking</option>		
	</select><br/><br/><br/>
	<input type="submit" name="rank" value="SUBMIT"></br></br></center>
</form>
<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="/js/core.js" type="text/javascript"></script>

<center>
<?php
if(isset($_POST['rank'])){
		/*xxx*/$filtrado = test_input($_POST['colour']);
	$colour = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['solicat']);
	$solicat = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['period']);
	$period = mysqli_real_escape_string($con,$filtrado);	
	
	if ($solicat==""){
		$solicat="total";$cates="TOTAL";$colo="black;";
	}
	if ($solicat=="total"){
		$cates="TOTAL";$colo="black";
	}
	if ($solicat=="body"){
		$cates="<i class='fa fa-child fa-lg' aria-hidden='true'></i>";$colo="green";
	}
	if ($solicat=="car"){
		$cates="<i class='fa fa-car fa-lg' aria-hidden='true'></i>";$colo="red";
	}
	if ($solicat=="clothe"){
		$cates="<img src='./img/clo.png' style='background-color:transparent; max-width:15px;max-height:15px;'>";$colo="blue";
	}
	if ($solicat=="soli"){
		$cates="<i class='fa fa-heart fa-lg' aria-hidden='true'></i>";$colo="purple";
	}
	
	if ($colour==""){
		echo "You have to select an area, please, try again!";//errormsg
	}
	else{
		if ($period=="total"){
			$aca="Overall";$plus="";
		}
		else{
			$aca="Yesterday's";$plus="+";
		}
		
		$cityquery=mysqli_query($con,"SELECT name FROM categories WHERE id='$colour'");
		$punta=mysqli_fetch_assoc($cityquery);
		$area=$punta['name'];
		echo "</br></br>".$aca." Ranking Results for the ".$cates." category in ".$area."!</br></br>
			<table style='border-collapse: collapse;max-width:200px;'>
				<tr>
					<td style='padding: 5px 15px 5px 15px;color:".$colo.";'>USER</td>
					<td style='padding: 5px 15px 5px 15px;color:".$colo.";'>$cates</td>
					<td style='padding: 5px 15px 5px 15px;color:".$colo.";'>RANK</td>
				</tr>"	
		;
		$ambrosio=$solicat.'_'.$period;
		$get_users=mysqli_query($con,"SELECT * FROM ranking WHERE country='$colour' ORDER BY $ambrosio DESC");
		$numrows=mysqli_num_rows($get_users);
		while($row=mysqli_fetch_array($get_users)){
			$id=$row['id'];
			$username=$row['username'];
			$valor=$row[$ambrosio];
			$posit=$posit+1;
			echo' 
				<tr>
					<td style="padding: 5px 15px 5px 15px;"><a style="color:'.$colo.';" href="'.$username.'">'.$username.'</a></td>
					<td style="padding: 5px 15px 5px 15px;"><span style="color:'.$colo.';" title="'.$username.' has '.$plus.$valor.' points in '.$cates.'">'.$plus.$valor.'</span></td>
					<td style="padding: 5px 15px 5px 15px;"><span style="font-size:150%;color:'.$colo.';" title="'.$username.' rank in '.$area.' for the '.$cates.' category">'.$posit.'/'.$numrows.' </span></td>
				</tr>
			';
			
		
		
		
		}
		echo "</table>";	
	}
}

?>
</center>
<hr />
</body>
</html>
