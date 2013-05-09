<?
include('header-start.php');
?>
  
    <script type="text/javascript">

      //Sending the credentials to the authentification page
      function login(){
        if($('#login_name').val() === ''){
          alert("Invalid Email");
        }
        else if($('#login_password').val() === ''){
          alert('Password cannot be empty');
        }else{
          $.post('../assets/includes/authentification.php?login', {name: $('#login_name').val(), password: $('#login_password').val()}, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "dashboard.php";
              }else{
                toggle_visibility("login_fail");
              }
            });
        }
      }
    </script>


  <div class="container leftband">
    <div class="row-fluid">
      <div class="span6">
        <h1>car.io</h1>
        <p>Here goes the eyecatching marketing slogan!.<br> Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui..</p>
      </div>
      <div class="span6">
            <h2 class="form-signin-heading">Please sign in</h2>
            <input type="text" id="login_name" class="input-block-level" placeholder="User name">
            <input type="password" id="login_password" class="input-block-level" placeholder="Password">
            <button class="btn btn-large btn-primary" onclick="login()">Sign in</button> 
            <button class="btn btn-large btn-primary" onclick="window.location.href='registration.php'">Register</button>
      </div>
    
    </div>
  </div> <!-- /container -->

	<div class="container rightband">
	<div class="row-fluid">
        <div class="span4">
          <h2>Keep track over your Costs</h2>
          <p>car.io helps you to automatically calculate your gas costs.</p>
       </div>
        <div class="span4">
          <h2>Watch our Video!</h2>
        </div>
        <div class="span4">
          <h2>Be a Citizen Scientist!</h2>
          <p>Help the world become a better place by sharing your data with scientists from all over the world! Or use existing data for your own research!</p>
        </div>
      </div>

	</div>

	<div class="container leftband">
      <!-- START THE FEATURETTES -->


      <div class="featurette">
        <img class="featurette-image pull-right" src="../assets/img/examples/browser-icon-chrome.png">
        <h2 class="featurette-heading">enviroCar <span class="muted">Make our cities smarter!</span></h2>
        <p class="lead">This is a community, it's an app and it's a website.<br> enviroCar is our contribution to a smarter world.<br> We will generate knowledge about car traffic and its emissions on our streets and we will raise awareness of environmental consequences of our driving behaviour.</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <img class="featurette-image pull-left" src="../assets/img/examples/browser-icon-firefox.png">
        <h2 class="featurette-heading">How does it work? <span class="muted">Three steps to become a citizen scientist</span></h2>
        <p class="lead">
          <ul>
            <li>Connect your OBD2 adapter to your car</li>
            <li>Download the enviroCar App</li>
            <li>Drive & Share</li>
          </ul>
        </p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <img class="featurette-image pull-right" src="../assets/img/examples/browser-icon-safari.png">
        <h2 class="featurette-heading">And lastly, this one. <span class="muted">Checkmate.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->
	</div>

  <?
  include('footer.php');
  ?>