!function($){
    $(function(){
        $('.dependenttypeahead').each(function(){
            var $this = $(this);
            $this.typeahead({
                showHintOnFocus: true,
                minLength: 0,
                source: function (query, process) {
                    var depends = $(":input[name=" + $this.attr('data-depends').replace(/[#;&,.+*~':"!^$[\]()=>|\/]/g, "\\$&") + "]");
                    return $.get($this.attr('data-link'), { val: query, dependentval: depends.val() }, function (data) {
                        return process(data);
                    });
                    //console.log($this.attr('data-link'));
                }
            });
        });
    });
}(window.jQuery);