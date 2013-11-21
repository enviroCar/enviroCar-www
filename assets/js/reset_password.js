function submitForm(){

  changeData = getFormData($('#reset-password-form'));
  $.post('./assets/includes/users.php?resetPassword', changeData, function(response){
    r = response;
    if(JSON.parse(r).status >= 400 >= 400){
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