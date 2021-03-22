<?php
include("inc/header.inc.php");
		if(!isset( $_SESSION['user_login'])) {
			header("Location: index.php");
		}
	//Includes user location data to pic database
	$cit=mysqli_query($con,"SELECT * FROM users WHERE username='$username'");
	$city = mysqli_fetch_assoc($cit);
	$location=$city['country'];
	$regi=mysqli_query($con,"SELECT * FROM categories WHERE id='".$location."'");
	$regio = mysqli_fetch_assoc($regi);
	$region=$regio['master'];
	$cou=mysqli_query($con,"SELECT * FROM categories WHERE id='".$region."'");
	$coun = mysqli_fetch_assoc($cou);
	$country=$coun['master'];

if(isset($_POST['uploadpic'])){
		/*xxx*/$filtrado = test_input($_POST['model']);
	$uid = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['carbrand']);
	$uid2 = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['title']);
	$title = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['component']);
	$component = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['modelyear']);
	$modelyear = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['color']);
	$color = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['price']);
	$price = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['shop']);
	$shop = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['description']);
	$description = mysqli_real_escape_string($con,$filtrado);
		/*xxx*/$filtrado = test_input($_POST['tags']);
	$tags = mysqli_real_escape_string($con,$filtrado);
	$date_posted=date("ymdhis");

	
	if($uid==""){
		echo"</br></br> * Please, select a MODEL (or UNKNOWN)";
	}
	else{
		if($component=="0"){
			echo"</br></br> * Please, type the component of the car (or select NOT LISTED)";
		}
		else{
			
				if($modelyear=="0"){
				echo"</br></br> * Please, select a MODEL YEAR.";
				}
				else{

						if (isset($_FILES['uploadphoto'])) {
							if((@$_FILES["uploadphoto"]["size"] > 4000000)){
									echo "</br></br>Image size is bigger than 4Mb.";
								}
							else{	
								if (((@$_FILES["uploadphoto"]["type"]=="image/jpeg") || (@$_FILES["uploadphoto"]["type"]=="image/png")|| (@$_FILES["uploadphoto"]["type"]=="image/gif")) && (@$_FILES["uploadphoto"]["size"] < 3000000))
							{
								
							$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$rand_dir_name = $date_posted.(substr(str_shuffle($chars), 0, 8));
							mkdir("userdata/user_photos/photoscars/$rand_dir_name");
							
							if(file_exists ("userdata/user_photos/photoscars/$rand_dir_name/".@$_FILES["uploadphoto"]["name"]))
							{
							echo @$_FILES["uploadphoto"]["name"]." already exists";
							}
							else
							{
							move_uploaded_file (@$_FILES["uploadphoto"]["tmp_name"],"userdata/user_photos/photoscars/$rand_dir_name/".$_FILES["uploadphoto"]["name"]);
							//echo "Uploaded and stored in: userdata/user_photos/photoscars/$rand_dir_name".$_FILES["uploadphoto"]["name"])";
							$profile_pic_name=@$_FILES["uploadphoto"]["name"];
							$profile_pic_query=mysqli_query($con,"INSERT INTO photos_car VALUES ('','$uid','$uid2','$username','$date_posted','$description','http://$dominio.com/userdata/user_photos/photoscars/$rand_dir_name/$profile_pic_name','$title','$tags','$component','$modelyear','$color','$location','$region','$country','$price','$shop','no')");//
							
							
							
							
							$folder="userdata/user_photos/photoscars/$rand_dir_name/";
							$uploadimage=$folder.@$_FILES["uploadphoto"]["name"];;
							$newname=@$_FILES["uploadphoto"]["name"];
							// Set the resize_image name
$resize_image = $folder.$newname; 
$actual_image = $folder.$newname;
// It gets the size of the image
list( $width,$height ) = getimagesize( $uploadimage );

$ratico=$height/$width;

if($ratico>=0.75){
	if($height>=600){
		$height2=600;
		$width2=600/$ratico;
	}
	else{
		$height2=$height;
		$width2=$width;
	}
}
else{
	if($width>=800){
		$width2=800;
		$height2=800*$ratico;
	}
	else{
		$height2=$height;
		$width2=$width;
	}
}	
$newwidth = $width2;
$newheight = $height2;
// It loads the images we use jpeg function you can use any function like imagecreatefromjpeg
$thumb = imagecreatetruecolor( $newwidth, $newheight );
	if(exif_imagetype($uploadimage)==IMAGETYPE_JPEG){		
		$source=imagecreatefromjpeg( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg( $thumb, $resize_image, 100 );
	}
	if(exif_imagetype($uploadimage)==IMAGETYPE_GIF){		
		$source=imagecreatefromgif( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagegif( $thumb, $resize_image, 100 );
	}
	if(exif_imagetype($uploadimage)==IMAGETYPE_PNG){		
		$source=imagecreatefrompng( $actual_image );
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng( $thumb, $resize_image, 3 );
	}	
$out_image=addslashes(file_get_contents($resize_image));
							
							
							
							
							
							
							
							
							
							
							echo"</br></br> * Photo successfully uploaded! </br></br>";
							//	header ("Location:upload_photo.php");
	}
}}}}}}}
?>
<b><h2><center><i class="fa fa-camera fa-lg" aria-hidden="true"></i> UPLOAD YOUR PHOTOS - <i class="fa fa-car fa-lg" aria-hidden="true"> Car</i></center></h2></b></br>
<hr/>
<form action="" method="POST" enctype="multipart/form-data"><center>

	<br/><br/><input type="file" name="uploadphoto" /><br/><br/>
	<?php	try {
	
		$objDb= new PDO('mysql:host=mysql.hostinger.es;dbname=u437483010_bdmac','u437483010_user', 'syseSu');
		$objDb->exec('SET CHARACTER SET utf8');
	
		$sql = "SELECT * 
				FROM `catcars`
				WHERE `master` = 0 ORDER BY model ASC";
		$statement = $objDb->query($sql);
		$list = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			} catch(PDOException $e) {
			echo 'There was a problem';
			}
	?>
	<select name="carbrand" id="carbrand" class="update"><option value="">CAR BRAND *</option><?php if (!empty($list)) { ?><?php foreach($list as $row) { ?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['model']; ?></option><?php } ?><?php } ?></select> &rarr;
		<select name="model" id="model" class="update" disabled="disabled"><option value="">----</option></select>
		</br></br>	
		<script src="/js/jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="/js/core3.js" type="text/javascript"></script>		
	
	<input type="text" name="title" size="25" style="border:2px solid red;" placeholder="Photo Title... * " required="required"/><br /><br />
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
		</select><br/><br/>	
	<input type="text" name="color" size="25" style="border:2px solid red;" placeholder="Color..."/><br /><br />
	<input type="text" name="price" size="25" style="border:2px solid red;" placeholder="Price..."/><br /><br />
	<input type="text" name="shop" size="25" style="border:2px solid red;" placeholder="Shop name..."/><br /><br />
	<input type="text" name="description" size="25" style="border:2px solid red;" placeholder="Description / Specs..."/><br /><br />
	<input type="text" name="tags" size="25" style="border:2px solid red;" placeholder="Tag..."/><br /><br />
	<br/><input type="submit" class="car" name="uploadpic" value="UPLOAD IMAGE"/> <br/>
	</center>
</form> 
<br/><br/><hr/><br/>