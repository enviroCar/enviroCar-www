<?

//First: Get language from Browser:

	require_once('httplanguage/httplanguage.php');
	//get language from accept-language header
	$allowed_langs = array ('de', 'en');
	$lang = lang_getfrombrowser ($allowed_langs, 'en', null, false);

//Second: Look if BrowserChoice has been overridden By User input
if(isSet($_GET['lang'])){
	if ($_GET['lang'] != "" && in_array(strtolower($_GET['lang']), $allowed_langs)){
	
		$lang = $_GET['lang'];

		if (!isset($_SESSION)) session_start();
		// register the session and set the cookie
		$_SESSION['lang'] = $lang;
	}
}
else if(isSet($_SESSION['lang'])){
	$lang = $_SESSION['lang'];
}


include('lang_'.$lang.'.php');

?>