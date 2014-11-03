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

	$resp = get_request_with_headers("https://envirocar.org/api/stable/tracks/?limit=1&page=0", false);
	
	processTrackNumberResponse($resp);
	
	function processTrackNumberResponse($response) {
		if ($response['status'] == 200) {
			$header_array = explode("\n", $response['header']);
			
			$header_size = count($header_array);
			for ($i = 0; $i < $header_size; ++$i) {
				if (strpos($header_array[$i], "Content-Range") === 0) {
					echo trim(substr($header_array[$i], strpos($header_array[$i], "/")+1, strlen($header_array[$i])));
					return;
				}
			}
			
			for ($i = 0; $i < $header_size; ++$i) {
				if (strpos($header_array[$i], "Link") === 0) {
					$links = explode(", ", $header_array[$i]);
					
					$links_size = count($links);
					for ($j = 0; $j < $links_size; ++$j) {
						if (strpos($links[$j], "rel=last")) {
							$pageIndex = strpos($links[$j], "page=");
							$pageEndIndex = strpos($links[$j], ">;", $pageIndex);

							echo trim(substr($links[$j], $pageIndex+5, $pageEndIndex - ($pageIndex+5)));
							return;
						}
					}

				}
			}

			echo "0";
		} else {
			echo $response['status'];
		}
	}
	
?>
