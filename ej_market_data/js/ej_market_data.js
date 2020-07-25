/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.ej_market_data = {
        attach: function (context) {
            var hostname   = window.location.hostname;

            $('#addToWatchList').click(function(event){

                var data = drupalSettings.selectedSymbol;

                if($.cookie('EJW_WATCHLIST')){
                    var updatedWatchListItems = data + '|' +  $.cookie('EJW_WATCHLIST');
                    var watchListItems = updatedWatchListItems.split('|');
                    watchListItems = $.unique( watchListItems );
                    data = watchListItems.join('|');
                }

                $.cookie('EJW_WATCHLIST', data, {path: "/", domain: hostname, expires: 365});
                $.cookie.json = true;
                window.location.replace("/market/stockwatchlist");
            });
            
        }
    };
})(jQuery, Drupal, drupalSettings);
