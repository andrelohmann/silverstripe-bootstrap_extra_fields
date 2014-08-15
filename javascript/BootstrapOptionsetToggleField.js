(function ($) {
    $('.BootstrapOptionsetToggleFieldContainer .optionsettogglefield-radio-horizontal').on('change', function () {
        
        var $containerHide = $('.BootstrapOptionsetToggleFieldContainerVisibility', $(this).parent().parent().parent().parent().parent().parent());
        
        $containerHide.hide('fast');
        
        var $container = $('.BootstrapOptionsetToggleFieldContainerVisibility', $(this).parent().parent().parent().parent().parent());
        
        $container.show('fast');
		
        return false;
    });
    $('.BootstrapOptionsetToggleFieldContainer .optionsettogglefield-radio').on('change', function () {
        
        var $containerHide = $('.BootstrapOptionsetToggleFieldContainerVisibility', $(this).parent().parent().parent().parent().parent());
        
        $containerHide.hide('fast');
        
        var $container = $('.BootstrapOptionsetToggleFieldContainerVisibility', $(this).parent().parent().parent().parent());
        
        $container.show('fast');
		
        return false;
    });
})(jQuery);