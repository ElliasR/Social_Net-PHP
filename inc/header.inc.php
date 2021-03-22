<?php  /*xxx*/function test_input($data) {$data = trim($data);$data = stripslashes($data);$data = htmlspecialchars($data,ENT_QUOTES); return $data;}
include ( "./inc/connect.inc.php" ); 
session_start();
	include ( "./languages/lang.selection.php" ); 	
if (!isset($_SESSION["user_login"])) { //changed, in is user instead username 15min1
	$username="";
	}
	else{
	$username = $_SESSION["user_login"]; 
}
?>
<!doctype html>
<html lang="en">
<head>
	<title><?php echo $dominio;?></title>
	<meta charset="utf-8"><meta name="theme-color" content="rgb(207,181,60)" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<link rel="icon" type="image/png" href="./img/favicon.png" />
	<link rel="apple-touch-icon" href="./img/faviconapple.png" />
	<link rel="stylesheet" href="./img/font-awesome-4.6.3/css/font-awesome.min.css">
	<script src="js/main.js" type="text/javascript"> </script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/script.js" type="text/javascript"> </script>
</head>
	
<body>
	<header class="goldbackground" style="width:100%;max-width:100%;height:50px;max-height:50px;padding:0;">
		<script src="js/hideHeader.js" type="text/javascript"></script>
		<img src="./img/favicon.png" alt="Page icon" style="float:left;max-width:44px;max-height:44px;margin:3px;"/> 
		<span style="vertical-align:-15px;"><?php echo $dominio;?></span>
		<i class="fa fa-bars fa-2x" aria-hidden="true" onclick="openNav()"></i>
		
		
<?php
	$cit=mysqli_query($con,"SELECT * FROM users WHERE username='$username'");
	$city = mysqli_fetch_assoc($cit);
	$location=$city['country'];

		if(!$username){
			echo "<div id='mySidenav' class='sidenav'>
			<a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
					<ul class='clearfix'>
						<li><a href='index.php' /><i class='fa fa-user-plus fa-lg' aria-hidden='true'> </i> ".$lang['MENU_SIGNUP']."</a></li>
						<li><a href='index.php' /><i class='fa fa-user fa-lg' aria-hidden='true'> </i> ".$lang['MENU_SIGNIN']."</a></li>
						<li><a href='contactus.php' /><i class='fa fa-envelope fa-lg' aria-hidden='true'> </i> ".$lang['MENU_CONTACT']."</a></li>
						<li><a href='help.php' /><i class='fa fa-info-circle fa-lg' aria-hidden='true'> </i> ".$lang['MENU_HELP']."</a></li>
					</ul>
			</div>";
		}
		else{
			echo '<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
					<ul class="clearfix">
					<li><a href="1home.php" /><i class="fa fa-user-secret fa-lg" aria-hidden="true"></i>  '.$lang['MENU_HOME'].'</a></li>
					<li><a href="'.$username.'" /><i class="fa fa-user fa-lg" aria-hidden="true"></i>  '.$lang['MENU_PROFILE'].'</a></li>
					<li><a href="account_settings.php" /><i class="fa fa-cog fa-lg" aria-hidden="true"></i>  '.$lang['MENU_SETTINGS'].'</a></li>
					<li>
						<a href="#" /><i class="fa fa-camera fa-lg" aria-hidden="true"></i>  '.$lang['MENU_UPLOAD'].'  + <i class="fa fa-caret-down" aria-hidden="true"></i></a>
						<ul>
							<li><a style="border-style: dotted;border-color:green;" href="upload_photo_body.php" /><i class="fa fa-child" aria-hidden="true"></i>  '.$lang['MENU_BODY'].' +</a></li>
							<li><a style="border-style: dotted;border-color:red;" href="upload_photo_cars.php" /><i class="fa fa-car" aria-hidden="true"></i>  '.$lang['MENU_CAR'].' +</a></li>
							<li><a style="border-style: dotted;border-color:blue;" href="upload_photo_clothes.php" /><img src="./img/clo.png" style="background-color:transparent; max-width:15px;max-height:15px;"/>  '.$lang['MENU_CLOTHES'].' +</a></li>
							<li><a style="border-style: dotted;border-color:purple;" href="upload_photo_soli.php" /><i class="fa fa-heart" aria-hidden="true"></i>  '.$lang['MENU_SOLI'].' +</a></li>
						</ul>
					</li>
					<li>
						<a href="#" /><i class="fa fa-search fa-lg" aria-hidden="true"></i>  '.$lang['MENU_POOL'].'  <i class="fa fa-caret-down" aria-hidden="true"></i></a>
						<ul>							
							<li><a style="border-style: solid;border-color:green;" href="photodisplay_body.php" /><i class="fa fa-child" aria-hidden="true"></i> '.$lang['MENU_BODY'].' <i class="fa fa-search" aria-hidden="true"></i></a></li>
							<li><a style="border-style: solid;border-color:red;" href="photodisplay_car.php" /><i class="fa fa-car" aria-hidden="true"></i>  '.$lang['MENU_CAR'].' <i class="fa fa-search" aria-hidden="true"></i></a></li>
							<li><a style="border-style: solid;border-color:blue;" href="photodisplay_clothe.php" /><img src="./img/clo.png" style="background-color:transparent; max-width:15px;max-height:15px;"/>  '.$lang['MENU_CLOTHES'].' <i class="fa fa-search" aria-hidden="true"></i></a></li>
							<li><a style="border-style: solid;border-color:purple;" href="photodisplay_soli.php" /><i class="fa fa-heart" aria-hidden="true"></i>  '.$lang['MENU_SOLI'].' <i class="fa fa-search" aria-hidden="true"></i></a></li>
						</ul>
					</li>
					
					<li><a href="logout.php" /><i class="fa fa-power-off fa-lg" aria-hidden="true"></i>   '.$lang['MENU_LOGOUT'].'</a></li>
					
										<li>
						<a href="#" /> <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i></a>
						<ul>							
						<li><a href="contactus.php" /><i class="fa fa-envelope fa-lg" aria-hidden="true"> </i> '.$lang["MENU_CONTACT"].'</a></li>
						<li><a href="help.php" /><i class="fa fa-info-circle fa-lg" aria-hidden="true"> </i> '.$lang["MENU_HELP"].'</a></li>
						</ul>
					</li>
					
					
					
				</ul></br>
			</div>';
				}
				?>		
		

		
		
		
		
	</header>
	<main>
		