<?

//First: Get language from Browser:

	require_once('httplanguage/httplanguage.php');
	//get language from accept-language header
	$allowed_langs = array ('de', 'en');
	$lang = lang_getfrombrowser ($allowed_langs, 'en', null, false);

//Second: Look if BrowserChoice has been overridden By User input
if(isSet($_GET['lang'])){
	$lang = $_GET['lang'];

	if (!isset($_SESSION)) session_start();
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


include('lang_'.$lang.'.php');

?>