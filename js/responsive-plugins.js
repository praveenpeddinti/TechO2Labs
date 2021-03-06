/*!
 * Responsive JS Plugins v1.1.0
 */

// Have a custom video player? We now have a customSelector option where you can add your own specific video vendor selector (mileage may vary depending on vendor and fluidity of player):
// jQuery("#thing-with-videos").fitVids({ customSelector: "iframe[src^='http://example.com'], iframe[src^='http://example.org']"});
// Selectors are comma separated, just like CSS
// Note: This will be the quickest way to add your own custom vendor as well as test your player's compatibility with FitVids.
// Tinynav
jQuery(function(){
    // Main Menu
    jQuery('.sf-menu').tinyNav({
        active: 'selected' ,// Set the "active" class
		header: 'Menu'
    });

    // Subheader Menu (uncomment to use)
    //jQuery('.sub-header-menu').tinyNav({
        //active: 'selected', // Set the "active" class
    //});
});


