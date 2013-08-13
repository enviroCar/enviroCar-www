<?
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

<script type="text/javascript">
function newWin(url,name, width, height) { 
window.open(url,name,'scrollbars=yes,resizable=yes, width=' + width + ',height='+height);
}</script>

<div class="container rightband" style="padding-left:20px">
	<div>
		<h2><? echo $interactivemap ?></h2>
		<ul class="thumbnails">
    		<li class="span4">
    		<div class="thumbnail">
    		<img src="http://envirocar.maps.arcgis.com/sharing/rest/content/items/56f3d72eb2034b4ca2975bba3b2ba0b1/info/thumbnail/ago_downloaded.png" alt="">
    		<h3>Thumbnail label</h3>
    		<p>Thumbnail caption...</p>
    		<p><a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a></p>    		
			</div>
    		</li>
    	</ul>
	</div>
</div>

<?
include('footer.php');
?>