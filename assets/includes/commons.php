<?
//This class holds all classes and methods the which are common for all pages.

//Language
require_once('language.php');



//changes the css-class of a link to "Active"
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}


?>