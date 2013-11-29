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
	$('#myTab').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});

$(function(){ 
    $('.nav-tabs a').on('click', function (e) {
        e.preventDefault();
        if(e.currentTarget.href.indexOf('#website') != -1){
        	document.getElementById("title_image_container").style.display = 'block';
        	document.getElementById("title_image").style.backgroundImage = 'url(./assets/img/image00.jpg)';
        }else if(e.currentTarget.href.indexOf('#main') != -1){
        	document.getElementById("title_image_container").style.display = 'block';
        	document.getElementById("title_image").style.backgroundImage = 'url(./assets/img/image03.jpg)';
        }else if(e.currentTarget.href.indexOf('#behind') != -1){
        	document.getElementById("title_image_container").style.display = 'block';
        	document.getElementById("title_image").style.backgroundImage = 'url(./assets/img/image04.jpg)';
        }else if(e.currentTarget.href.indexOf('#faqs') != -1){
        	document.getElementById("title_image_container").style.display = 'none';
        }
        $(this).tab('show');
    });  
});

</script>
		
		

<header class="container" id="about-menu">
  <div class="row">

    </div>
  </div>
  <div class="subnav droid-text">
    <ul class="nav nav-pills">
      <li class="active"><a href="#main" data-toggle="tab"><? echo $about_aboutHead ?></a></li>
			<li><a href="#behind" data-toggle="tab"><? echo $about_the_people_behind_head ?></a></li>
			<li><a href="#getinvolved" data-toggle="tab"><? echo $about_gettinginvolvedHead ?></a></li>
			<li><a href="#faqs" data-toggle="tab"><? echo $about_faqHead ?></a></li>
    </ul>
  </div>
</header>


		  <div id="title_image_container" class="container rightband" style="display:block;">
   		 <div class="row-fluid">
      		<div id="title_image" class="span12" style="margin: 0; padding: 0; background-image: url(./assets/img/image03.jpg); height: 250px; width 100%; background-size: cover;">
      		</div>
      	</div>
      </div>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="main">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span6" style="text-align: center;">
							<img src="http://blogs.scientificamerican.com/media/inline/blog/Image/Citizen-Science-logo.jpg">
						</div> 
						<div class="span6" style="padding-right: 1ex;">
							<? echo $about_aboutText1 ?>
						</div>  
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">	
						<div class="span6">
						<p>  		 	
						<? echo $about_aboutText2 ?>	
						</div>
						<div class="span6" style="padding-right: 1ex">
							<img src="./assets/img/enviroCarConceptOverview.png" style="height:300px; width:487px;" alt="The architecture of envirocar" />
						</div>		
					</div> 
					   
				</div>
				<div class="container leftband">
					<div class="row-fluid">
        			<div class="span6">
        			<img class="offset3" src="./assets/img/drivedeck1.jpg" style="width:50%;" alt="An ODB II Adapter">
        			</div>
					<div class="span6">
							<p>
								<? echo $about_aboutText3 ?>
							</p>	
						</div>  
					</div>
				</div>
			</div><!--end of div id="main"-->		
			<div class="tab-pane fade in" id="behind">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span11" style="padding-right: 1ex; text-align: justify;">
							<? echo $about_the_people_behind_text ?>
						</div>  
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span11" style="padding-right: 1ex; text-align: justify;">
							<h2><span class="anchor" id="sign1"></span><? echo $about_contributors_head ?></h2>
							<? echo $about_contributors_text ?>
						</div>  
					</div>    
				</div>
			</div><!--end of div id="behind"-->	
			<div class="tab-pane fade in" id="getinvolved">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign1"></span><? echo $asACitizenHead ?></h2>
							<p>
								<? echo $asACitizenText ?>
							</p>							    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign2"></span><? echo $asAScientistHead ?></h2>
							<p>
								<? echo $asAScientistText ?>
							</p>							   
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign3"></span><? echo $asAPlannerHead ?></h2>
							<p>
								<? echo $asAPlannerText ?>
							</p>							    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign4"></span><? echo $asADeveloperHead ?></h2>
							<p>
								<? echo $asADeveloperText ?>
							</p>
						</div>    
					</div>    
				</div>
			</div><!--end of div id="website"-->
			<div class="tab-pane fade in" id="faqs">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<ul id="faqList" class="neutralList">
								<li><a href="#q1"><? echo $faq_q1 ?></a></li>		
								<li><a href="#q2"><? echo $faq_q2 ?></a></li>
								<li><a href="#q3"><? echo $faq_q3 ?></a></li>		
								<li><a href="#q4"><? echo $faq_q4 ?></a></li>
								<li><a href="#q5"><? echo $faq_q5 ?></a></li>	
							</ul>
						</div>
					</div> 
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="q1"></span><? echo $faq_q1 ?></h2>
							<p>
								<? echo $faq_a1 ?>
							</p>
						</div>
					</div>    
				</div> 
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q2"></span><? echo $faq_q2 ?></h2>
								<? echo $faq_a2 ?>  
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q3"></span><? echo $faq_q3 ?></h2>
							<p> 
								<? echo $faq_a3 ?>
							</p> 
						</div>    
					</div>    
				</div> 
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q4"></span><? echo $faq_q4 ?></h2>
							<p>
								<? echo $faq_a4 ?></p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q5"></span><? echo $faq_q5 ?></h2>
							<p> 
								<? echo $faq_a5 ?>
							</p> 
						</div>    
					</div>    
				</div>  
			</div><!--end of div id="faqs"-->   
		</div><!--end tab content-->
<?
include('footer.php');
?>
