<?php include ( "./inc/header.inc.php"); 

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
<?php
$reg = @$_POST['reg'];
//declaring variables to prevent errors
$fn = ""; //First Name
$ln = ""; //Last Name
$un = ""; //Username
$em = ""; //Email
$em2 = ""; //Email2
$pswd = ""; //Password
$pswd2 = ""; //Password2
$d = ""; //Sign Up Date
$u_check = ""; //Check if username exist
$address = "";
//registration form

		/*xxx*/$filtrado = test_input($_POST['fname']);
	$fn = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['lname']);
	$ln = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['username']);
				$nospace=str_replace(' ', '_', $filtrado); //Evita espac en username que dan luego problemas
	$un = mysqli_real_escape_string($con,$nospace);	
		/*xxx*/$filtrado = test_input($_POST['email']);
	$em = mysqli_real_escape_string($con,$filtrado);	
		/*xxx*/$filtrado = test_input($_POST['email2']);
	$em2 = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['password']);
	$pswd = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['password2']);
	$pswd2 = mysqli_real_escape_string($con,$filtrado);
	$d = date("Y-m-d"); 
		/*xxx*/$filtrado = test_input($_POST['yearofbirth']);
	$yob = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['monthofbirth']);
	$mob = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['gender']);
	$gender = mysqli_real_escape_string($con,$filtrado);	
		/*xxx*/$filtrado = test_input($_POST['profession']);
	$profession = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['colour']);
	$country = mysqli_real_escape_string($con,$filtrado);	
		/*xxx*/$filtrado = test_input($_POST['business']);
	$busi = mysqli_real_escape_string($con,$filtrado);
			/*xxx*/$filtrado = test_input($_POST['address']);
	$address = mysqli_real_escape_string($con,$filtrado);

if (isset($reg)){
	if ($em==$em2) {
		//Check if user already exists
		$sq="SELECT username FROM users WHERE username='$un'";
		$u_check = mysqli_query($con,$sq);
		// Count the amount of rows where username = $un
		$check = mysqli_num_rows($u_check);
		//Check whether email already exists in the database
		$e_check = mysqli_query($con,"SELECT email FROM users WHERE email='$em'");
		//Count rows returned. 
		$email_check = mysqli_num_rows($e_check);
		if ($check == 0) {
			if ($email_check == 0) {
				// check all of the fields have been filled in
				if ($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2) {
					// check that passwords match
					if ($pswd==$pswd2) {
						// check the maximum length of username/first name/last name does not exceed 25 characters
						if (strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
						echo "The maximum limit for username/first name/last name is 25 characters!";//errormsg
						}
						else{
						// check the maximum length of the password does not exceed 30 characters and is not less than 5
							if (strlen($pswd)>30||strlen($pswd)<5) {
								echo "Your password must be between 5 and 30 characters long";//errormsg
							}
							else{
								//encrypt pasword and pasword2 using md5 before sending to database
								$pswd = md5($pswd);
								$pswd2 = md5($pswd2);
								$confirmcode=rand();
								$query = mysqli_query($con,"INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$d','0','$confirmcode','','$yob$mob','no','$gender','$profession','$country','')");
								$message="
									Confirm your email
									Click the link below to verify your email 
									
									http://www.$dominio.com/emailconfirm.php?u=$un&code=$confirmcode
									
									(copy and paste the link in your browser if it doesn't redirects you automatically)
								";//Funcionaba bien, anadido $dominio en vez del nombre
								mail($em,"Rankpion.com Account confirmation!!!",$message,"From:DoNotReply@Rankpion.com");
								
								if ($busi=='busi') {
									$business = mysqli_query($con,"INSERT INTO business VALUES ('','$un','1')");
								}
								else{
									$business = "";
								}
								$business; 
								
								if ($address!='') {
									$address = mysqli_query($con,"INSERT INTO robotito VALUES ('','$un')");
								}
								
								die("<br/><h2>Welcome to Rankpion! </h2> Please, go to your email to get your account activated (It can take a few minutes to receive the confirmation email, check your spam folder) <a href='/index.php'>  Sign in</a>");
							}
						}
					}
					else {
						echo "<br/> Your password does not match! <br/>";//errormsg
					}
				}
				else{
					echo "<br/> Please, fill all of the fields!";//errormsg
				}
			}
			else {
				echo "<br/> Email already taken! <br/>";//errormsg
			}
		}
		else{
			echo "<br/> Username already registered <br/>";//errormsg
		}
	}
	else {
		echo "<br/> Your Emails do not match! <br/>";//errormsg
	}
}

// User Login Code

if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {
		/*xxx*/$filtrado = test_input($_POST['user_login']);
	$user_login = mysqli_real_escape_string($con,$filtrado);
	/*xxx*/$filtrado = test_input($_POST['password_login']);
	$password_login = mysqli_real_escape_string($con,$filtrado);
	
//---$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $userr); //filter everything but numbers and letters 
//---$password_login = preg_replace('#[^A-Za-z0-9]#i', '', $passwordd); //filter everything but numbers and letters 
	$password_login_md5 = md5($password_login);
	$sql = mysqli_query($con,"SELECT username FROM users WHERE email= '$user_login' AND password= '$password_login_md5' AND activated='1' AND closed='no' LIMIT 1"); //query
	//Check for their existance
	$userCount = mysqli_num_rows($sql); //Count the number of rows returned
	if ($userCount == 1) {
		while($row = mysqli_fetch_array($sql)){ 
             $id = $row["username"];
		}
		$_SESSION["user_login"] = $id;
		header("location: 1home.php");
		exit();
	}
	else{ 	
		$sql2 = mysqli_query($con,"SELECT id FROM users WHERE email= '$user_login' AND password= '$password_login_md5' AND closed='no' LIMIT 1"); //query
		$userCount2 = mysqli_num_rows($sql2);
		if ($userCount2 == 1) {
			echo"You have to ACTIVATE your account. Open your EMAIL and click the LINK From:DoNotReply@Rankpion.com to get it activated! <br/><br/> * It may take a few minutes to get the email <br/> **(check the span folder in your email).";//errormsg
		}
		else{
			echo '<br/>'; echo '<br/>That information is incorrect, please, Check that your PASSWORD and EMAIL are correct try again:<a href="/index.php">Sign in</a>';//errormsg
			exit();
		}
	}
}


$resetpw = @$_POST['resetpw'];
if (isset($resetpw)){
		/*xxx*/$filtrado = test_input($_POST['user_login_fp']);
	$uemail_fp = mysqli_real_escape_string($con,$filtrado);
	$sql_fp = mysqli_query($con,"SELECT * FROM users WHERE email='$uemail_fp' AND activated='1' AND closed='no' LIMIT 1"); //query
	while($rowfp=mysqli_fetch_assoc($sql_fp)){
	$us=$rowfp['username'];
	}	
	$userCount_fp = mysqli_num_rows($sql_fp); //Count the number of rows returned
	if ($userCount_fp == 1) {
		$rpw=rand();
		$message2="
		You have requested a password reset.
		Click the link below to reset your password
		http://www.$dominio.com/chgpassword.php?us=$us&code=$rpw
		";
		mail($uemail_fp,"Rankpion.com PASSWORD RESET!!!",$message2,"From:DoNotReply@Rankpion.com");
		mysqli_query($con,"UPDATE users SET comodin='$rpw' WHERE email='$uemail_fp'");
		echo "You have been sent one email to the address provided. Click the link to get a new password</br>
		*Wait a few minutes for the email or repit this process again if it takes too long (Sorry!).
		";//errormsg
	}
	else{
		echo"Not results found, Please, type your email address again.";//errormsg
	}
	
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";//Missing protection here for this server variables
?>										<div id="languages" style="float:right;margin:5px 10px 5px 5px;">
											<a href="index.php?lang=en" style="padding:1px 6px 1px 1px;"><img src="languages/en.png" /></a>
										<!--	<a href="index.php?lang=es"><img src="languages/es.png" /></a>!-->
										</div></br>

					<a onclick="document.getElementById('content2').style.display=(document.getElementById('content2').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-user fa-lg" aria-hidden="true"></i> <?php echo $lang['I_MEMBER'];?> </h2></a>
						<form id='content2' style='display:none;' action="index.php" method="POST"></br>
							<center><input type="text" name="user_login" size="25" placeholder="Email address"/><br/>
							<input type="text" name="password_login" size="25" placeholder="Password"/><br/></br>
							<input type="submit" name="login" value="Login"/></center><br/>
						</form>

					<a onclick="document.getElementById('content3').style.display=(document.getElementById('content3').style.display=='none')?'block':'none';"><h2 class="hiding"><i class="fa fa-lock fa-lg" aria-hidden="true"></i> <?php echo $lang['I_FORGOTTEN'];?> </h2></a>
							<form id='content3' style='display:none;' action="index.php" method="POST"></br>
								<center><input type="text" name="user_login_fp" size="25" placeholder="Email address"><br/></br>
								<input type="submit" name="resetpw" value="Reset password"/></center><br/>
							</form>
					<h2 class='hidingborder'><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i> <?php echo $lang['I_NEW'];?> <i class="fa fa-arrow-down fa-lg" aria-hidden="true"></i></h2>
						<form id='content1' action="index.php" method="POST">
							<center><input type="text" name="fname" size="25" placeholder="First name" required="required" /><br/>
							<input type="text" name="lname" size="25" placeholder="Last name" required="required"/><br/>
							<input type="text" name="username" size="25" placeholder="Username" required="required"/><br/>
							<input type="text" name="address" size="25" placeholder="address" style='display:none;'/>
							<input type="email" name="email" size="25" placeholder="Email address" required="required"/><br/>
							<input type="email" name="email2" size="25" placeholder="Email address (repeat)" required="required"/><br/>
							<input type="password" name="password" size="25" placeholder="Password" required="required"/><br/>
							<input type="password" name="password2" size="25" placeholder="Password (repeat)" required="required"/><br/></br>
							<select name="yearofbirth" required="required"><option value="">YEAR OF BIRTH<option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010"><strong>2010</strong></option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000"><b>2000</b></option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990"><b>1990</b></option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980"><b>1980</b></option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970"><b>1970</b></option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960"><b>1960</b></option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950"><b>1950</b></option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940"><b>1940</b></option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</select>
								<b> &rarr;</b> <select name="monthofbirth" required="required"><option value="">MONTH OF BIRTH<option value="01">January</option><option value="02">Febuary</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October </option><option value="11">November</option><option value="12">December</select><br/></br>
							<select name="gender" required="required"><option value="">GENDER</option><option value="Male">Male</option><option value="Female">Female</option> </select>
							<select name="profession" required="required"><option value="">PROFESSION
								<?php
								$profession_query = mysqli_query($con,"SELECT * FROM professions"); 
									while($option=mysqli_fetch_assoc($profession_query)){
										$profess=$option['profess'];
										echo'<option value="'.$profess.'">'.$profess.'</option>';
									}
								?></select></br></br>
							<select name="country" id="country" class="update" required="required"><option value="">COUNTRY</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option><?php } ?><?php } ?> 
									</select> &rarr;
									<select name="category" id="category" class="update" disabled="disabled" required="required"><option value="">----</option></select> &rarr;
									<select name="colour" id="colour" class="update" disabled="disabled" required="required"><option value="">----</option></select></br></br>
							<select name="business" required="required"><option value="">ARE YOU A BUSINESS?</option><option value="Indi">NO, Individual User</option><option value="busi">YES, Business / Seller</option> </select></br></br></br>
							<a href="termsandconditions.html">By clicking REGISTER, you agree to our T&C</a>.</br>
							<input type="submit" name="reg" value="Register"/></center>
						</form></br><hr/>			

<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="/js/core.js" type="text/javascript"></script>



<!-- Facebook -->
<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($actual_link);?>" target="_blank" class="share-btn facebook">
    <i class="fa fa-facebook"></i>face
</a>

<?php include ( "./inc/footer.inc.php")?>