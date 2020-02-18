<?php

namespace App\Fewbricks\Bricks\Links;

use Fewbricks\ACF\Fields\PostObject;
use Fewbricks\ACF\Fields\Text;

class Internal extends Link
{

    // @todo Docs: describe deprecation of this constant in favour of $name
    //const NAME = 'button_internal_link';

    // @todo Docs: describe what $name is used for
    // This will be used if no name is sent when instantiating a brick.
    protected $name = 'internal_link';

    // @todo Document this new feature
    protected $label = 'Internal Link';

    /**
     * @var array
     */
    protected $view_data_css_classes = [
        'ec-m-link--internal',
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

        $fields['target'] = (new PostObject('Target', 'target', '1911292055a'))
            ->set_required(true)
            ->set_post_type([
                'page',
                'post',
            ]);

        if(!$this->get_argument('hide_text_field', false)) {

            $fields['text'] = (new Text('Text', 'text', '1911292053a'))
                ->set_instructions('Leave empty to use the name of the target');

        }

        $fields['anchor_link'] = (new Text('Anchor link', 'anchor', '1911292058a'))
            ->set_instructions('If you want to create an anchor link to a specific element on the target page, enter the same value that you entered as "Element ID" for that element.');

        $this->add_fields($fields);

        parent::add_shared_fields();

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        $view_data = parent::get_view_data();

        /** @var WP_Post $target_object */
        $target_object = $view_data['href'];

        if(is_a($target_object, 'WP_Post')) {
            $view_data['href'] = get_permalink($target_object);
        } else {
            $view_data['href'] = false;
        }

        if(empty($view_data['text'])) {
            $view_data['text'] = get_the_title($target_object);
        }

        $anchor = $this->get_field_value('anchor');

        if(!empty($anchor)) {
            $view_data['href'] .= '#' . $anchor;
        }

        return $view_data;

    }

}
