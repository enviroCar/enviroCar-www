<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
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
			<div class="span11">				
				<?echo $terms_general; ?>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>