<?php

namespace App\Fewbricks;

use function App\sage;

/**
 *
 */
add_filter('acf/fields/wysiwyg/toolbars', function($toolbars) {

    $fewbricks_toolbars = sage('config')->get('fewbricks_acf_toolbars');

    if(is_array($fewbricks_toolbars)) {
        $toolbars = array_merge($toolbars, $fewbricks_toolbars);
    }

    return $toolbars;

});

/**
 *
 */
add_filter('tiny_mce_before_init', function($settings) {

    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3';

    return $settings;

}, 10, 1);
