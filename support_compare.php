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
	    <div id="collapseOne" class="accordion-body collapse">
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
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
         <a href="http://giv-cario.uni-muenster.de/working-folder/faq.php"> FAQ </a>
      </a>
    </div>
  </div>
</div>
	</div>

<h2> How to compare ur data and show statistics  .. </h2>
	</div>



  
  
  
  
  
<?
include('footer.php');
?>
