<?php

namespace App\Fewbricks\Bricks\Links;

use Fewbricks\ACF\Fields\Text;

class Email extends Link
{

    // @todo Docs: describe what $name is used for
    // This will be used if no name is sent when instantiating a brick.
    protected $name = 'email_link';

    // @todo Document this new feature
    protected $label = 'E-mail Link';

    protected $view_data_css_classes = [
        'ec-m-link--email',
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

            $fields[] = (new Text('Text', 'text', '1911302319u'))
                ->set_instructions('Leave empty to use e-mail address for text');

        }

        $fields[] = (new \Fewbricks\ACF\Fields\Email('E-mail address', 'target', '1911302319b'))
        ->set_required(true);

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

        $view_data['href'] = 'mailto:' . $view_data['href'];

        return $view_data;

    }

}
