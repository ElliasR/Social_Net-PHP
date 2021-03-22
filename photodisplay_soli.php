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
?>
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> VIEW PHOTOS - <i class="fa fa-heart fa-lg" aria-hidden="true"> Solidarity</i></center></h2></b></br>
<hr/>
<form action="rate_soli.php" method="get"><center>
	<select name="solicat" required="required">
			<option value="0"> SOLIDARITY CATEGORY* </option>
			<option value="02"> Charities </option>		
			<option value="04"> Donations </option>		
			<option value="06"> Events </option>		
			<option value="08"> Fundations </option>
			<option value="10"> Honorable Actions </option>
			<option value="12"> Picture </option>
			<option value="14"> Research </option>
			<option value="16"> Sponsors </option>
			<option value="18"> Other... </option>
	</select><br/><br/><br/>
	<input type="text" name="username2" size="25" placeholder="Username (Photos owner)..." style="border:2px solid purple;"/><br /><br />
	<select name="favs"><option value="0">YOUR FAVS
		<?php
			$favs_query = mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$username' and removed='n'"); 
			while($option=mysqli_fetch_assoc($favs_query)){
				$fav=$option['user_to'];
				echo'<option value="'.$fav.'">'.$fav.'</option>';
			}
		?>
	</select></br></br><br/>

	<input type="text" name="tags" size="25" placeholder="Tag..." style="border:2px solid purple;"/><br /><br />
	<select name="gender"><option value="0">GENDER</option><option value="Female">Female</option><option value="Male">Male</option></select></br></br>
	<select name="country" id="country" class="update"><option value="">DIFFERENT REGION?</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?><?php } ?>	</select>
		<select name="category" id="category" class="update" disabled="disabled"><option value="">----</option></select>
		<select name="colour" id="colour" class="update" disabled="disabled"><option value="">----</option></select></br></br>
	<select name="daysago">
		<option value="0">Added anytime</option>
		<option value="24">24 hours ago</option>
		<option value="72">3 days ago</option>
		<option value="168">Last week</option>
		<option value="720">Last month</option>
	</select><br/><br/><br/>
	<input type="submit" class="soli" value="SUBMIT"></center>
</form><br/>
<hr/>
<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="/js/core.js" type="text/javascript"></script>
</body>
</html>
