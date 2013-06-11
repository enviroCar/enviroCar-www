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
  
  
<div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">

  <div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" show >
       Main Information
      </a>
    </div>
      <div class="offset2">
	  <div class="accordion-inner" >
         <a href="http://giv-cario.uni-muenster.de/working-folder/support"> What is EnviroCar? </a>
		 </a>
      </div></div>
	   <div class="offset2">
	  <div class="accordion-inner">
        		<a href="http://giv-cario.uni-muenster.de/working-folder/howenvirocworks.php"> How EnviroCar works? </a> 

      </div></div>
 
  </div>
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        Mobile Application
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
       <div class="offset2">
	  <div class="accordion-inner">
        <a href="http://giv-cario.uni-muenster.de/working-folder/support_reg.php"> Registration</a>
      </div></div>
	   <div class="offset2">
	  <div class="accordion-inner">
        <a href="http://giv-cario.uni-muenster.de/working-folder/support_down.php"> Downloading</a>
      </div></div>
	   <div class="offset2">
	  <div class="accordion-inner">
        <a href="http://giv-cario.uni-muenster.de/working-folder/support_sync.php"> synchronization</a>
      </div></div>
    </div>
	
	
  </div>

  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
       WebSite
      </a>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
      <div class="accordion-inner">
	   <div class="offset2">
        <a href="http://giv-cario.uni-muenster.de/working-folder/support_compare.php"> Compare Your Data</a>
      </div></div>
	   <div class="offset2">
	  <div class="accordion-inner">
       <a href="http://giv-cario.uni-muenster.de/working-folder/support_share.php"> Share Your Data </a>
</div>
      </div>
    </div>
 
  </div>
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
       <a href="http://giv-cario.uni-muenster.de/working-folder/faq.php"> FAQ </a>
      </a>
    </div>
  </div>
</div>
	</div>
	 <div class="span10">
          <div class="hero-unit">
            <h2>What is EnviroCar?</h2>
			 <img class="offset2" src="./assets/img/paper_architecture.png" height="400" width="600" >
			    <p>  
				A community based system for gathering you car’s data via with your smartphone bluetooth-paired OBD2 adapter to make your city smarter.
</br></br>

				enviroCar allows you to drive more efficiently by giving you for example full insight in consumption and costs. It allows you to compare your driving statistics with friends and to enjoy competing to become the most efficient driver.
Furthermore, enviroCar enables you to contribute data collected by your car to the open enviroCar community. 
</br></br>


From those data, enviroCar generates information about traffic in your city and its emissions on our streets. The information will support e.g. urban planners to improve traffic light phases or to clarify the impact of traffic calming measures. 
</br></br>

enviroCar is the first platform to collect information about the actual emissions right when they happen because it is connected directly to the sensors in the car.
Join the community and help to make our world a little smarter, traffic less stressful, and economic driving more fun!

				
				</p>
              </div>
	
	</div>
	</div>



  
  
  
  
  
<?
include('footer.php');
?>
