<?php

namespace App\Fewbricks;

use function App\sage;

/**
 * (Optional) Hide the ACF admin menu item.
 */
add_filter('acf/settings/show_admin', function($show_admin) {
    return WP_ENV === 'development';
});

/**
 * https://www.advancedcustomfields.com/blog/acf-pro-5-5-13-update/
 * /
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

/**
 *
 */
add_filter('acf/fields/flexible_content/layout_title', function($title, $field, $layout, $i) {

    $append = '';

    $backend_name = get_sub_field($layout['name'] . '_backend_name');
    if(!empty($backend_name)) {
        $append .= ' – ' . stripslashes($backend_name);
    }

    $column_width = get_sub_field($layout['name'] . '_column_width');
    if(!empty($column_width)) {
        $append .= ' – Width: ' . $column_width . '';
    }

    $column_offset = get_sub_field($layout['name'] . '_column_offset');
    if($column_offset !== false) {

        if(empty($column_offset)) {
            $column_offset = '0';
        }

        if(!empty($column_offset)) {
            $append .= ' – Offset: ' . $column_offset . '';
        }

    }

    if(!empty($append)) {
        $title .= ' <span style="font-weight: normal">' . $append . '</span>';
    }

    return $title;

}, 10, 4);
