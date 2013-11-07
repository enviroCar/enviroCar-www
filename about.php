<?
require_once('./assets/includes/authentification.php');

$logged_in = false; 
if(!is_logged_in()){
	$logged_in = false; 
	include('header-start.php');
}else{
	$logged_in = true;
	include('header-start.php');
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

		<div class="tabbable" style="text-align: center;">
			<ul id="myTab" class="nav nav-tabs" style="width: 85%; margin: auto;">
				<li><a href="#main" data-toggle="tab"><strong><? echo $about_aboutHead ?></strong></a></li>
				<li><a href="#behind" data-toggle="tab"><strong><? echo $about_the_people_behind_head ?></strong></a></li>
				<li><a href="#website" data-toggle="tab"><strong><? echo $about_gettinginvolvedHead ?></strong></a></li>
				<li><a href="#faqs" data-toggle="tab"><strong><? echo $about_faqHead ?></strong></a></li>
			</ul>
		</div>		
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
						<div class="span11" style="padding-right: 1ex; text-align: justify;">
							<? echo $about_aboutText1 ?>
						</div>  
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">	
						<div class="span6">
						<p style="text-align: justify;">  		 	
						<? echo $about_aboutText2 ?>	
						</div>
						<div class="span5" style="padding-right: 1ex">
							<img src="./assets/img/enviroCarConceptOverview.png" style="height:300px; width:487px;" alt="The architecture of envirocar" />
						</div>		
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
        			<div class="span5">
        			<img class="offset3" src="./assets/img/drivedeck1.jpg" style="width:50%;" alt="An ODB II Adapter">
        			</div>
					<div class="span6">
							<p style="text-align: justify;">
								<? echo $about_aboutText3 ?>
							</p>	
						<p class="pull-right">
							<a href="#"><? echo $back_top ?></a>
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
			</div><!--end of div id="behind"-->	
			<div class="tab-pane fade in" id="website">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign1"></span><? echo $asACitizenHead ?></h2>
							<p style="text-align: justify;">
								<? echo $asACitizenText ?>
							</p>							
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign2"></span><? echo $asAScientistHead ?></h2>
							<p style="text-align: justify;">
								<? echo $asAScientistText ?>
							</p>							
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign3"></span><? echo $asAPlannerHead ?></h2>
							<p style="text-align: justify;">
								<? echo $asAPlannerText ?>
							</p>							
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign4"></span><? echo $asADeveloperHead ?></h2>
							<p style="text-align: justify;">
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
							<p style="text-align: justify;">
								<? echo $faq_a1 ?>
							</p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>
						</div>
					</div>    
				</div> 
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q2"></span><? echo $faq_q2 ?></h2>
								<? echo $faq_a2 ?>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q3"></span><? echo $faq_q3 ?></h2>
							<p style="text-align: justify;"> 
								<? echo $faq_a3 ?>
							</p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>   
						</div>    
					</div>    
				</div> 
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q4"></span><? echo $faq_q4 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a4 ?></p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>    
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q5"></span><? echo $faq_q5 ?></h2>
							<p style="text-align: justify;"> 
								<? echo $faq_a5 ?>
							</p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>  
						</div>    
					</div>    
				</div>  
			</div><!--end of div id="faqs"-->   
		</div><!--end tab content-->
<?
include('footer.php');
?>
