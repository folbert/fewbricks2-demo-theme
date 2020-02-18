<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\CommonFields;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Tab;

class ModuleGroupStart extends Brick
{

    protected $label = 'Module Group - Start';

    protected $template_file_path = 'fewbricks.bricks.module-group-start';

    /**
     *
     */
    public function set_up()
    {

        $this->add_info_fields();
        $this->add_background_fields();

    }

    /**
     *
     */
    private function add_info_fields()
    {

        $this->add_field((new Tab('Info', 'info_tab', '2001291744a')));

        $this->add_field((new Message('', 'info', '2001291741a'))
            ->set_message('Use this module if you want to group a bunch of other modules. This wil enable you to for
            example set a background image in this module which will then be behind all the modules below this one.<p>
            Use the module "Module Group - End" to stop the background.')
        );

    }

    /**
     *
     */
    public function add_background_fields()
    {

        $this->add_field(new Tab('Background', 'background_tab', '2001291756a'));

        $this->add_field(
            (CommonFields::get_instance()->get_field('colors_1', '2002051353a'))
            ->set_name('background_color')
            ->set_label('Background color')
        );

    }

    /**
     *
     */
    private function get_background_color()
    {

        return $this->get_field_value('background_color');

    }

    /**
     * @return array|void
     */
    public function get_view_data()
    {

        return [
            'background_color' => $this->get_background_color(),
            'main_wrapper_css_classes' => 'ec-m ec-module-group',
        ];

    }

}
