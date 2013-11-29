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
//Get all badges: call GET and badges.php?badges


/* Following is just a mockup while the badges are not available on the server */
$badges_json = '{
    "badges": [
        {
            "name": "supporter",
            "displayName": {
                "de": "Erster Unterstützer",
                "en": "First Supporter"
            },
            "description": {
                "de": "Einer der ersten enviroCar Unterstützer",
                "en": "One of the first enviroCar supporters"
            }
        },
	{
            "name": "contributor",
            "displayName": {
                "de": "Erster Mitwirkender",
                "en": "First Contributor"
            },
            "description": {
                "de": "Einer der ersten enviroCar Mitwirkenden",
                "en": "One of the first enviroCar contributors"
            }
        },
	{
            "name": "local_stakeholder",
            "displayName": {
                "de": "First Local Stakeholder",
                "en": "Erster Lokaler Akteur"
            },
            "description": {
                "de": "Einer der ersten lokalen Akteure.",
                "en": "One of the first lokal stakeholders"
            }
        },
	{
            "name": "regional_stakeholder",
            "displayName": {
                "de": "First Regional Stakeholder",
                "en": "Erster Regionaler Akteur"
            },
            "description": {
                "de": "Einer der ersten regionalen Akteure",
                "en": "One of the first regional stakeholdersr"
            }
        }
    ]
}
';



$baseURL = get_serverurl(); //as defined in connection.php


if(isset($_GET['badges'])){
	echo $badges_json;
	/* uncomment this when badges become available */
	/*
	$response = get_request($baseURL.'/badges/', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
	*/
}

?>