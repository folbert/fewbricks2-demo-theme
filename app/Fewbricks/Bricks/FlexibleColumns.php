<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\Bricks\Traits\Container;
use App\Fewbricks\CommonFields;
use Fewbricks\ACF\Fields\Repeater;
use Fewbricks\ACF\Fields\Tab;

class FlexibleColumns extends Brick
{

    /**
     * @var string
     */
    protected $template_file_path = 'fewbricks.bricks.flexible-columns';

    /**
     *
     */
    public function set_up() {

        $this->add_content_fields();
        $this->add_settings_fields();

    }

    /**
     *
     */
    private function add_content_fields() {

        $this->add_field(new Tab('Columns', 'columns_group', '2001071542a'));

        $repeater = (new Repeater('', 'columns', '2001041552a'))
            ->set_layout('block')
            ->set_button_label('Add column');

        $repeater->add_brick((new FlexibleColumn('2001041553a','column'))
            ->set_argument('hide_backend_name', true)
        );

        $this->add_repeater($repeater);

    }

    /**
     *
     */
    private function add_settings_fields() {

        $this->add_field(new Tab('Settings', 'settings_group', '2001071542p'));

        $this->add_field(CommonFields::get_instance()->get_field('container_width_1', '2002061738a'));
        $this->add_field(CommonFields::get_instance()->get_field('vertical_alignment', '2002031728a'));
        $this->add_field(CommonFields::get_instance()->get_field('element_id', '2001022236a'));
        $this->add_field(CommonFields::get_instance()->get_field('backend_name', '2001022213a'));

    }

    /**
     * @return array
     */
    public function get_columns()
    {

        $columns = [];

        $repeater = $this->get_repeater_for_view('columns');

        if($repeater->have_rows()) {

            while($repeater->have_rows()) {

                $repeater->the_row();

                /** @var Brick $brick */
                //$brick = $repeater->get_brick_in_row();
                $brick = (new FlexibleColumn())->set_name('column');
                $brick->set_is_standalone(false);
                $brick->detach_from_acf_loop();

                $columns[] = $brick;

            }

        }

        foreach($columns AS &$column) {

            $column->set_container_css_classes($this->container_css_classes);

        }

        return $columns;

    }

    /**
     * @param $view_data
     * @return mixed|void
     */
    public function finalize_view_data($view_data)
    {

        unset($view_data['wrapping_elements_data']['column_css_classes']);

        return $view_data;

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $columns = $this->get_columns();

        if(empty($columns)) {
            return false;
        }

        return [
            'columns' => $this->get_columns(),
            'container_css_classes' => $this->get_container_css_classes('string'),
            'row_css_classes' => $this->get_row_css_classes(),
            'main_wrapper_css_classes' => 'ec-m ec-m-flexible-columns',
        ];

    }

}
