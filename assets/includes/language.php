<?php
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*/


//First: Get language from Browser:

	require_once('httplanguage/httplanguage.php');
	//get language from accept-language header
	$allowed_langs = array ('de', 'en');
	$lang = lang_getfrombrowser ($allowed_langs, 'en', null, false);

//Second: Look if BrowserChoice has been overridden By User input, but validate the input!
if(isSet($_GET['lang'])){
	if ($_GET['lang'] != "" && in_array(strtolower($_GET['lang']), $allowed_langs)){
	
		$lang = $_GET['lang'];//if input is valid

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