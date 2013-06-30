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
								<li><a href="#q1">Q1: How does it work?</a></li>		
								<li><a href="#q2">Q2: How to get started? What are the requirements?</a></li>
								<li><a href="#q3">Q3: Which OBD-II adapters are compatible with enviroCar?</a></li>		
								<li><a href="#q4">Q4: Is my car supported?</a></li>
								<li><a href="#q5">Q5: Why do we need Indiegogo backers?</a></li>		
								<li><a href="#q6">Q6: What’s about privacy and security?</a></li>
								<li><a href="#q7">Q7: I’m a developer and very interested in this project. Is there a way to make some further implementations?</a></li>
								<li><a href="#q8">Q8: What’s next?</a></li>		
								<li><a href="#q9">Q9: When enviroCar will be published?</a></li>	
								<li><a href="#q10">Q10: Can we ship to your country?</a></li>	
							</ul>
						</div>
					</div> 
				</div>
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span class="anchor" id="q1"></span>How does it work?</h2>
							<p style="text-align: justify;">
								By using OBD2 adapter, enviroCar is able to receive your cars data by pairing your smartphone via Bluetooth with the adapter. The smartphone app analyzes and parses the data to give you in the app and on the enviroCar these information, which you want to see.
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
							<h2><span  class="anchor" id="q2"></span>How to get started? What are the requirements?</h2>
							<p style="text-align: justify;">
								Plug your OBD2 adapter into the OnBoard Diagnostic (OBD) port of your car. Download &amp; install the app, pair it with your adapter and you’re ready to be a part of enviroCar.
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
							<h2><span  class="anchor" id="q3"></span>Which OBD-II adapters are compatible with enviroCar?</h2>
							<p style="text-align: justify;">  
								There are quite a lot OBD-II adapters for using enviroCar in different pricy ranges. You can buy these adapters on ebay, amazon or several shops. To get some infomation, you can get q quick overview. But please keep in mind, there are many (for example on ebay or amazon) which won’t work. Please have a look on some reviews. If you want to be sure, 
								Also one very important fact about OBD-II use adapters in Germany: It’s only allowed to use CE-certified OBD-II adpaters. While driving your car, the usage of adapters without a CE-certificate is permitted. If you want to be sure, to have the right adapter, contact us or make a pledge for the 199€ pledge (enviroCar device (early bird)), where the right adapter is already included.
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
							<h2><span  class="anchor" id="q4"></span>Is my car supported?</h2>
							<p style="text-align: justify;">
								Mainly there is the following rule. In the USA, all cars from 01.01.1996 have to have the OBD2 interface.
								In Europe, all new cars with an Otto-motor (using benzine) from 01.01.2001 and with the EURO-3 Norm have the OBD2 interface. For diesel vehicles from 01.01.2003 OBD-2 is supported. For trucks, the OBD2 support started with 1. January 2005
								You can also have a look here
								Alternatively we could use a picture like this: http://www.obd-2.de/faqs/obd-2/51-ist-mein-fahrzeug-obd-2-kompatibel.html 
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
							<h2><span  class="anchor" id="q5"></span>Why do we need Indiegogo backers?</h2>
							<p style="text-align: justify;">  
								By using indiegogo we want to collect 10.000€ for our future work. With your donation,
								you can be sure, that the enviroCar has a future. That you have the chance to review your and other 
								data for a long time; that you can make yourself and your city more smarter. Help us, that people and 
								students can extend and work on this project. 
								(Linked Citizen science is a topic, in which the ifgi and 52N want to do more scientific work) 
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
							<h2><span  class="anchor" id="q6"></span>What’s about privacy and security?</h2>
							<p style="text-align: justify;">
								Of course we are aware of your privacy issue. All your data will be anonymized, 
								so nobody will be able to collect sensitive, specific, person-related data about your usage. Your security is a very important 
							topic for us. By using enviroCar you haven’t worry about it. </p>
							<p class="pull-right">
								<a href="#">Back to top</a>
							</p>
						</div>    
					</div>    
				</div>    
				<div class="container leftband">
					<div class="row-fluid">
						<div class="span" style="padding-right: 1ex">
							<h2><span  class="anchor" id="q7"></span>I’m a developer and very interested in this project. Is there a way to make some further implementations?</h2>
							<p style="text-align: justify;">
								Open Source software, sparql, contact us
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
							<h2><span  class="anchor" id="q8"></span>What’s next?</h2>
							<p style="text-align: justify;">
								To start with our goal to make your place a little bit smarter, you’re the most important person in this program. The next steps include further implementation of new features and the development a working system, as well as building up the enviroCar community.
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
							<h2><span  class="anchor" id="q9"></span>When enviroCar will be published?</h2>
							<p style="text-align: justify;">
								We’re working hard on the enviroCar system. For now we’ve implemented first prototypes for app and website. Further work will be on adding more features and implementing useful functions for you.
								We plan to release enviroCar with the end of XXX. Please be patient and look for our updates.
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
							<h2><span  class="anchor" id="q10"></span>Can we ship to your country?</h2>
							<p style="text-align: justify;">
								We will ship in all countries.
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
