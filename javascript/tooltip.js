!function($){
    $(function(){
        if($("a[data-toggle=tooltip]").length > 0) $("a[data-toggle=tooltip]").tooltip({html: true}).click(function(e){e.preventDefault();});
        if($("a[data-toggle=popover]").length > 0) $("a[data-toggle=popover]").popover({html: true, placement: 'auto'}).click(function(e){e.preventDefault();});
    });
}(window.jQuery);
