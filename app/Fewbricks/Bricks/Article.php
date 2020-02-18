<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\FieldGroups\SmartFieldGroup;
use App\Fewbricks\Traits\HasBrickLayouts;
use Fewbricks\ACF\Fields\FlexibleContent;

class Article extends Brick
{

    /**
     *
     */
    use HasBrickLayouts;

    /**
     * @todo Describe how to use this
     * @var bool
     */
    protected $template_file_path = 'fewbricks.bricks.article';

    /**
     * @var array
     */
    protected $default_column_css_classes = ['col-md-8'];

    /**
     * @var array
     */
    protected $brick_layouts_settings = [
        'image' => [
            'layout_label' => 'Image',
            'layout_key' => '2002101555a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Image',
            'brick_key' => '2002101555b',
            'brick_name' => 'image',
            'render' => [
                'column_css_classes' => ['col-md-12'],
            ],
        ],
        'link_group' => [
            'layout_label' => 'Links',
            'layout_key' => '2002130951a',
            'brick_class_name' => 'App\Fewbricks\Bricks\LinkGroup',
            'brick_key' => '2002130951b',
            'brick_name' => 'link_group',
            'render' => [
                'column_css_classes' => 'default',
            ],
        ],
        'wysiwyg' => [
            'layout_label' => 'WYSIWYG',
            'layout_key' => '2001071533a',
            'brick_class_name' => 'App\Fewbricks\Bricks\WYSIWYG',
            'brick_key' => '2001071533b',
            'brick_name' => 'wysiwyg',
            'render' => [
                'column_css_classes' => 'default',
            ],
        ],
        'youtube' => [
            'layout_label' => 'Video - YouTube',
            'layout_key' => '2002051343a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Video\Embed\YouTube',
            'brick_key' => '2002051343b',
            'brick_name' => 'youtube',
            'render' => [
                'column_css_classes' => 'default',
            ],
        ],
    ];

    /**
     * @return $this
     */
    public function set_up()
    {

        $fc = new FlexibleContent('', 'modules', '2002101525a');

        $fc->add_brick_layouts($this->get_brick_layouts_settings());

        $fc->set_button_label($this->get_argument('button_label', 'Add module'));

        $this->add_field($fc);

        return $this;

    }

    /**
     * @param Brick $brick
     */
    protected function alter_brick_before_detach($brick)
    {

        if(!isset($this->brick_layouts_settings[$brick->row_layout_name]['render'])) {
            return;
        }

        $render_settings = $this->brick_layouts_settings[$brick->row_layout_name]['render'];

        if(isset($render_settings['column_css_classes'])) {

            if($render_settings['column_css_classes'] === 'default') {

                $column_css_classes = $this->default_column_css_classes;

            } else {

                $column_css_classes = $render_settings['column_css_classes'];

            }

            $brick->set_column_css_classes($column_css_classes);

        }

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return [
            'bricks' => $this->get_brick_layouts($this->name . '_modules'),
        ];

    }



}
