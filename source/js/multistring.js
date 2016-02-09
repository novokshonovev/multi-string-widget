(function ($) {

    var MultiString = function ($element, params) {

        var
            listClass = params.listClass,
            addLinkClass = params.addLinkClass,
            itemClass = params.itemClass,
            removeClass = params.removeClass;

        var $addLink = $element.children('.' + listClass).next('.' + addLinkClass);

        this.methods = {
            append: function (item) {
                if (!item) {
                    item = $addLink.data('sample-item');
                }
                return appendItem(item);
            }
        };

        $element.on('click', '.' + itemClass + ' .' + removeClass, function () {

            $(this).closest('.'+itemClass).remove();

            protectSingleItem();
            if (typeof params.afterDelete == 'function') {
                params.afterDelete($element);
            }
            return false;
        });

        $addLink.on('click', function () {

            var $link = $(this);

            appendItem($link.data('sample-item'));

            return false;
        });

        function appendItem(item) {
            $element.children('.'+listClass).append(item);
            var $insertedItem = $element.children('.'+listClass).children('.'+itemClass).last();
            if (typeof params.afterInsert == 'function') {
                params.afterInsert($insertedItem);
            }
            protectSingleItem();
            return $insertedItem;
        }

        function protectSingleItem() {
            if (params.protectSingleItem) {
                var itemCount = $element.find('.'+itemClass).length;

                if (itemCount == 1) {
                    $element.find('.'+removeClass).hide();
                } else if (itemCount > 1) {
                    $element.find('.'+removeClass).show();
                }
            }
        };

        protectSingleItem();
    };

    $.fn.multiString = function (method, params) {

        if (typeof method == "object") {

            params = method;

            $(this).each(function () {

                var $this = $(this).first(),
                    widget = $this.data('multi-string-widget');

                if (widget) {
                    console.log('Widget is already initialized');
                } else {
                    widget = new MultiString($this, params);
                    $this.data('multi-string-widget', widget);
                }
            });

        } else {

            var $this = $(this).first(),
                widget = $this.data('multi-string-widget');

            if (widget) {

                if (widget.methods[method]) {
                    return widget.methods[method].call(widget, params);
                } else {
                    console.log('Unknown method ' + method);
                }

            } else {
                console.log('Widget is not initialized');
            }
        }
    };
})(jQuery);