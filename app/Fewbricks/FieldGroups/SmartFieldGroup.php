<?php

namespace App\Fewbricks\FieldGroups;

use App\Fewbricks\Bricks\Brick;
use App\Fewbricks\Traits\HasBrickLayouts;
use Fewbricks\ACF\Fields\FlexibleContent;
use function App\template;

class SmartFieldGroup extends FieldGroup
{

    /**
     *
     */
    use HasBrickLayouts;

    /**
     * @var array
     */
    protected $brick_layouts_settings = [
        'article' => [
            'layout_label' => 'Article',
            'layout_key' => '200210117a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Article',
            'brick_key' => '200210117b',
            'brick_name' => 'article',
        ],
        'flexible_columns' => [
            'layout_label' => 'Flexible Columns',
            'layout_key' => '2001022124a',
            'brick_class_name' => 'App\Fewbricks\Bricks\FlexibleColumns',
            'brick_key' => '2001022124b',
            'brick_name' => 'flexible_columns',
        ],
        'large_teaser' => [
            'layout_label' => 'Generic Teaser',
            'layout_key' => '2002071317a',
            'brick_class_name' => 'App\Fewbricks\Bricks\GenericTeaser1',
            'brick_key' => '2002071317b',
            'brick_name' => 'large_teaser',
        ],
        'teasers' => [
            'layout_label' => 'Teasers',
            'layout_key' => '2001071533a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Teasers',
            'brick_key' => '2001071533b',
            'brick_name' => 'teasers',
        ],
        'vimeo' => [
            'layout_label' => 'Video - Vimeo',
            'layout_key' => '2002130957a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Video\Embed\Vimeo',
            'brick_key' => '2002130957b',
            'brick_name' => 'vimeo',
        ],
        'youtube' => [
            'layout_label' => 'Video - YouTube',
            'layout_key' => '2002051343a',
            'brick_class_name' => 'App\Fewbricks\Bricks\Video\Embed\YouTube',
            'brick_key' => '2002051343b',
            'brick_name' => 'youtube',
        ],
        'module_group_start' => [
            'layout_label' => 'Module Group - Start',
            'layout_key' => '2001291610a',
            'brick_class_name' => 'App\Fewbricks\Bricks\ModuleGroupStart',
            'brick_key' => '2001291610p',
            'brick_name' => 'module_group_start',
        ],
        'module_group_end' => [
            'layout_label' => 'Module Group - End',
            'layout_key' => '2001291610y',
            'brick_class_name' => 'App\Fewbricks\Bricks\ModuleGroupEnd',
            'brick_key' => '2001291610r',
            'brick_name' => 'module_group_end',
        ],
    ];

    /**
     * @return $this
     */
    public function set_up()
    {

        $fc = new FlexibleContent('', 'modules', '1911292133a');

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

        if($this->in_container) {
            $brick->set_force_skip_wrap_in_container(true);
        }

    }

    /**
     * @param bool $echo
     * @return string Returns a string
     */
    public function render($echo = false)
    {

        $html = '';

        $bricks = $this->get_brick_layouts('modules');

        if(!empty($bricks)) {

            $view_data = [
                'bricks' => $bricks,
            ];

            $html = template('fewbricks.field-groups.smart-field-group', $view_data);

        }

        if($echo) {
            echo $html;
            return '';
        } else {
            return $html;
        }

    }

}
