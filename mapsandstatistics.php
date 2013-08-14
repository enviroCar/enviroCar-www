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

//adds a new item to the gallery
function addMap(img, titel, abstrakt, id){
  $('#thumbnails').append('<li class="span3"><div class="thumbnail"><img src="'+img+'" style="width: 133; height: 200px; margin-left: 0px; "/><h3>'+titel+'</h3><p>'+abstrakt+'</p><p><a class="btn btn-primary" href="javascript:newMapWin(' + "'" + id + "', '" + titel + "'" + ')"><? echo $map ?></a> <a class="btn" href="javascript:newDetailsWin(' + "'" + id + "', '" + titel + "'" + ')"><? echo $details ?></a></p></div></li>');
}
function newMapWin(id,name) { 
window.open('http://www.arcgis.com/home/webmap/viewer.html?webmap='+id,name,'scrollbars=yes,resizable=yes, width=800,height=600');
}
function newDetailsWin(id,name) { 
window.open('http://www.arcgis.com/home/item.html?id='+id,name,'scrollbars=yes,resizable=yes, width=800,height=600');
}
   $.get('./assets/includes/maps.php?maps', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<? echo $mapsError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $mapsNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $mapsNotFound ?>")
        }
        $('#loadingIndicator_maps').hide();
      }else{
          data = JSON.parse(data);
          if(data.results.length > 0){
            for(i = 0; i < data.results.length; i++){
            	if(data.results[i].type == "Web Map"){
               	addMap('http://envirocar.maps.arcgis.com/sharing/rest/content/items/' + data.results[i].id + '/info/' + data.results[i].thumbnail, data.results[i].title, data.results[i].description ? data.results[i].description : "<? echo $noDescription ?>", data.results[i].id);
               }	
            }

          }else{
            $('#loadingIndicator_maps').hide();
          }
      }
      $('#loadingIndicator_maps').hide();
	});
</script>

<div class="container leftband" style="padding-left:20px">
	<div>
		<h2><? echo $interactivemap ?></h2>
		<div id="loadingIndicator_maps">
            <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
      </div>
      <div class="row-fluid">
		<ul id="thumbnails">
    	</ul>
    	</div>
	</div>
</div>

<?
include('footer.php');
?>