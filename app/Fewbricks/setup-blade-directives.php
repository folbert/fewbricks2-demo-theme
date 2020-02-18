<?php

namespace App\Fewbricks;

use function App\sage;

/**
 *
 */
add_action('after_setup_theme', function() {

    //
    sage('blade')->compiler()->directive('ec_array_to_elm_attributes', function ($attributes_and_values) {

        return "<?php echo App\Fewbricks\Helpers\HTML::assoc_array_to_attributes_string({$attributes_and_values}); ?>";

    });

});
