<?php

namespace App\Fewbricks;

use App\Fewbricks\FieldGroups\Options\CustomCode;
use App\Fewbricks\FieldGroups\Options\SiteFooter\ColumnType1;

acf_add_options_page([
    'page_title' => 'Site settings and data',
    'menu_slug' => 'ec-site-settings-and-data',
    'position' => '4.1',
]);

(new CustomCode('Custom code', '2001052217a'))
    ->set_up()
    ->inject_code()
    ->register();

(new ColumnType1('Site Footer - Column 1', '1912022118a'))
    ->set_field_names_prefix('site_footer_col_1_')
    ->set_up()
    ->register();
