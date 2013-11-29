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

//USAGE: 
//Get all groups: call GET and groups.php?groups

//Create new group:
//groups.php?createGroup and POST "group_name" and "groupe_description"
$baseURL = get_serverurl(); //as defined in config.php


if(isset($_GET['groups'])){
	$response = get_request($baseURL.'/groups/', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['group'])){
	$response = get_request($baseURL.'/groups/'.rawurlencode($_GET['group']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['createGroup'])){
	$group = array("name" => $_POST['group_name'], "description" => $_POST['group_description']);
	$response = post_request($baseURL.'/groups/', $group, true);
	if($response['status'] == 201){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupMembers'])){
	$response = get_request($baseURL.'/groups/'.rawurlencode($_GET['groupMembers']).'/members', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupActivities'])){
	$response = get_request($baseURL.'/groups/'.rawurlencode($_GET['groupActivities']).'/activities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['joinGroup'])){
	$user = array("name" => ''.$_SESSION['name']); 
	$response = post_request($baseURL.'/groups/'.rawurlencode($_GET['joinGroup']).'/members', $user, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['leaveGroup'])){ 
	$response = delete_request($baseURL.'/groups/'.rawurlencode($_GET['leaveGroup']).'/members/'.$_SESSION['name']);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['deleteGroup'])){ 
	$response = delete_request($baseURL.'/groups/'.rawurlencode($_GET['deleteGroup']));
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}



?>