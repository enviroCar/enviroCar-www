function submitForm(user, email){
  changeData = new Object();
  changeData.user = user;
  changeData.email = email;
  var r = "";
  $.post('./assets/includes/users.php?lostPassword', changeData, function(response){
    r = response;
    if(response >= 400){
      alert("Something is wrong.");
      console.log(r);
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