<?php
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
        <div class="spans5">
          <h2 style="float:left">Group </h2>
		  <div style="float:right; margin-top: 15px;">
		  	<input type="text" name="text" value="Search Friends"/>
		  </div>
        </div>
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
		<div class="spans6" style="height:400px; padding:10px; padding-right:8px; overflow:scroll; resize:both;">
			<ul class="prof_lis">	
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">IFGI</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Muenster City</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">German Riders</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Economic Drivers</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Envirocar</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">classic drive</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Safe route</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Fast rider</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Benz riders</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Economic car</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Youth drive</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">UOM</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
				
				
				<li class="prof_lis_sub">
					<div class="profi_inf">
						<div style="float:left;">
							<img src="assets/img/Purnima Dasgupta.png"/>
						</div>
						<div style="float:left;">
							<div class="profile_name">
								<a href="">Rider</a>
								<br/>
								muenster
							</div>
						</div>
					</div>
				</li>
			</ul>          
        </div>
		
		<div class="spans7">
          <h2>Group activity</h2>
		  <div id="scroo_lis" style="width:400px;">
		  	<ul>
		  	<li class="prof_activity" style="width:300px;">
				<div class="profile_name profile_name_sub">
					<a href="">IFGI</a>
					<br/>
					Economic Car award of the year
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
				<div class="profile_name profile_name_sub">
					<a href="">Youth Drive </a>
					<br/>
					Enviro car at muenster city from berlin
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
					<div class="profile_name profile_name_sub">
					<a href="">Fast Riders</a>
					<br/>
					 Drive safe and help society
				  </div>
			</li>
			<li class="prof_activity" style="width:300px;">
			<div class="profile_name profile_name_sub">
					<a href="">UOM</a>
					<br/>
					 Environment awarness in fuel consumption
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