<?
include('header.php');
?>

<script type="text/javascript">
	function addRoutes(id, name, date){
      $('#routes').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="route.php?id='+id+'">'+name+'</a><br><div>Created: '+date+'</div></li>');
    }

    $.get('./assets/includes/users.php?tracks', function(data) {
    	if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          	console.log('error in getting tracks');
      	}else{
        	data = JSON.parse(data);
    		for(i = 0; i < data.tracks.length; i++){
    			addRoutes(data.tracks[i].id, data.tracks[i].name, convertToLocalTime(data.tracks[i].modified));
    		}
    	}
  	});

  	function convertToLocalTime(serverDate) {
	    var dt = new Date(Date.parse(serverDate));
	    var localDate = dt;

	    var gmt = localDate;
	        var min = gmt.getTime() / 1000 / 60; // convert gmt date to minutes
	        var localNow = new Date().getTimezoneOffset(); // get the timezone
	        // offset in minutes
	        var localTime = min - localNow; // get the local time

	    var dateStr = new Date(localTime * 1000 * 60);
		var d = dateStr.getDate();
	    var m = dateStr.getMonth() + 1;
	    var y = dateStr.getFullYear();
	    return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
	}

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