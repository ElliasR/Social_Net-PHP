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
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> VIEW PHOTOS - <i class="fa fa-child fa-lg" aria-hidden="true"> Body</i></center></h2></b></br>
<hr/>
<form action="rate_body.php" method="get"><center>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/JavaScript">
			function State(){ //https://www.youtube.com/watch?v=BWUka71MocU
				$('#stateddl').empty();
				$('#stateddl').append("<option>Loading......</option>");
				$('#districtddl').append("<option value='0'>-Select CAT first-</option>");
				$.ajax({
					type:"POST",
					url:"http://rankpion.com/dropdown_body.php",	
					contentType:"application/json; charset=utf-8",
					dataType:"json", 	
					success: function(data){ 	
						$('#stateddl').empty();
						$('#stateddl').append("<option value='0'>-BODY CATEGORY-</option>");
						$.each(data,function(i,item){
							$('#stateddl').append('<option value="'+ data[i].id +'">'+ data[i].name+'</option>');
						});
					},
					complete: function(){
					}
				});
				} 

				function District(sid){
					$('#districtddl').empty();
					$('#districtddl').append("<option>Loading......</option>");
					$.ajax({
						type:"POST",
						url:"http://rankpion.com/dropdown_body2nd.php?sid="+sid,
						contentType:"application/json; charset=utf-8",
						dataType:"json", 
						success: function(data){ 
							$('#districtddl').empty();
							$('#districtddl').append("<option value='0'>ALL</option>");
							$.each(data,function(i,item){
								$('#districtddl').append('<option value="'+ data[i].id +'">'+ data[i].name+'</option>');
							});
						},
						complete: function(){
						}
					});
				} 

				$(document).ready(function(){
					State();	//Call state fuction on the page load
					$("#stateddl").change(function(){ //On change function of the state dropdown pass the selected value of the state to the district function
						var stateid = $("#stateddl").val();
						District(stateid);
				});
			});
		</script>

	<span></span><select id="stateddl" name="bodycatid"></select>   &rarr;   <span></span><select id="districtddl" name="bodysubid"></select><br /><br />
	<input type="text" name="username2" size="25" placeholder="Username (Photos owner)..." style="border:2px solid green;"/><br />
	<select name="favs"><option value="0">YOUR FAVS
						<?php
						$favs_query = mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$username' and removed='n'"); 
							while($option=mysqli_fetch_assoc($favs_query)){
								$fav=$option['user_to'];
								echo'<option value="'.$fav.'">'.$fav.'</option>';
							}
						?>
						</select></br></br>

	<input type="text" name="tags" size="25" placeholder="Tag..." style="border:2px solid green;"/><br />
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
	</select><br/><br/>
	<input type="submit" class="body" value="SUBMIT"></center>
</form><br/>
<hr/>

<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="/js/core.js" type="text/javascript"></script>
</body>
</html>
