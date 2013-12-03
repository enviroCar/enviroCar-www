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

require_once('./assets/includes/authentification.php');
$logged_in = false; 
if(!is_logged_in()){
        $logged_in = false; 
        include('header-start.php');
}else{
        $logged_in = true;
        include('header.php');
}
?> 

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="dataaccess"><? echo $dataaccess_head ?></h2>
				<h3 id="data_api"><? echo $dataaccess_viaAPIHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_viaAPIText ?>
				</p>
				<h4 id="data_endpoint"><? echo $dataaccess_endpointHead ?></h4>
				<p style="text-align: justify">
					<? echo $dataaccess_endpointText ?>
				</p>
				<h4 id="data_download"><? echo $dataaccess_downloadHead ?></h4>
				<p style="text-align: justify">
				<? echo $dataaccess_downloadText ?>
				</p>
				<h3 id="data_license"><? echo $dataaccess_licenseHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_licenseText ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>