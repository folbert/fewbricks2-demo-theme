<?php

namespace App\Fewbricks\Bricks\Links;

use App\Fewbricks\Bricks\Brick;
use Fewbricks\ACF\Fields\Extensions\FewbricksHidden;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\TrueFalse;

abstract class Link extends Brick
{

    /**
     * @var string
     */
    protected $template_file_path = 'fewbricks.bricks.link';

    /**
     *
     */
    public function set_up()
    {

    }

    /**
     * @return $this
     */
    protected function add_shared_fields()
    {

        $this->add_style_field();

        if(!(is_a($this, 'App\Fewbricks\Bricks\Links\Email')) && !$this->get_argument('open_in_new_window', false)) {
            $this->add_field(new TrueFalse('Open in new window', 'open_in_new_window', '2001072105a'));
        }

        return $this;

    }

    /**
     *
     */
    private function add_style_field()
    {

        if($this->get_argument('hide_style', false)) {
            return;
        }

        if($this->get_argument('forced_style', false) === false) {

            $this->add_field((new Select('Style', 'style', '1912012220a'))
                ->set_choices([
                    'standard' => 'Standard Link',
                    'primary_button' => 'Primary Button',
                    'secondary_button' => 'Secondary Button',
                ])
                ->set_required(true));

        } else {

            $this->add_field((new FewbricksHidden('Style', 'style', '1912020838a'))
                ->set_default_value($this->get_argument('forced_style')));

        }

    }

    /**
     * @return mixed
     */
    public function get_view_data_css_classes()
    {

        $classes = [];

        $classes[] = 'ec-m';
        $classes[] = 'ec-m-link';

        $classes = array_merge($classes, $this->view_data_css_classes);

        $style = $this->get_field_value('style');

        $style_class_map = [
            'primary_button' => 'btn-primary',
            'secondary_button' => 'btn-secondary',
        ];

        if(isset($style_class_map[$style])) {
            $classes[] = $style_class_map[$style];
        }

        switch($style) {

            case 'primary_button' :
            case 'secondary_button' :
                $classes[] = 'btn';
                break;

        }

        return $classes;

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return array_merge(
            $this->get_field_values(['text', ['target' => 'href']]),
            [
                'a_elm_css_classes' => implode(static::get_view_data_css_classes(), ' '),
                'target' => $this->get_field_value('open_in_new_window') ? '_blank' : '_self',
            ]
        );

    }

}
