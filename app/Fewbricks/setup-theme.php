<?php

/**
 * Check README.EchoCrate.md for info on EchoCrates filters and actions
 */

namespace App\Fewbricks;

use Roots\Sage\Container;

/**
 *
 */
add_action('after_setup_theme', function() {

    $configs_base_path = __DIR__ .'/config/';

    $configs = [
        'echocrate_media' => 'media',
        'echocrate_design_grid' => 'design-grid',
        'echocrate_acf_toolbars' => 'wysiwyg-toolbars',
    ];

    foreach($configs AS $config_name => $config_file) {
        Container::getInstance()->config[$config_name] = require $configs_base_path . $config_file . '.php';
    }

}, 1); // <--- 1!
