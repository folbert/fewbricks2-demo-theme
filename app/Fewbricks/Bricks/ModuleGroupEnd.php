<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Tab;

class ModuleGroupEnd extends Brick
{

    protected $label = 'Module Group - End';

    protected $template_file_path = 'fewbricks.bricks.module-group-end';

    /**
     *
     */
    public function set_up()
    {

        $this->add_info_fields();

    }

    /**
     *
     */
    private function add_info_fields()
    {

        $this->add_field((new Tab('Info', 'info_tab', '2001291744t')));

        $this->add_field((new Message('', 'info', '2001291741e'))
            ->set_message('This module will stop any rules applied by the preceeding "Module Group - End".')
        );

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return [];

    }

}
