<?php 
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



$baseURL = $serverurl; //as defined in connection.php


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