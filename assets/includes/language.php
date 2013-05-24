<?
if (!isset($_SESSION)) session_start();

if(isSet($_GET['lang'])){
	$lang = $_GET['lang'];

	// register the session and set the cookie
	$_SESSION['lang'] = $lang;

	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang'])){
	$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang'])){
	$lang = $_COOKIE['lang'];
}
else{
	$lang = 'en';
}



include('lang_'.$lang.'.php');

?>