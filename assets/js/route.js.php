<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/
?>
<script type="text/javascript">

function toggleSharing(){
	if($('#share-switch').prop('checked')){
		$('#share-buttons').html("");
		$.getScript( "assets/js/jquery.share.js", function() {
			addShareButtons();
		});
	}else{
		$('#share-switch').prop('checked', true);
	}
}	

function addShareButtons(){
	$('#share-buttons').share({
        networks: ['googleplus','facebook','twitter'],
        theme: 'square'
    });
}

$(function(){
    $('body').tooltip({
      selector: '[rel=tooltip]'
    });
  });
</script>