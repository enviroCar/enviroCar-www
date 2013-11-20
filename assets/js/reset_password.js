function submitForm(){

  changeData = getFormData($('#reset-password-form'));
  $.post('./assets/includes/users.php?resetPassword', changeData, function(response){
    r = response;
    if(response >= 400){
      alert("Something is wrong.");
      console.log('error');
    }else{
      alert("Success!");
      location.reload(true);
      console.log('changed');
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