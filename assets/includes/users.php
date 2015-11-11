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

require_once('connection.php');
require_once('config.php');


$baseURL = get_serverurl(); //as defined in config.php

//USAGE: Just call this page via GET with the specific parameters:
// users.php?user=username
// users.php?friends
// users.php?addFriend=friendname
// users.php?deleteFriend=friendname
// users.php?groups

//Possible error status: 303,400,401,403,303


if(isset($_GET['avatar'])){
	if(isset($_GET['size'])) $response = get_image_request($baseURL.'/users/'.rawurlencode($_GET['avatar']).'/avatar&size='.$_GET['size']);
	else $response = get_image_request($baseURL.'/users/'.rawurlencode($_GET['avatar']).'/avatar');
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
		echo $response['response'];
	}
}

if(isset($_GET['user'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['user']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['users'])){
	$response = get_request($baseURL.'/users?limit=1000', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friends'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friend-requests-incoming'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends/incomingRequests', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friend-requests-outgoing'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends/outgoingRequests', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friend-request-accept'])){
	$friend = array("name" => ''.$_POST['acceptFriend']); 
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friend-request-decline'])){
	$friend = array("name" => ''.$_POST['declineFriend']); 
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends/declineRequest', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendsOf'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['friendsOf']).'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['addFriend'])){
	$friend = array("name" => ''.$_POST['addFriend']); 
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['deleteFriend'])){ 
	$response = delete_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends/'.rawurlencode($_POST['deleteFriend']));
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groups'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupsOf'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['groupsOf']).'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['createGroup'])){
	$group = array("name" => rawurlencode($_POST['group_name']), "description" => rawurlencode($_POST['group_description']));
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/groups',$group, true);
	if($response['status'] == 201){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['tracks'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['tracks-page'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks'.'?limit=5&page='.rawurlencode($_GET['tracks-page']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['track-number-user'])){
	////This is a workaround to get the total number of a user's tracks
	////We also need to set up our own curl request because we need the headers and we need to parse them
	//$ch = curl_init($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks'.'?limit=1');
    //curl_setopt_array($ch, array(
        //CURLOPT_HTTPHEADER  => array('X-User: '.$_SESSION['name'], 'X-Token: '.$_SESSION['password']),  
        //CURLOPT_RETURNTRANSFER  => true,
        //CURLOPT_VERBOSE     => 1,
        //CURLOPT_FOLLOWLOCATION => TRUE,
        //CURLOPT_HEADER => 1
    //));
    //$out = curl_exec($ch);
    //$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //$lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    //curl_close($ch);
    ////The request is fully returned, so split headers and body
    //list($headers, $body) = explode("\r\n\r\n", $out, 2);
    ////Put all headers into a key/value-Array so we can get the desired "Link" header later
    //$lines = explode("\r\n", $headers);
    //$parsed = array();
    //foreach($lines as $line) {
        //$colon = strpos($line, ':');
        //if($colon !== false) {
            //$name = trim(substr($line, 0, $colon));
            //$value = trim(substr($line, $colon + 1));
            ////Actually sometimes there are two "Link" Elements, we need the first one
            //if(!array_key_exists($name, $parsed)) $parsed[$name] = $value;
        //}
    //}
    ////parse the number of tracks from the "Link"-Headers
    //$num_of_tracks = 0;
    //if(array_key_exists('Link', $parsed)){
    	//$num_of_tracks = explode(">",explode( "page=", $parsed['Link'])[1])[0];	
    //}
    //$response = array("status" => $http_status, "response" => $num_of_tracks, "url" => $lastUrl);

	$response = get_request_with_headers($serverurl."/users/".rawurlencode($_SESSION['name'])."/tracks/?limit=1&page=0", true);
	
	if($response['status'] == 200){
		echo processTrackNumberResponse($response);
	}else{
		echo $response['status'];
	}
}


if(isset($_GET['track'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks/'.rawurlencode($_GET['track']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['atrack'])){
	$response = get_request($baseURL.'/tracks/'.rawurlencode($_GET['atrack']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['trackStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks/'.rawurlencode($_GET['trackStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['atrackStatistics'])){
	$response = get_request($baseURL.'/tracks/'.rawurlencode($_GET['atrackStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['allStatistics'])){
	$response = get_request($baseURL.'/statistics', false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['userStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['friendStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}


if(isset($_GET['userActivities'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/activities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendActivities'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friendActivities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['lostPassword'])){
	$changeData = array("user" => array("name" => $_POST['user'], "mail" => $_POST['email']));
	$response = post_request($baseURL.'/resetPassword', $changeData, false);

	if($response['status'] == 200){
		echo json_encode($response);
	}else{
		echo json_encode($response);
	}
}

if(isset($_GET['resetPassword'])){
	$changeData = array("user" => array("name" => $_POST['user'], "token" => $_POST['password']), "code" => $_POST['code']);

	$response = put_request($baseURL.'/resetPassword', $changeData);
	if($response['status'] == 200){
		echo json_encode($response);
	}else{
		echo json_encode($response);
	}
}

if(isset($_GET['updateUser'])){
	$changeData = array();
	$response = [];

	if (!empty($_POST['firstName'])) {
		$changeData['firstName'] = $_POST['firstName'];
	}
	if (!empty($_POST['lastName'])) {
		$changeData['lastName'] = $_POST['lastName'];
	}
	if (!empty($_POST['country'])) {
		$changeData['country'] = $_POST['country'];
	}
	if (!empty($_POST['mail'])) {
		$changeData['mail'] = $_POST['mail'];
	}
	if (!empty($_POST['gender'])) {
		$changeData['gender'] = $_POST['gender'];
	}
	if (!empty($_POST['language'])) {
		$changeData['language'] = $_POST['language'];
	}
	if (!empty($_POST['dayOfBirth'])) {
		$changeData['dayOfBirth'] = $_POST['dayOfBirth'];
	}
	if (!empty($_POST['password'])) {
		if(isset($_POST['oldPassword'])){
			if($_SESSION['password'] == $_POST['oldPassword']){
				$changeData['token'] = $_POST['password'];
				$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
			}else{
				$response['status'] = 401;
			}
		}
	}

	//$changeData = array("firstName" => ''.$_GET['firstName'], "lastName" => ''.$_GET['lastName'], "country" => ''.$_GET['country'], "gender" => ''.$_GET['gender'], "language" => ''.$_GET['language'], "dayOfBirth" => ''.$_GET['dayOfBirth']);  
	if(empty($_POST['password'])){
		$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
	}

	if($response['status'] == 204){
		if (!empty($_POST['password'])) {
			//update the session password
			error_log("Updating user password due to change");
			$_SESSION['password'] = $_POST['password'];
		}
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['updateAcceptedTermsofUse'])){
	$changeData = array("acceptedTermsOfUseVersion" => ''.$_GET['date']);
	$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}