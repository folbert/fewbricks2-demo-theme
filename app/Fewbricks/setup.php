<?php

namespace App\Fewbricks;

// If fewbricks is installed in the theme, use the line below and also use the filter "fewbricks/settings/install_url" further down
/*require_once get_stylesheet_directory() . '/../vendor/folbert/acf-fewbricks-hidden/acf-fewbricks-hidden.php';
require_once get_stylesheet_directory() . '/../vendor/folbert/acf-fewbricks-hidden/acf-fewbricks-hidden-v5.php';
require_once get_stylesheet_directory() . '/../vendor/folbert/fewbricks/fewbricks.php';*/

// https://fewbricks2.folbert.com/filters/
add_filter('fewbricks/dev_mode/enable', function() {
    return WP_ENV === 'development';
});

add_filter('fewbricks/show_fields_info', function() {
    return WP_ENV === 'development' && true === false;
});

add_filter('fewbricks/info_pane/display', function() {
    return WP_ENV === 'development';
});

// Customize the url setting to fix incorrect asset URLs.
/*add_filter('fewbricks/settings/install_url', function( $url ) {
    return get_stylesheet_directory_uri() . '/../vendor/folbert/fewbricks';
});*/

add_filter('fewbricks/exporter/php/auto_write_target', function($target) {
    //return get_stylesheet_directory() . '/fewbricks-code.php';
    return false;
});

add_filter('fewbricks/exporter/php/auto_write_target', function($target) {
    return false;
});


