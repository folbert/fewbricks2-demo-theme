<?php

namespace App\Fewbricks\Helpers;

class HTML
{

    /**
     * Handles an array with these possible layouts:
     * [
     *    [
     *      'attribute_name' => [
     *        'values' // string or indexed array with values.
     *        'divider' // string with divider when imploding values. A space will be used if not set except if
     *           attribute_name is "style", in which case ';' will be used
     *      ]
     *    ],
     *    ['attribute_name' => 'value'] // Where 'value' is a string or indexed array with values
     * ]
     * @param array $attributes_and_values Assoc array
     * @param string $quotation_mark
     * @return string
     */
    public static function assoc_array_to_attributes_string($attributes_and_values, $quotation_mark = '"') {

        $string = '';

        foreach($attributes_and_values AS $attribute => $data) {

            if(!is_array($data)) {
                $data = ['values' => $data];
            } else if(!isset($data['values'])) {
                $data['values'] = $data;
            }

            $divider = ' ';

            if($attribute === 'style') {
                $divider = ';';
            }

            if(isset($data['divider'])) {
                $divider = $data['divider'];
            }

            if(!is_array($data['values'])) {
                $data['values'] = [$data['values']];
            }

            $string .= ' ' . $attribute . '=' . $quotation_mark . trim(implode($divider, $data['values'])) . $quotation_mark;

        }

        if(!empty($string)) {
            $string = ' ' . trim($string);
        }

        return $string;

    }

}
