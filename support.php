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
				<li><a href="#main" data-toggle="tab"><strong><? echo $main_information ?></strong></a></li>
				<li><a href="#mobile" data-toggle="tab"><strong><? echo $mobile_app ?></strong></a></li>
				<li><a href="#website" data-toggle="tab"><strong><? echo $website ?></strong></a></li>
				<li><a href="#faqs" data-toggle="tab"><strong>FAQ</strong></a></li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="main">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<ul id="mainList" class="neutralList">
								<li><a href="#what"><? echo $what_enviro ?></a></li>
								<li><a href="#how"><? echo $how_enviro ?></a></li>
								<li><a href="#phen"><? echo $phen_header ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="what"></span><? echo $what_enviro ?></h2>
							<p style="text-align: justify;">  
								<img class="offset2" src="./assets/img/enviroCar_architecture.svg" height="400" width="600" alt="The architecture of envirocar" />
								<br/>
								<? echo $enviro_description ?>
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
							<h2><span class="anchor" id="how"></span><? echo $how_enviro ?></h2>
							<p style="text-align: justify;">
								<? echo $enviro_description_detail ?>
								<br/>
								<br/>
								<img class="offset2" src="./assets/img/obd_adapter.png" height="200" width="400" alt="An ODB II Adapter">
								<br/>
								<br/>
								<? $enviro_description_detail2 ?>
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
							<h2><span class="anchor" id="phen"></span><? echo $phen_header?></h2>
							<? echo $phen_description ?>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>
						</div>  
					</div>    
				</div>
			</div><!--end of div id="main"-->
			<div class="tab-pane fade in" id="mobile">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<ul id="mobileList" class="neutralList">
								<li><a href="#reg"><? echo $how_register ?></a></li>
								<li><a href="#down"><? echo $how_download ?></a></li>
								<li><a href="#sync"><? echo $how_synchronize ?></a></li>
							</ul>
						</div> 
					</div>
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="reg"></span><? echo $registration ?></h2>
							<p style="text-align: justify;">  
								<? echo $registration_steps ?> ... <br/> .. <br/> ... <br/> .. <br/>... <br/> .. <br/>
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
							<h2><span class="anchor" id="down"></span><? echo $downloading ?></h2>
							<p style="text-align: justify;">  
								<? echo $download_steps ?> ... <br/> .. <br/> ... <br/> .. <br/>... <br/> .. <br/>
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
							<h2><span class="anchor"  id="sync"></span><? echo $synchronization ?></h2>
							<p style="text-align: justify;">  
									<? echo $synchronization_steps ?> ... <br/> .. <br/> ... <br/> .. <br/>... <br/> .. <br/>
							</p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
							</p>
						</div> 
					</div>    
				</div>
			</div><!--end of div id="mobile"-->
			<div class="tab-pane fade in" id="website">
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<ul id="websiteList" class="neutralList">
								<li><a href="#sign"><? echo $register_signin_logout ?></a></li>
								<li><a href="#compare"><? echo $how_compare_data ?></a></li>
								<li><a href="#share"><? echo $how_share_data ?></a></li>
								<li><a href="#Cookies"><? echo $why_use_cookies ?></a></li>
								<li><a href="#lang"><? echo $supported_languages ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="sign"></span><? echo $register_signin_logout ?></h2>
							<strong> <? echo $register ?> </strong> 
							<p style="text-align: justify;">
								<img class="offset2" src="./assets/img/registrationsteps.jpg" height="450" width="650" alt="Depiction: How to register"/>
								<br/>
								<? echo $description_register ?>
								<br/>
								<br/>
								<br/>
							</p>
							<strong> <? echo $signing_in ?> </strong>
							<p style="text-align: justify;">
								<img class="offset2" src="./assets/img/sign.jpg" height="450" width="600" alt="Depiction: How to sign in"/>
								<br/>
								<? echo $description_signin ?>
								<br/>
							</p>
							<strong> <? echo $logging_out ?> </strong>
							<p style="text-align: justify;">
								<img class="offset2" src="./assets/img/logout.jpg" height="200" width="350" alt="Depiction: how to log out"/>
								<br/>
								<? echo $description_logout ?>
								<br/>
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
							<h2><span class="anchor" id="compare"></span><? echo $how_compare_data ?></h2>
							<p style="text-align: justify;">  
								<? echo $comparing_steps ?>... <br/> .. <br/> ... <br/> .. <br/>... <br/> .. <br/>
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
							<h2><span class="anchor" id="share"></span><? echo $how_share_data ?></h2>
							<p style="text-align: justify;">  
								<? echo $sharing_options ?>... <br/> .. <br/> ... <br/> .. <br/>... <br/> .. <br/>
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
							<h2><span class="anchor" id="Cookies"></span><? echo $why_use_cookies ?></h2>
							<p style="text-align: justify;"> 
                             <? echo $cookies_text ?>							
								
								<a href="http://en.wikipedia.org/wiki/HTTP_cookie">http://en.wikipedia.org/wiki/HTTP_cookie</a>
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
							<h2><span class="anchor" id="lang"></span><? echo $supported_languages ?></h2>
							<p style="text-align: justify;">
								<? echo $language_text ?>
							<br/>
							<img src="./assets/img/languages.jpg" height="400" width="600" alt="Depiction: How to change languages"/><br/>
							</p>
							<p class="pull-right">
								<a href="#"><? echo $back_top ?></a>
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
								<li><a href="#q7"><? echo $faq_q7 ?></a></li>
								<li><a href="#q8"><? echo $faq_q8 ?></a></li>		
								<li><a href="#q9"><? echo $faq_q9 ?></a></li>	
								<li><a href="#q10"><? echo $faq_q10 ?></a></li>	
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
								<a href="#">Back to top</a>
							</p>
						</div>
					</div>    
				</div> 
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q2"></span><? echo $faq_q2 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a2 ?>
							</p>
							<p class="pull-right">
								<a href="#">Back to top</a>
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
								<a href="#">Back to top</a>
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
								<a href="#">Back to top</a>
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
								<a href="#">Back to top</a>
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
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>    
					</div>    
				</div>    
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q7"></span><? echo $faq_q7 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a7 ?>
							</p>
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>
					</div>    
				</div>     
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q8"></span><? echo $faq_q8 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a8 ?>
							</p>
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>    
					</div>    
				</div>    
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q9"></span><? echo $faq_q9 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a9 ?>
							</p>
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>    
					</div>    
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q10"></span><? echo $faq_q10 ?></h2>
							<p style="text-align: justify;">
								<? echo $faq_a10 ?>
							</p>
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>    
					</div>    
				</div>
			</div><!--end of div id="faqs"-->   
		</div><!--end tab content-->
<?
include('footer.php');
?>
