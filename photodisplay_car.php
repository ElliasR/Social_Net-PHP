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
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> VIEW PHOTOS - <i class="fa fa-car fa-lg" aria-hidden="true"> Cars</i></center></h2></b></br>
<hr/>
<form action="rate_car.php" method="get"><center>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/JavaScript">
		function State(){ //https://www.youtube.com/watch?v=BWUka71MocU
			$('#stateddl').empty();
			$('#stateddl').append("<option>Loading......</option>");
			$('#districtddl').append("<option value='0'>-Select BRAND first-</option>");
			$.ajax({
				type:"POST",
				url:"http://rankpion.com/dropdown_car.php",	//call the php file that returns the state name after fetch from the database
				contentType:"application/json; charset=utf-8",
				dataType:"json", 	// Data type has to be json as the received data is on this format
				success: function(data){ 	// a success event fill states by using each loop
					$('#stateddl').empty();
					$('#stateddl').append("<option value='0'>-  CAR BRAND  -</option>");
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
					url:"http://rankpion.com/dropdown_car2nd.php?sid="+sid,//past the state value to the php file that returns the district names after fetch from the database
					contentType:"application/json; charset=utf-8",
					dataType:"json", // Data type has to be json as the received data is on this format
					success: function(data){ //Success event fills the district names by using each loop
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

	<span></span><select id="stateddl" name="carcatid"></select>   &rarr;   <span></span><select id="districtddl" name="carsubid"></select><br/><br/><br/>	
	<input type="text" name="username2" size="25" placeholder="Username (Photos owner)..."style="border:2px solid red;"/><br />
	<select name="favs"><option value="0">YOUR FAVS
						<?php
						$favs_query = mysqli_query($con,"SELECT * FROM friend_requests WHERE user_from='$username' and removed='n'"); 
							while($option=mysqli_fetch_assoc($favs_query)){
								$fav=$option['user_to'];
								echo'<option value="'.$fav.'">'.$fav.'</option>';
							}
						?>
						</select></br></br>
						
	<select name="component" required="required">
		<option value="0">COMPONENT *</option>
		<option value="Full car"> Full car </option>
		<option value="Frontview"> Front view </option>
		<option value="Sideview"> Side view </option>
		<option value="Rearview"> Rear view </option>
		<option value="Drawing"> Drawing </option>
		<option value="Topview"> Top view </option>
		<option value="Antenna">Antenna </option><option value="Audio equipment">Audio equipment </option><option value="Color">Color </option><option value="Doors">Doors </option><option value="Engine">Engine </option><option value="Exhaust">Exhaust </option><option value="Exterior trim">Exterior trim </option><option value="Gear lever">Gear lever </option><option value="Infotainment">Infotainment </option><option value="Instrument panel">Instrument panel </option><option value="Interior trim">Interior trim </option><option value="Mirrors">Mirrors </option><option value="Paint">Paint </option><option value="Pedals">Pedals </option><option value="Seats">Seats </option><option value="Spoilers">Spoilers </option><option value="Steering wheel ">Steering wheel  </option><option value="Stickers">Stickers </option><option value="Technologies">Technologies </option><option value="Tyres">Tyres </option><option value="Wheels">Wheels </option><option value="Windscreens">Windscreens </option><option value="OTHER">OTHER  </option>
		</select><br/><br/>	
	<select name="modelyear" required="required">
		<option value="0">MODEL YEAR *</option><option value="unknown">   Unknown</option><option value="2017">   2017</option><option value="2016">   2016</option><option value="2015">   2015</option><option value="2014">   2014</option><option value="2013">   2013</option><option value="2012">   2012</option><option value="2011">   2011</option><option value="2010">   2010</option><option value="2009">   2009</option><option value="2008">   2008</option><option value="2007">   2007</option><option value="2006">   2006</option><option value="2005">   2005</option><option value="2004">   2004</option><option value="2003">   2003</option><option value="2002">   2002</option><option value="2001">   2001</option><option value="2000">   2000</option><option value="1999">   1999</option><option value="1998">   1998</option><option value="1997">   1997</option><option value="1996">   1996</option><option value="1995">   1995</option><option value="1994">   1994</option><option value="1993">   1993</option><option value="1992">   1992</option><option value="1991">   1991</option><option value="1990">   1990</option><option value="1989">   1989</option><option value="1988">   1988</option><option value="1987">   1987</option><option value="1986">   1986</option><option value="1985">   1985</option><option value="1984">   1984</option><option value="1983">   1983</option><option value="1982">   1982</option><option value="1981">   1981</option><option value="1980">   1980</option><option value="1979">   1979</option><option value="1978">   1978</option><option value="1977">   1977</option><option value="1976">   1976</option><option value="1975">   1975</option><option value="1974">   1974</option><option value="1973">   1973</option><option value="1972">   1972</option><option value="1971">   1971</option><option value="1970">   1970</option><option value="1969">   1969</option><option value="1968">   1968</option><option value="1967">   1967</option><option value="1966">   1966</option><option value="1965">   1965</option><option value="1964">   1964</option><option value="1963">   1963</option><option value="1962">   1962</option><option value="1961">   1961</option><option value="1960">   1960</option><option value="1959">   1959</option><option value="1958">   1958</option><option value="1957">   1957</option><option value="1956">   1956</option><option value="1955">   1955</option><option value="1954">   1954</option><option value="1953">   1953</option><option value="1952">   1952</option><option value="1951">   1951</option><option value="1950">   1950</option><option value="1949">   1949</option><option value="1948">   1948</option><option value="1947">   1947</option><option value="1946">   1946</option><option value="1945">   1945</option><option value="1944">   1944</option><option value="1943">   1943</option><option value="1942">   1942</option><option value="1941">   1941</option><option value="1940">   1940</option><option value="1939">   1939</option><option value="1938">   1938</option><option value="1937">   1937</option><option value="1936">   1936</option><option value="1935">   1935</option><option value="1934">   1934</option><option value="1933">   1933</option><option value="1932">   1932</option><option value="1931">   1931</option><option value="1930">   1930</option><option value="1929">   1929</option><option value="1928">   1928</option><option value="1927">   1927</option><option value="1926">   1926</option><option value="1925">   1925</option><option value="1924">   1924</option><option value="1923">   1923</option><option value="1922">   1922</option><option value="1921">   1921</option><option value="1920">   1920</option><option value="1919">   1919</option><option value="1918">   1918</option><option value="1917">   1917</option><option value="1916">   1916</option>
		</select><br/><br/><br/>					
	<input type="text" name="tags" size="25" placeholder="Tag..."style="border:2px solid red;"/><br />
	<select name="country" id="country" class="update"><option value="">DIFFERENT REGION?</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?><?php } ?>	</select>
		<select name="category" id="category" class="update" disabled="disabled"><option value="">----</option></select>
		<select name="colour" id="colour" class="update" disabled="disabled"><option value="">----</option></select></br></br>
			<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
			<script src="/js/core.js" type="text/javascript"></script>
	<select name="daysago"><option value="0">Added anytime</option><option value="24">24 hours ago</option><option value="72">3 days ago</option><option value="168">Last week</option><option value="720">Last month</option>
	</select><br/><br/><br/>	
	<input type="submit" class="car" value="SUBMIT"></center><br/>
</form>

<hr/>
</body>
</html>
