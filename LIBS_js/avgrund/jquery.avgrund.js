/**
 *  jQuery Avgrund Popin Plugin
 *  http://github.com/voronianski/jquery.avgrund.js/
 *
 *  (c) http://pixelhunter.me/
 *  MIT licensed
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        module.exports = factory;
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    $.fn.avgrund = function (options) {
        var defaults = {
            width: 380, // max = 640
            height: 280, // max = 350
            showClose: false,
            showCloseText: '',
            closeByEscape: true,
            closeByDocument: true,
            holderClass: '',
            overlayClass: '',
            enableStackAnimation: false,
            onBlurContainer: '',
            openOnEvent: true,
            setEvent: 'click',
            onLoad: false,
            onUnload: false,
            onClosing: false,
            template: '<p>This is test popin content!</p>'
        };

        options = $.extend(defaults, options);

        return this.each(function () {
            var self = $(this),
                body = $('body'),
                maxWidth = options.width > 640 ? 640 : options.width,
                maxHeight = options.height > 350 ? 350 : options.height,
                template = typeof options.template === 'function' ? options.template(self) : options.template;

            body.addClass('avgrund-ready');

            if ($('.avgrund-overlay').length === 0) {
                body.append('<div class="avgrund-overlay ' + options.overlayClass + '"></div>');
            }

            if (options.onBlurContainer !== '') {
                $(options.onBlurContainer).addClass('avgrund-blur');
            }

            function onDocumentKeyup (e) {
                if (options.closeByEscape) {
                    if (e.keyCode === 27) {
                        deactivate();
                    }
                }
            }

            function onDocumentClick (e) {
                if (options.closeByDocument) {
                    if ($(e.target).is('.avgrund-overlay, .avgrund-close, .avgrund-cierra')) {
                        e.preventDefault();
                        deactivate();
                    }
                } else if ($(e.target).is('.avgrund-close')) {
                        e.preventDefault();
                        deactivate();
                } else if ($(e.target).is('.avgrund-cierra')) {
                        e.preventDefault();
                        deactivate();
				}
            }

            function activate () {
                if (typeof options.onLoad === 'function') {
                    options.onLoad(self);
                }

                setTimeout(function () {
                    body.addClass('avgrund-active');
                }, 100);

                var $popin = $('<div class="avgrund-popin col-xs-12 col-sm-9 col-md-6 col-lg-4 ' + options.holderClass + '"></div>');
                $popin.append(template);
                body.append($popin);

                $('.avgrund-popin').css({
                    'top': (maxHeight + document.body.scrollTop) + "px",
                    'left': Math.max(0, (($(window).width() - maxWidth) / 2) +  $(window).scrollLeft()) + "px",
                });

                if (options.showClose) {
                    $('.avgrund-popin').append('<a href="#" class="avgrund-close">' + options.showCloseText + '</a>');
                }

                if (options.enableStackAnimation) {
                    $('.avgrund-popin').addClass('stack');
                }

                body.bind('keyup', onDocumentKeyup)
                    .bind('click', onDocumentClick);
            }

            function deactivate () {
                if (typeof options.onClosing === 'function') {
                    if (!options.onClosing(self)) {
                        return false;
                    }
                }

                body.unbind('keyup', onDocumentKeyup)
                    .unbind('click', onDocumentClick)
                    .removeClass('avgrund-active');

                setTimeout(function () {
                    $('.avgrund-popin').remove();
                }, 500);

                if (typeof options.onUnload === 'function') {
                    options.onUnload(self);
                }
            }

            if (options.openOnEvent) {
                self.bind(options.setEvent, function (e) {
                    e.stopPropagation();

                    if ($(e.target).is('a')) {
                        e.preventDefault();
                    }

                    activate();
                });
            } else {
                activate();
            }
        });
    };
}));
