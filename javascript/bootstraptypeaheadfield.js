!function($){
    $(function(){
        $('.typeahead').each(function(){
            var $this = $(this);
            $this.typeahead({
                source: function (query, process) {
                    return $.get($this.attr('data-link'), { val: query }, function (data) {
                        return process(data);
                    });
                }
            });
        });
    });
}(window.jQuery);