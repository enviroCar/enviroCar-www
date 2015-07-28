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

include('header.php');
require_once('assets/includes/connection.php');

$loggedInUser = $_SESSION["name"];
$user = (isset($_GET['user'])) ? $_GET['user'] : $loggedInUser;
?>

<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
      <h2 id="username"></h2>
		<span style="text-align: center; display: block">
			<img src="./assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
		</span>
    <br>
        <ul id="userInformation" class="nav nav-list" style="text-align:center"></ul>
        <ul id="badges" class="nav nav-list" style="text-align:center"></ul>
		<?
			if($user == $loggedInUser){
		?>
			<span style="text-align: center; display: block">
				<a href="javascript:deleteAccount();" class="btn btn-primary btn-small" style="margin-top: 1em">
					<? echo $deletemyaccount; ?>
				</a>
				<a href="#changeProfile" class="btn btn-primary btn-small" style="margin-top: 1em" data-toggle="modal">
					<? echo $editaccount; ?>
				</a>
			</span>
		<?
			}else{
		?>
			<span id="addAsFriendLink"></span>
		<?
            }
		?>
      </div><!--/.well -->
    </div><!--/span-->


    <div id="nofriends" style="display:none" class="span3 offset2"><? echo $user.' '.$noFriendsYet ?></div>
    <div id="comparison" class="span5">
        <div id="chart_div" style="width: 700px; height: 400px;">   
          <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none">
          </div>
        </div>
      </div>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 

  <? if($user != $loggedInUser){ ?>
    <script type="text/javascript">
      var friend = "<? echo $user?>";
      var values = [];
      var values2 = [];
      var count=0;
      var phen=[];

      $.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
        $('#loadingIndicator_graph').show();
        if(data >= 400){
            error_msg("<? echo $statisticsError ?>");
            $('#loadingIndicator_graph').hide();
        }else{
          data = JSON.parse(data);
          count=data.statistics.length;
          for(i = 0; i < data.statistics.length; i++){
            values[i]= Math.round(data.statistics[i].avg*100)/100;
            phen[i]=data.statistics[i].phenomenon.name;
          }
        }
      });

      $.get('assets/includes/users.php?friendStatistics='+friend, function(data) {
        if(data >= 400){
            if(data == 401 || data == 403) noFriend();
            else error_msg("<? echo $statisticsNotFound ?>");
            $('#loadingIndicator_graph').hide();
        }else{
          data = JSON.parse(data);
          for (h=0; h<count; h++ ){
            values2[h]=0;
          }
          for(i = 0; i < data.statistics.length; i++){ 
            for (j=0; j<count; j++ ){
            if ((data.statistics[i].phenomenon.name)==phen[j]){ 
              values2[j]= Math.round(data.statistics[i].avg*100)/100;
              break;
            }
          }
          }
          if(data.statistics.length==0){
            values2 = [0,0,0,0];
          }
          google.setOnLoadCallback(drawChart());
        }
      });


      google.load("visualization", "1", {packages:["corechart"]});

      function drawChart() {
        var data = new google.visualization.DataTable();
          data.addColumn('string','Measurement');
          data.addColumn('number', '<? echo $_SESSION['name'] ?>');
          data.addColumn('number', friend);

          data.addRows(count);
               
        for(i = 0; i < count; i++){
          if(phen[i] == 'Rpm'){
            phen[i] = phen[i]+' (100/min)';
            values[i] = values[i]/100;
            values2[i] = values2[i]/100;
          }
          data.setValue(i, 0, phen[i]);
          data.setValue(i, 1, values[i]);
          data.setValue(i, 2, values2[i]);
        }
     
        var options = {
          title: '<? echo $statistics ?>',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        $('#loadingIndicator_graph').hide();
      }
    </script>  

<? }else{ ?>
   <script type="text/javascript">
      var values = [];
      var count=0;
      var phen=[];

      $.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
        $('#loadingIndicator_graph').show();
        if(data >= 400){
            error_msg("<? echo $statisticsError ?>");
            $('#loadingIndicator_graph').hide();
        }else{
          data = JSON.parse(data);
          count=data.statistics.length;
          for(i = 0; i < data.statistics.length; i++){
            values[i]= Math.round(data.statistics[i].avg*100)/100;
            phen[i]=data.statistics[i].phenomenon.name;
          }
          google.setOnLoadCallback(drawChart());
        }
      });

      google.load("visualization", "1", {packages:["corechart"]});

      function drawChart() {
        var data = new google.visualization.DataTable();
          data.addColumn('string','Measurement');
          data.addColumn('number', '<? echo $_SESSION['name'] ?>');

          data.addRows(count);
               
        for(i = 0; i < count; i++){
          if(phen[i] == 'Rpm'){
            phen[i] = phen[i]+' (100/min)';
            values[i] = values[i]/100;
          }
          data.setValue(i, 0, phen[i]);
          data.setValue(i, 1, values[i]);
        }
     
        var options = {
          title: '<? echo $statistics ?>',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        $('#loadingIndicator_graph').hide();
      }
    </script>  


<? } ?>

    </div>
</div>

	<div class="container leftband" id="friendsgroups">
		<div class="span4">
			<h2><? echo $friends ?></h2>
			<div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
			<ul id="friends" style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">
			</ul>
		</div>
		<div class="span4">
			<h2><? echo $groups ?></h2>
			<ul id="groups" style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">
			</ul>
		<div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
	</div>
</div>
	<div class="container rightband">
	<div class="row-fluid">
        <div class="span5">
          <h2><?php echo $dashboard_activities_of; ?> <? echo $user ?></h2>
            <div id="loadingIndicator_friend_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
            </div>
		  <ul id="friendActivities" style="min-height: 93px; max-height: 400px; overflow-y:auto">
              
		  </ul>
		  <p> </p>
        </div>
		</div>
	</div>
<?
include('footer.php');
?>
