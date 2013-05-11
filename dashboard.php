<?
include('header.php');
?>
  <script type="text/javascript">
    
    function addRecentActivities(img, id, titel){
      $('#recentActivities').append('<li class="customLi"><img src="'+img+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a></li>');
    }

    function addFriendActivities(actionImg, friendImg, id, titel){
      $('#friendActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/></li>');
    }

  </script>
  
	<div class="container rightband">
	<div class="row-fluid">
        <div class="span4">
          <h2>Recent Activities</h2>
		  <ul id="recentActivities" style="margin-bottom: 10px; overflow-y:auto">
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a></li>
              <li class="customLi"><img src="../assets/img/trophy.svg" style="height: 30px; margin-right: 10px; "/><a href="">Award: Economic driver</a></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a></li>

		  </ul>
          <p><a class="btn" href="#">View details &raquo;</a></p>
		  <p> </p>
        </div>
        <div class="span4">
          <h2>Overview</h2>
          <p>
			<pre>Uploaded Tracks:	<b>12</b>
Total Km:		<b>231</b> 
L/Km:			<b>7.5</b>
Total Costs:		<b>22 Euro</b>
Costs/Km:		<b>10 Euro</b></pre>

			
		  </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Friend Activities</h2>
		  <ul id="friendActivities" style="margin-bottom: 10px; overflow-y:auto">
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a><img src="../assets/img/dennis.png" style="height: 30px; margin-right: 10px; float:right; "/></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a><img src="../assets/img/person.svg" style="height: 30px; margin-right: 10px; float:right; "/></li>
              <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a><img src="../assets/img/person.svg" style="height: 30px; margin-right: 10px; float:right; "/></li>
              <li class="customLi"><img src="../assets/img/trophy.svg" style="height: 30px; margin-right: 10px; "/><a href="">Award: Economic driver</a><img src="../assets/img/dennis.png" style="height: 30px; margin-right: 10px; float:right;"/></li>
			  <li class="customLi"><img src="../assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="">Track 25.02.2013: 14Km</a><img src="../assets/img/person.svg" style="height: 30px; margin-right: 10px; float:right; "/></li>
		  </ul>
          <p><a class="btn" href="#">View details &raquo;</a></p>
		  <p> </p>
        </div>
      </div>

	</div>


<?
include('footer.php');
?>