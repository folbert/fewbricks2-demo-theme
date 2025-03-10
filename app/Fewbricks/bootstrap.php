<?php

require_once 'setup.php';
require_once 'setup-theme.php';
require_once 'setup-acf.php';
require_once 'setup-blade-directives.php';
require_once 'setup-wysiwyg.php';
require_once 'filters.php';
require_once 'add-fields-and-field-groups.php';

add_action('wp_enqueue_scripts', function() {

    wp_enqueue_style('fewbricks2-demo', get_template_directory_uri() . '/assets/dev.css');

});
