<?
include('header.php');
?>

<script type="text/javascript">

  function deleteAccount(){
    if(confirm("Are you sure you want to delete your account? This can't be undone!")){
        console.log("blub");
        $.post('../assets/includes/authentification.php?delete', {delete: true }, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "index.php?deleted";
              }else{
                alert("Deletion has failed. Please try again");
              }
      });
    }
    else{
      console.log("bla");
    }
  }

</script>
 
<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <img src="../assets/img/user.jpg" align="center" style="height: 100px; margin-right: 100px; "/>
          <li class="nav-header">community</li>
          <li><a href="#">My Friends</a></li>
          <li><a href="#">My Groups</a></li>
			    <li class="nav-header">My enviroCar</li>
          <li><a href="#">My Tracks</a></li>
			    <li><a href="#">Export</a></li>
        </ul>
      </div><!--/.well -->
    </div><!--/span-->
    
    <div class="span5 offset2">       		
      <br>Username:		<b><?echo $_SESSION['name']; ?></b> </br>
      <br>Email:			<b><?echo $_SESSION['mail']; ?></b></br>
      <br></br>
      <p><a href="" class="btn btn-primary btn-large">Change profile &raquo;</a><a href="javascript:deleteAccount();" class="btn btn-primary btn-large">Delete my Account &raquo;</a></p>
    </div>
  </div>
</div>
		  
<?
include('footer.php');
?>
		  
         
        
        

     

     
	  


    

