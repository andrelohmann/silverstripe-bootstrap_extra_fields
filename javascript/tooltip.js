!function($){
    $(function(){
        if($("a[data-toggle=tooltip]").length > 0) $("a[data-toggle=tooltip]").tooltip().click(function(e){e.preventDefault();});
        if($("a[data-toggle=popover]").length > 0) $("a[data-toggle=popover]").popover().click(function(e){e.preventDefault();});
    });
}(window.jQuery);