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
?>
<script type="text/javascript">
function submitForm(){

  changeData = getFormData($('#reset-password-form'));
  $.post('./assets/includes/users.php?resetPassword', changeData, function(response){
    r = response;
    if(JSON.parse(r).status != 204){
      $('#password-reset-error').show();
      $('#password-reset-error').text(JSON.parse(JSON.parse(r).response).errors[0]);
    }else{
      window.location.replace("./index.php?password_resetted");
    }
    console.log(response);
  });

}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
      if(n['value'] !== '') indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
  }
  </script>