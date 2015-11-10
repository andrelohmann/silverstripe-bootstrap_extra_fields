(function ($) {
	
	var keepAlive = setInterval(function(){
		$.get($(":input.keep-alive-field").first().data('link'), function(data){
			console.log(data);
		});
	}, 60000);
	
})(jQuery);