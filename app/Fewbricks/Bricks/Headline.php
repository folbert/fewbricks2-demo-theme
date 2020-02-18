<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

class Headline extends Brick
{

    protected $label = 'Headline';

    protected $template_file_path = 'fewbricks.bricks.headline';

    /**
     *
     */
    public function set_up()
    {

        $this->add_field((new Text('Text', 'text', '2001051926a')));
        $this->add_field((new Select('Level', 'level', '2001051927a'))
            ->set_choices($this->get_argument('levels',
                ['1' => '1', '2' => '2', '3' => '3']
            ))
            ->set_allow_null(false)
        );

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        $view_data = $this->get_field_values(['text', 'level']);

        $view_data['main_wrapper_css_classes'] = 'ec-m ec-m-headline';

        return $view_data;

    }

}
