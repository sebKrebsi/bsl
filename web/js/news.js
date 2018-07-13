(function ($)
{
    var $facebookIframe = $('#facebook-news-iframe');
    var height = $('#page-news-container').css('height');

    if (height > $facebookIframe.css('height')) {
        $facebookIframe.css('height', height);
    }

})(jQuery);