<script type="text/javascript">
$(document).ready(function() {
	var src = "";

	$('.modal').bind('hide', function () {
		var iframe = $(this).children('div.modal-body').find('iframe'); 
		src = iframe.attr('src');
		iframe.attr('src', '');
	});

	$('.modal').bind('show', function () {
		if(src != ""){
			var iframe = $(this).children('div.modal-body').find('iframe'); 
			iframe.attr('src', src);
		};
	});
});
</script>