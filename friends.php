<?php
include('header.php');
?>

  	<script type="text/javascript">
  		function addFriendToList(name){
  			$('#friendsList').append('<li class="prof_lis_sub"><div class="profi_inf"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></div></li>');
  		}

  		$.get('./assets/includes/users.php?friendsOf=<? echo $_SESSION['name'] ?>', function(data) {
	      	if(data >= 400){
	          console.log('error in getting friends');
	      	}else{
		        data = JSON.parse(data);
		        if(data.users.length > 0 ){
		        	for(i = 0; i < data.users.length; i++){
		            	addFriendToList(data.users[i].name);
		          	}
		        }
	      	}
	  	});

  	</script>
	
		<style>
		.styled-v-bar{ /* sample CSS class for a different vertical scrollbar look */
				background:	url(http://www.dynamicdrive.com/dynamicindex11/facescroll/custom-scroll-bar.png) center top no-repeat;
				width: 10px;
				margin-right: 0;
				margin-bottom: 4px;
			}
			
			.styled-v-bar ins{ /* Style for the "ins" inner element, or bottom of the scrollbar */ 
				display: block;
				background:	url(http://www.dynamicdrive.com/dynamicindex11/facescroll/custom-scroll-bar.png) center bottom no-repeat;
				width: 10px;
				height: 4px;
				position: absolute;
				top: 100%;
			}
		</style>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../assets/js/jquery.ui.touch-punch.min.js"></script>
		
		<script type="text/javascript" src="../assets/js/facescroll.js">
		/***********************************************
		* FaceScroll custom scrollbar (c) Dynamic Drive (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit http://www.dynamicdrive.com/ for this script and 100s more.
		***********************************************/
		</script>
		
		<script type="text/javascript">
			jQuery(function(){ // on page DOM load
				$('.spans6').alternateScroll({ 'vertical-bar-class': 'styled-v-bar', 'hide-bars': true });
				$('#scroo_lis').alternateScroll({ 'vertical-bar-class': 'styled-v-bar', 'hide-bars': true });	
			})
		</script>
		<div class="container rightband">
			<div class="row-fluid">  
		        <div class="spans5">
		          <h2 style="float:left"><? echo $friends ?></h2>
				  <div style="float:right; margin-top: 15px;">
				  	<input type="text" name="text" value="Search Friends"/>
				  </div>
        	</div>
		<div class="spans6" style="height:400px; padding:10px; padding-right:8px; overflow:scroll; resize:both;">
			<ul class="prof_lis" id="friendsList">	

			</ul>          
        </div>
		
		<div class="spans7">
          <h2>Friend activity</h2>
		  <div id="scroo_lis" style="width:400px;">
		  	<ul>
		  	<li class="prof_activity" style="width:300px;">
				<div class="profile_name profile_name_sub">
					<a href="">Albert Remke</a>
					<br/>
					awards economic driver today
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
				<div class="profile_name profile_name_sub">
					<a href="">Jakob </a>
					<br/>
					moving towards muenster city
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
					<div class="profile_name profile_name_sub">
					<a href="">Dennis</a>
					<br/>
					 spend 20 euro for travelling 100 km
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
			<div class="profile_name profile_name_sub">
					<a href="">Stephnie</a>
					<br/>
					 release4 gml co2 during last drive
				  </div>			
			</li>
		  </ul>
		  </div>
        </div>
      </div>

	</div>


<?
include('footer.php');
?>