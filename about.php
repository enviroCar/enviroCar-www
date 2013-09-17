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
	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	})
</script>

		<div class="tabbable" style="text-align: center;">
			<ul id="myTab" class="nav nav-tabs" style="width: 85%; margin: auto;">
				<li><a href="#main" data-toggle="tab"><strong><? echo $about_aboutHead ?></strong></a></li>
				<li><a href="#website" data-toggle="tab"><strong><? echo $about_gettinginvolvedHead ?></strong></a></li>
				<li><a href="#faqs" data-toggle="tab"><strong><? echo $about_faqHead ?></strong></a></li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="main">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<? echo $about_aboutText1 ?>
						</div>  
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<p style="text-align: justify;">  
								<img class="offset2" src="./assets/img/enviroCarConceptOverview.png" height="400" width="600" alt="The architecture of envirocar" />
								<br/>								
							</p>	
							<? echo $about_aboutText2 ?>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>
						</div>  
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
        			<div class="span4">
        			<img class="offset3" src="./assets/img/drivedeck1.jpg" width="60%" alt="An ODB II Adapter">
        			</div>
					<div class="span6">
							<p style="text-align: justify;">
								<? echo $about_aboutText3 ?>
							</p>
						</div>  
					</div>
				</div>
			</div><!--end of div id="main"-->		
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
								<li><a href="#q6"><? echo $faq_q6 ?></a></li>
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
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q6"></span><? echo $faq_q6 ?></h2>
							<p style="text-align: justify;"> 
								<? echo $faq_a6 ?>
							</p>
						</div>    
					</div>    
				</div>   
			</div><!--end of div id="faqs"-->   
		</div><!--end tab content-->
<?
include('footer.php');
?>
