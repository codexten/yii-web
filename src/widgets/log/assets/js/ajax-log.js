//function to refresh Log in an interval
(function ($) {
    //set default values
    $.logDefaults = $.logDefaults || {};
    $.logDefaults = {
        url: null,
        endStatus: 'stopped',
        refreshRate: 1000,
    };
    jQuery.fn.updateLog = function (options) {
        //merge default options with params
        var options = $.merge(options, $.logDefaults || {});
        if (options.url == null) {
            console.log('Required parameter Url is missing');
            return false;
        }
        //create log container pointer
        var logContainer = $('#' + $(this).attr('id'));
        //make ajax request with given interval using setInterval function
        var logLoader = setInterval(function () {
            $.ajax(options.url, {
                success: function (data) {
                    if (data.status === options.endStatus) {
                        //stop setInterval function loop if process ended
                        clearInterval(logLoader);
                    }
                    logContainer.html(data.log);
                },
                error: function () {
                    logContainer.text('An error occurred');
                }
            });
        }, options.refreshRate);
    };
})(jQuery);
