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

<!--	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_allowed_head"><? echo $viaDownloadHead ?></h2>
				<p style="text-align: justify">
				<? echo $viaDownloadText ?>
				</p>
			</div>
		</div>
	</div>-->

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="licensing_datalicensing_head"><? echo $dataaccess_viaAPIHead ?></h2>
				<p style="text-align: justify">
					<? echo $dataaccess_viaAPIText ?>
				</p>
				<h3 id="licensing_datalicensing_head"><? echo $dataaccess_endpointHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_endpointText ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>