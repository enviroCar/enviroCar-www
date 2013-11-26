<script type="text/javascript">

function toggleSharing(){
	if($('#share-switch').prop('checked')){
		$('#share-buttons').html("");
		$.getScript( "assets/js/jquery.share.js", function() {
			addShareButtons();
		});
	}else{
		$('#share-buttons').html("<a class='pop share-square share-square-googleplus-disabled'></a><a class='pop share-square share-square-facebook-disabled'></a><a class='pop share-square share-square-twitter-disabled'></a>");
	}
}	

function addShareButtons(){
	$('#share-buttons').share({
        networks: ['googleplus','facebook','twitter'],
        theme: 'square'
    });
}


</script>