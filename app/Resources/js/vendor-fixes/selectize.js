(function ($, window) {
    var Selectize = window.Selectize;

    //Clear on type from https://github.com/selectize/selectize.js/pull/477
    Selectize.define('clear_on_type', function() {
        var self = this;
        var IS_MAC = /Mac/.test(navigator.userAgent);
        var KEY_BACKSPACE = 8;

        this.onKeyDown = (function() {
            var original = self.onKeyDown;
            return function(e) {
                var originalCode = e.keyCode;
                if ((self.isFull() || self.isInputHidden) && !(IS_MAC ? e.metaKey : e.ctrlKey)) {
                    if (self.isOpen && self.$activeOption) {
                        e.keyCode = KEY_BACKSPACE;
                        self.deleteSelection(e);
                        e.keyCode = originalCode;
                    }
                }
                return original.apply(this, arguments);
            };
        })();
    });

    //Fix buggy selectize behaviour -> see https://github.com/selectize/selectize.js/issues/743
    $.extend(Selectize.prototype, {
        /**
         * Hides the input element out of view, while
         * retaining its focus.
         */
        hideInput: function () {
            var self = this;

            self.setTextboxValue('');
            // changed position -> absolute to relative for selects with multiple
            self.$control_input.css({opacity: 0, position: self.$wrapper.hasClass('single') ? 'absolute' : 'relative', left: self.rtl ? 10000 : -10000});
            self.isInputHidden = true;
        }
    });
})(jQuery, window);