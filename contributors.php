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

<div class="container">
	<div class="row-fluid">
        <div class="span4">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle">
          <h2>Main Sponsor 1</h2>
        </div>
        <div class="span4">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle">
          <h2>Main Sponsor 2</h2>
        </div>
        <div class="span4">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle">
          <h2>Main Sponsor 3</h2>
        </div>
    </div>
    <br>
	<div class="row-fluid">
        <div class="span3">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle" style="width:20%">
        	<h3>Sponsor</h3>
        </div>
        <div class="span3">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle" style="width:20%">
        	<h3>Sponsor</h3>
        </div>
        <div class="span3">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle" style="width:20%">
        	<h3>Sponsor</h3>
        </div>
        <div class="span3">
        	<img src="./assets/img/bootstrap-docs-readme.png" class="img-circle" style="width:20%">
        	<h3>Sponsor</h3>
        </div>
    </div>

</div>

<?php 
include('footer.php');