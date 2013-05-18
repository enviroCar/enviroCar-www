<?
include('header.php');
?>

<script type="text/javascript">
	function addRoutes(id, titel){
      $('#routes').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="route.php?id='+id+'">'+id+'</a></li>');
    }

    $.get('./assets/includes/users.php?tracks', function(data) {
    	if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          	console.log('error in getting tracks');
      	}else{
        	data = JSON.parse(data);
    		for(i = 0; i < data.tracks.length; i++){
    			addRoutes(data.tracks[i].id, "");
    		}
    	}
  	});

</script>


<div class="container rightband">
	<div class="row-fluid">
		<h2>Your Routes</h2>
        <div class="span5 offset3">
        	<ul id="routes">
        	</ul>

        </div>
    </div>
</div>




<?
include('footer.php');
?>