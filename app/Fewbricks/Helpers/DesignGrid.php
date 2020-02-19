<?php

namespace App\Fewbricks\Helpers;

use function App\sage;

/**
 * Class DesignGrid
 * @package App\Fewbricks\Helpers
 */
class DesignGrid
{

    /**
     * @param $breakpoint_name
     * @return bool
     */
    public static function get_container_for_breakpoint_name($breakpoint_name) {

        return sage('config')->get('fewbricks_design_grid')['breakpoints'][$breakpoint_name]['container'] ?? false;

    }

    /**
     * @param $breakpoint_name
     * @return array|bool
     */
    public static function get_container_width_for_breakpoint_name($breakpoint_name) {

        return sage('config')->get('fewbricks_design_grid')['breakpoints'][$breakpoint_name]['container']['width'] ?? false;

    }


}
