jQuery(document).ready(function($){
	$('.display').each(function(index){
		$(this).find('.coloum-number').html(index+1);
	});
	$('#spm_post_data tbody tr.none').each(function(index){
	   $(this).remove();
	});
});