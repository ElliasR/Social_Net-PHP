<?php  
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang'])){
	/*xxx*/$filtrado = test_input($_GET['lang']);
	$lang = mysqli_real_escape_string($con,$filtrado);

	// register the session and set the cookie
	$_SESSION['lang'] = $lang;
	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang'])){
	
	$lang = $_SESSION['lang'];
	$lang = htmlspecialchars ($lang);
}
else if(isSet($_COOKIE['lang'])){
	$lang = $_COOKIE['lang'];
	$lang = htmlspecialchars ($lang);
}
else{
	$lang = 'en';
}
switch ($lang) {
	case 'en':
	$lang_file = 'lang.en.php'; 
	break;
	
	case 'de':
	$lang_file = 'lang.en.php'; // de en vez de en
	 break;
	
	case 'es':
	$lang_file = 'lang.en.php'; // es en vez de en
	break;
					 
	default:
	$lang_file = 'lang.en.php';
}
include_once 'languages/'.$lang_file;
?>