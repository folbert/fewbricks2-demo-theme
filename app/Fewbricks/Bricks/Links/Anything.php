<?php

namespace App\Fewbricks\Bricks\Links;

use Fewbricks\ACF\Fields\Text;

class Anything extends Link
{

    // @todo Docs: describe what $name is used for
    // This will be used if no name is sent when instantiating a brick.
    protected $name = 'anything_link';

    // @todo Document this new feature
    protected $label = 'Link to anything';

    protected $view_data_css_classes = [
        'ec-m-link--anything',
    ];

    /**
     *
     */
    public function set_up()
    {

        $this->set_fields();

        parent::set_up();

    }

    /**
     *
     */
    private function set_fields()
    {

        $fields = [];

        if(!$this->get_argument('hide_text_field', false)) {

            $fields[] = ((new Text('Text', 'text', '1912031757u'))
                ->set_required(true));

        }

        $fields[] = ((new Text('Target', 'target', '1912031757v'))
            ->set_instructions('Enter any URL you want in this field. We wont validate it in any way.')
            ->set_required(true));

        $this->add_fields($fields);

        parent::add_shared_fields();

    }

    /**
     * @return array|void
     */
    public function get_view_data()
    {

        $view_data = parent::get_view_data();

        if(empty($view_data['text'])) {
            $view_data['text'] = $view_data['href'];
        }

        return $view_data;

    }

}
