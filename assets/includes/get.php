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


if(isset($_GET['url'])){
	$host = parse_url($_GET['url'], PHP_URL_HOST);
	if($host == 'envirocar.org'){
		if(isset($_GET['auth'])){
			$response = get_request($_GET['url'], $_GET['auth']);
		}else{
			$response = get_request($_GET['url'], false);
		}
		if($response['status'] == 200){
			echo $response['response'];
		}else{
			echo $response['status'];
		}
	}
}

if(isset($_GET['redirectUrl'])){
	$host = parse_url($_GET['redirectUrl'], PHP_URL_HOST);
	//if($host == 'envirocar.org'){
		if(isset($_GET['auth'])){
			$response = get_request_no_follow($_GET['redirectUrl'], $_GET['auth']);
		}else{
			$response = get_request_no_follow($_GET['redirectUrl'], false);
		}
		if($response['status'] == 200 || $response['status'] == 302 || $response['status'] == 307){
			header('Location:'.$response['url']);
		}else{
			echo $response['status'];

		}
	//}
}




