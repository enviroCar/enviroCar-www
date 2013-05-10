<?
require_once('../assets/includes/authentification.php');
if(!is_logged_in()){
	include('header-start.php');
}else{
	include('header.php');
}
?>

<div class="container rightband">
	Under construction... <br>
	here will be information about LOD and the API
</div>


<?
include('footer.php');
?>