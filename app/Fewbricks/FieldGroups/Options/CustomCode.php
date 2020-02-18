<?php

namespace App\Fewbricks\FieldGroups\Options;

use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Textarea;

class CustomCode extends OptionsFieldGroup
{

    /**
     * @var array
     */
    private static $custom_code_fields = [
        'wp_head' => 'before_closing_head',
        'wp_body_open' => 'after_opening_body',
        'wp_footer' => 'before_closing_body',
    ];

    /**
     * @return $this
     */
    public function set_up()
    {

        $menu_slug = 'ec-site-settings-and-data--custom-code';

        $this->add_options_sub_page('Custom Code', $menu_slug, 'ec-site-settings-and-data');

        $this->add_to_options_page($menu_slug);

        $this->set_style('seamless');

        $this->add_field(
            (new Message('', 'message', '2001060953a'))
            ->set_message('<br><span style="color: red">Make sure that you know what you are doing here since adding teh wrong type of code can cause unexpected behaviour for the frontend user.</span><br><br>
Use these fields to insert for example Google Analytics code or any other custom code that you want added on every page.<br><br>
The code you enter in the "only inserted when not logged in" will only be inserted in the production environment ("the live server")  when the visitor is not a logged in WordPress administrator. This is useful for for example Google Analytics when you don\'t want to count page views for administrators. Be careful with this if you are running a site where visitors can log in.')
        );

        foreach(self::$custom_code_fields AS $field) {

            $label = str_replace('_', ' ', $field);

            $this->add_field(new Textarea('Right ' . $label . ' tag - always inserted', $field . '__always', '2001052224_' . $field . '_always'));

            $this->add_field(
                (new Textarea('Right ' . $label . ' tag - only inserted when not logged in', $field . '__not_logged_in', '2001052224_' . $field . '_not_logged_in'))
            );

        }

        return $this;

    }

    /**
     *
     */
    public function inject_code()
    {

        foreach(self::$custom_code_fields AS $action_name => $field) {

            /**
             * Add data from CustomCode
             */
            add_action($action_name, function() use($field) {

                echo get_field($field . '__always', 'options');

                if(!current_user_can('activate_plugins')) {
                    echo get_field($field . '__not_logged_in', 'options');
                }

            }, 99999);

        }

        return $this;

    }

}
