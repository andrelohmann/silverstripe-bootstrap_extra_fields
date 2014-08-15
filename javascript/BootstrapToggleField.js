(function ($) {
    $('.BootstrapToggleFieldContainer .togglefield-checkbox-horizontal').on('change', function () {
        var $container = $('.BootstrapToggleFieldContainerVisibility', $(this).parent().parent().parent().parent().parent());
        
        $container.toggle('fast');
		
        return false;
    });
    
    $('.BootstrapToggleFieldContainer .togglefield-checkbox').on('change', function () {
        var $container = $('.BootstrapToggleFieldContainerVisibility', $(this).parent().parent().parent().parent());
        
        $container.toggle('fast');
		
        return false;
    });
})(jQuery);