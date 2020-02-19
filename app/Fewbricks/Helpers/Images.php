<?php

namespace App\Fewbricks\Helpers;

use function App\sage;

/**
 * Class Images
 * @package App\Fewbricks\Helpers
 */
class Images
{

    const SIZE_RETURN_TYPE_ARRAY = 'array';

    const SIZE_RETURN_TYPE_STRING = 'string';

    /**
     * This function will attempt to calculate the best sizes to use in sizes attribute for an image or source.
     * Please note that if the column is nested, the sizes will be wrong as in being too large.
     * @link https://getbootstrap.com/docs/4.4/layout/overview/#containers
     * @link https://getbootstrap.com/docs/4.4/layout/grid/#grid-options
     * @link https://stackoverflow.com/q/49362289/7221036
     * @param string|array $column_css_classes The column types that the image is placed in.
     * Can be a string like  "col col-md-6 col-lg-8" or an array like ["col", "col-md-6", "col-lg-8"]. Both string and
     * array must be ordered by smallest to largest breakpoint size.
     * @param string $container_css_classes The container type that the column is placed in
     * @param string $return_type 'array' or 'string'
     * @return array|string Array or string with size definitions to use in sizes attribute
     */
    public static function get_sizes(array $column_css_classes, $container_css_classes = ['container'], $return_type = self::SIZE_RETURN_TYPE_STRING) {

        $sizes_array = [];

        if(empty($column_css_classes)) {
            return $sizes_array;
        }

        $sizes_array = self::get_sizes_for_container_css_classes($container_css_classes,
            self::get_column_css_classes_data($column_css_classes));

        if($return_type === self::SIZE_RETURN_TYPE_ARRAY) {
            return $sizes_array;
        }

        return implode(', ', $sizes_array);

    }

    /**
     * This function will get sizes up to (and including) a specific breakpoint.
     * @param $breakpoint_id
     * @param array|string $column_types See get_sizes for info.
     * @param string $container_type See get_sizes for info.
     * @param string $return_type See get_sizes_for_info
     * @return array|string Depending on $return_type. May be empty of no sizes for sent breakpoint was found.
     */
    public static function get_sizes_up_to_breakpoint($breakpoint_id, $column_types, $container_type, $return_type = self::SIZE_RETURN_TYPE_STRING) {

        $sizes = self::get_sizes($column_types, $container_type, self::SIZE_RETURN_TYPE_ARRAY);

        $valid_sizes = [];

        foreach($sizes AS $size_breakpoint_id => $size_data) {

            $valid_sizes[$size_breakpoint_id] = $size_data;

            if($size_breakpoint_id === $breakpoint_id) {
                break;
            }

        }

        if($return_type === self::SIZE_RETURN_TYPE_ARRAY) {
            return $valid_sizes;
        }

        return implode(', ', $valid_sizes);

    }

    /**
     * @param $breakpoint_id
     * @param array|string $column_types See get_sizes for info.
     * @param string $container_type See get_sizes for info.
     * @param bool $remove_media_query Set to true if you only want the calc-part.
     * @return array|string Depending on $return_type
     */
    public static function get_size_for_breakpoint($breakpoint_id, $column_types, $container_type, $remove_media_query = true) {

        $sizes = self::get_sizes($column_types, $container_type, self::SIZE_RETURN_TYPE_ARRAY);

        if(!isset($sizes[$breakpoint_id])) {
            return '';
        }

        $size = $sizes[$breakpoint_id];

        if(!$remove_media_query) {
            return $size;
        }

        if(false !== ($calc_start = strpos($size, 'calc'))) {
            $size = substr($size, $calc_start);
        }

        return $size;

    }

    /**
     * @param $container_css_classes
     * @param $column_types_data
     * @return array
     */
    private static function get_sizes_for_container_css_classes($container_css_classes, $column_types_data) {

        $sizes = [];

        $container_css_class = self::get_container_css_class($container_css_classes);

        if($container_css_class === false) {
            return $sizes;
        }

        switch($container_css_classes) {

            case 'container-fluid' :

                $sizes = self::get_sizes_for_fluid_container($column_types_data);
                break;

            case 'container-sm' :
            case 'container-md' :
            case 'container-lg' :
            case 'container-xl' :

                $sizes = self::get_sizes_for_specific_breakpoint_container($column_types_data, $container_css_classes);
                break;

            default :

                $sizes = self::get_sizes_for_standard_container($column_types_data);

        }

        return $sizes;

    }

    /**
     * There should really be only one valid bootstrap container css class for a container but if there are motre than
     * one, this function will give us the last one added.
     * @param $container_css_classes
     * @return bool|mixed
     */
    private static function get_container_css_class($container_css_classes)
    {

        $container_css_class = false;

        // Lets assume that the last added container class is the one to use
        $reversed_container_css_classes = array_reverse($container_css_classes);

        foreach($reversed_container_css_classes AS $reversed_container_css_class) {

            if(in_array($reversed_container_css_class, sage('config')->get('fewbricks_design_grid')['column_css_classes'])) {

                $container_css_class = $reversed_container_css_class;
                break;

            }
        }

        return $container_css_class;

    }

    /**
     * Use for containers like "container-lg"
     * @param array $column_types_data
     * @param string $container_type
     * @return array
     */
    private static function get_sizes_for_specific_breakpoint_container($column_types_data, $container_type) {

        $sizes = [];

        $container_break_point_name = explode('-', $container_type)[1];

        $design_grid_config = sage('config')->get('fewbricks_design_grid');

        $container_break_point_passed = false;

        $column_width_factor = 1;

        foreach($design_grid_config['breakpoints'] AS $breakpoint_name => $breakpoint) {

            $size_media_query = self::get_size_media_query($breakpoint['min_max'][0], $breakpoint['min_max'][1]);

            if($breakpoint_name === $container_break_point_name) {
                $container_break_point_passed = true;
            }

            $container_width = ($container_break_point_passed ? $breakpoint['container']['width'] : '100vw');

            if(isset($column_types_data[$breakpoint_name])) {

                $column_width_factor = round($column_types_data[$breakpoint_name]['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            } elseif(isset($column_types_data['col'])) {

                $column_width_factor = round($column_types_data['col']['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            }

            $width = 'calc(' . $column_width_factor . ' * ' . $container_width . ')';

            $sizes[$breakpoint_name] = $size_media_query . ' ' . $width;

        }

        return $sizes;

    }

    /**
     * Use for "container"
     * @param array $column_types_data
     * @return array
     */
    private static function get_sizes_for_standard_container($column_types_data) {

        $sizes = [];

        $design_grid_config = sage('config')->get('fewbricks_design_grid');

        $column_width_factor = 1;

        foreach($design_grid_config['breakpoints'] AS $breakpoint_name => $breakpoint) {

            $size_media_query = self::get_size_media_query($breakpoint['min_max'][0], $breakpoint['min_max'][1]);

            if(isset($column_types_data[$breakpoint_name])) {

                $column_width_factor = round($column_types_data[$breakpoint_name]['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            } elseif(isset($column_types_data['col'])) {

                $column_width_factor = round($column_types_data['col']['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            }

            $width = 'calc(' . $column_width_factor . ' * ' . $breakpoint['container']['width'] . ')';

            $sizes[$breakpoint_name] = $size_media_query . ' ' . $width;

        }

        return $sizes;

    }

    /**
     * Use for "container-fluid"
     * @param array $column_types_data
     * @return array
     */
    private static function get_sizes_for_fluid_container($column_types_data) {

        $sizes = [];

        $design_grid_config = sage('config')->get('fewbricks_design_grid');

        $column_width_factor = 1;

        foreach($design_grid_config['breakpoints'] AS $breakpoint_name => $breakpoint) {

            $size_media_query = self::get_size_media_query($breakpoint['min_max'][0], $breakpoint['min_max'][1]);

            if(isset($column_types_data[$breakpoint_name])) {

                $column_width_factor = round($column_types_data[$breakpoint_name]['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            } elseif(isset($column_types_data['col'])) {

                $column_width_factor = round($column_types_data['col']['nr_of_columns']/$design_grid_config['nr_of_columns'], 5);

            }

            $width = 'calc(' . $column_width_factor . ' * 100vw)';

            $sizes[$breakpoint_name] = $size_media_query . ' ' . $width;

        }

        return $sizes;

    }

    /**
     * @param $column_css_classes
     * @return array
     */
    private static function get_column_css_classes_data($column_css_classes) {

        $design_grid_config = sage('config')->get('fewbricks_design_grid');

        $column_css_classes_data = [];

        if(!is_array($column_css_classes)) {
            $column_css_classes = explode(' ', $column_css_classes);
        }

        if(count($column_css_classes) === 1 && $column_css_classes[0] === "col") {

            $column_css_classes_data = [
                [
                    $design_grid_config['largest_breakpoint_key'] =>
                        [
                            'nr_of_columns' => $design_grid_config['nr_of_columns'],
                        ],
                ],
            ];

        } else {

            foreach ($column_css_classes AS $column_type) {

                $column_type_data = explode('-', $column_type);

                if(
                    count($column_type_data) < 2
                    || $column_type_data[0] !== 'col'
                ) {
                    continue;
                }

                if (count($column_type_data) === 3 && is_numeric($column_type_data[2])) {
                    // For example col-md-3

                    // breakpoint => nr_of_columns
                    $column_css_classes_data[$column_type_data[1]] = ['nr_of_columns' => $column_type_data[2]];

                } else if (count($column_type_data) === 2 && is_numeric($column_type_data[1])) {
                    // For example col-3

                    // breakpoint => nr_of_columns
                    $column_css_classes_data[$column_type_data[0]] = ['nr_of_columns' => $column_type_data[1]];

                }

            }

        }

        return $column_css_classes_data;

    }

    /**
     * @param string $min
     * @param string $max
     * @return string
     */
    private static function get_size_media_query($min, $max) {

        $media_query = '(max-width: ' . $max . ')';

        if(intval($min) > 0) {
            $media_query = '(min-width: ' . $min . ') and ' . $media_query;
        }

        return $media_query;


    }

    /**
     * @param string $breakpoint
     * @return mixed
     */
    public static function get_source_media_attribute($breakpoint)
    {

        $design_grid_config = sage('config')->get('fewbricks_design_grid');

        $min_max = $design_grid_config['breakpoints'][$breakpoint]['min_max'] ?? false;

        if($min_max === false) {
            return false;
        }

        return self::get_size_media_query($min_max[0], $min_max[1]);


    }

}
