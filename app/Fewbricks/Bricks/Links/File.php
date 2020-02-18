<?php

namespace App\Fewbricks\Bricks\Links;

use Fewbricks\ACF\Fields\Text;

class File extends Link
{

    // @todo Docs: describe what $name is used for
    // This will be used if no name is sent when instantiating a brick.
    protected $name = 'email_link';

    // @todo Document this new feature
    protected $label = 'File Link';

    protected $view_data_css_classes = [
        'ec-m-link--download',
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

            $fields['text'] = (new Text('Text', 'text', '1911302319a'))
                ->set_instructions('Leave empty to use the title of the file. If title is empty, the name of the file will be used.');

        }

        $fields['target'] = (new \Fewbricks\ACF\Fields\File('File', 'target', '1912012125a'))
        ->set_required(true);

        $this->add_fields($fields);

        parent::add_shared_fields();

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $view_data = parent::get_view_data();

        if(empty($view_data['href'])) {
            return false;
        }

        if(empty($view_data['text']) && !empty($view_data['href'])) {

            if(!empty($view_data['target']['title'])) {
                $view_data['text'] = $view_data['href']['title'];
            } else {
                $view_data['text'] = $view_data['href']['name'];
            }

        }

        $view_data['href'] = $view_data['href']['url'];

        return $view_data;
    }

}
