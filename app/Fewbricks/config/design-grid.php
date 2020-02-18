<?php

/**
 * Here you define grid data that will be used for example when calculating srcsets and sizes for images.
 * Note that these settings are not applied to .scss files so if you want to change bootstrap settings you need to it
 * here and in the scss-files as well.
 */

return [

    // Not used anywhere yet but added in case we will support other systems later on
    'type' => 'bootstrap',

    // https://getbootstrap.com/docs/4.0/layout/grid/#columns-and-gutters
    'nr_of_columns' => '12',

    // https://getbootstrap.com/docs/4.0/layout/grid/#columns-and-gutters
    'gutter_width' => '30px', // Value of each side * 2

    // The key of the largest breakpoint (not counting fluid) in the array below.
    'largest_breakpoint_key' => 'xl',

    'column_css_classes' => [
        'container',
        'container-fluid',
        'container-sm',
        'container-md',
        'container-lg',
        'container-xl',
    ],

    // https://getbootstrap.com/docs/4.0/layout/overview/#responsive-breakpoints
    // These must be in order from smallest to largest.
    'breakpoints' => [
        'xs' => [
            'min_max' => ['0px', '575.98px'],
            'container' => [
                'width' => '100vw',
            ],
        ],
        'sm' => [
            'min_max' => ['576px', '767.98px'],
            'container' => [
                'width' => '540px',
            ],
        ],
        'md' => [
            'min_max' => ['768px', '991.98px'],
            'container' => [
                'width' => '720px',
            ],
        ],
        'lg' => [
            'min_max' => ['992px', '1199.98px'],
            'container' => [
                'width' => '960px',
            ],
        ],
        'xl' => [
            'min_max' => ['1200px', '9999px'],
            'container' => [
                'width' => '1140px',
            ],
        ],
    ],

];
