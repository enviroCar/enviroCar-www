<script type="text/javascript">
function submitForm(user, email){
  changeData = new Object();
  changeData.user = user;
  changeData.email = email;
  var r = "";
  $.post('./assets/includes/users.php?lostPassword', changeData, function(response){
    r = response;
    if(JSON.parse(r).status != 204){
      $('#password-lost-error').show();
      $('#password-lost-error').text(JSON.parse(JSON.parse(r).response).errors[0]);
    }else{
      window.location.replace("./index.php?password_reset_submitted");
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