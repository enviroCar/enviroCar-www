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
//Sending the credentials to the authentification page
function change_profil(){
if($('#newmail').val() === ''){
alert("Invalid Email");
}else if($('#newname').val() === ''){
alert('Nickname cannot be empty');
}
else if($('#newpassword').val() === ''){
alert('Password cannot be empty');
}
else if($('#newpassword2').val() === ''){
alert('Password cannot be empty');
}else{
if($('#newpassword').val() != $('password2').val()){
alert('Passwords are not identic');
}else{
$.post('./assets/includes/authentification.php?change_profile', {email: $('#newmail').val(), password: $('#newpassword').val(), name: $('#newname').val()},

function(response){
if(response === 'status:ok'){
window.location.href = "index.php?registration_successful";
}else{
toggle_visibility('registration_fail');
}
});
}
}
}
</script>


<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <img src="./assets/img/user.jpg" align="center" style="height: 100px; margin-right: 100px; "/>
          <li class="nav-header">community</li>
          <li><a href="#">My Friends</a></li>
          <li><a href="#">My Groups</a></li>
			    <li class="nav-header">My Car.io</li>
          <li><a href="#">My Tracks</a></li>
			    <li><a href="#">Export</a></li>
        </ul>
      </div><!--/.well -->
    </div><!--/span-->
	 
	 
    <div class="span3 offset=2 "> 
	<h3 class="form-signin-heading">Change your profile:</h3>
		current user name: <?php echo $_SESSION['name']; ?> 
        <input id="name" type="text" class="input-block-level" placeholder="Please enter new name">
        current password: <!--<?php echo $_SESSION['password']; ?> -->
		<input id="password1"type="text" class="input-block-level" placeholder="Please enter new password">
       <br></br>
		<input id="password2"type="text" class="input-block-level" placeholder="Please enter new password again">
		current email: <?php echo $_SESSION['mail']; ?> 
		<input id="email" type="text" class="input-block-level" placeholder="Please enter new email">
		<button class="btn btn-large btn-primary" type="submit" onclick="change_profil"()>Save settings</button>
      </form>
	  </div>
		

    </div>
  </div>
  
  	<footer>
		<div class="container leftband">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2013 enviroCar &middot; <a href="#">Terms</a></p>
		</div>
	</footer>

		  