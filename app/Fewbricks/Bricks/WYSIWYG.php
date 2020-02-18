<?php

namespace App\Fewbricks\Bricks;

class WYSIWYG extends Brick
{

    protected $label = 'WYSIWYG';

    protected $template_file_path = 'fewbricks.bricks.wysiwyg';

    /**
     *
     */
    public function set_up()
    {

        $this->add_field((new \Fewbricks\ACF\Fields\Wysiwyg('', 'content', '2001051717a'))
            ->set_delay(true)
            ->set_media_upload($this->get_argument('media_upload', false))
            ->set_required($this->get_argument('required', false))
            ->set_toolbar($this->get_argument('toolbar', 'ec_wysiwyg_toolbar_1'))
        );

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return [
            'content' => $this->get_field_value('content'),
            'main_wrapper_css_classes' => 'ec-m ec-m-wysiwyg',
        ];

    }

}
