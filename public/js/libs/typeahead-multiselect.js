(function($){
    $.fn.serializeObject = function () {
        "use strict";

        var result = {};
        var extend = function (i, element) {
            var node = result[element.name];

            // If node with same name exists already, need to convert it to an array as it
            // is a multi-value field (i.e., checkboxes)

            if ('undefined' !== typeof node && node !== null) {
                if ($.isArray(node)) {
                    node.push(element.value);
                } else {
                    result[element.name] = [node, element.value];
                }
            } else {
                result[element.name] = element.value;
            }
        };

        $.each(this.serializeArray(), extend);
        return result;
    };
})(jQuery);


! function(a) {
    var b = function(b, c, d) {
        var e = d ? c[d] : c;
        a("<li class='selected-item'>" + e + '<i class="js-remove">✖</i></li>').attr('data-id',c.id).data("__ttmulti_data__", c).appendTo(b).find(".js-remove").bind("click", function() {
            this.parentNode.remove();
            multiCfg.selectionRemoved(c.id);
        })
    };
    a.fn.typeaheadmulti = function(c, d) {
        multiCfg = d;
        var $a = a;
        var selectionLimit = d.selectionLimit || false;
        function e(c, d) {
            var e = d ? d.display : void 0;
            this.each(function() {
                var f = a(this),
                    g = a("<ul>").addClass("ttmulti-selections").insertBefore(f);
                f.typeahead(c, d).bind("typeahead:select", function(a, c) {
                    if($a.find("li.selected-item[data-id='"+c.id+"']").length){
                        f.typeahead("val", "");
                        return false;
                    }

                    if(selectionLimit && ($a.find("li.selected-item").length + 1) > selectionLimit){
                        f.typeahead("val", "");
                        return alert('you can choose only '+selectionLimit+' item');
                    }
                    b(g, c, e), f.typeahead("val", "")
                })
            })
        }

        function f(b) {
            return this.first().parent().prev(".ttmulti-selections").find("li").map(function() {
                return a(this).data("__ttmulti_data__")
            })
        }
        return "val" === c ? f.call(this, [].slice.call(arguments, 1)) : e.call(this, c, d)
    }
}(jQuery);