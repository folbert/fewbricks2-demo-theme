<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\CommonFields;
use App\Fewbricks\Traits\HasBrickLayouts;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Accordion;
use Fewbricks\ACF\Fields\Extensions\FewbricksHidden;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Message;

class FlexibleColumn extends Brick
{

    use HasBrickLayouts;

    /**
     * @var string
     */
    protected $template_file_path = 'fewbricks.bricks.flexible-column';

    /**
     * @var array
     */
    protected $brick_layouts_settings = [
        'headline' => [
            'layout_label' => false,
            'layout_key' => '2001051932a',
            'brick_class_name' => 'Headline',
            'brick_key' => '2001051932b',
            'brick_name' => 'headline',
        ],
        'image' => [
            'layout_label' => false,
            'layout_key' => '19122249a',
            'brick_class_name' => 'Image',
            'brick_key' => '19122249b',
            'brick_name' => 'image',
        ],
        'links1' => [
            'layout_label' => false,
            'layout_key' => '1911292234a',
            'brick_class_name' => 'LinkGroup',
            'brick_key' => '1911292116a',
            'brick_name' => 'links1',
        ],
        'simple_list' => [
            'layout_label' => false,
            'layout_key' => '1912202113a',
            'brick_class_name' => 'SimpleList',
            'brick_key' => '1912212113o',
            'brick_name' => 'simple_list',
        ],
        'embed_youtube' => [
            'layout_label' => false,
            'layout_key' => '1912301700i',
            'brick_class_name' => 'Video\Embed\YouTube',
            'brick_key' => '1912301700o',
            'brick_name' => 'embed_youtube',
        ],
        'embed_vimeo' => [
            'layout_label' => false,
            'layout_key' => '1912301700x',
            'brick_class_name' => 'Video\Embed\Vimeo',
            'brick_key' => '1912301700z',
            'brick_name' => 'embed_vimeo',
        ],
        'wysiwyg' => [
            'layout_label' => false,
            'layout_key' => '2001051718b',
            'brick_class_name' => 'WYSIWYG',
            'brick_key' => '2001051718a',
            'brick_name' => 'wysiwyg',
        ],
    ];

    /**
     *
     */
    public function set_up() {

        $this->add_content_fields();
        $this->add_settings();

    }

    /**
     *
     */
    private function add_content_fields() {

        $this->add_field(new Accordion($this->get_argument('tabs_prefix', '') . 'Column content', 'content_accordion', '2001022241a'));

        $flexible_content = new FlexibleContent('', 'content', '2001022242a');

        $content_fields_to_exclude = $this->get_argument('content_fields_to_exclude', []);

        foreach($this->brick_layouts_settings AS $layout_settings) {

            if(in_array($layout_settings['layout_key'], $content_fields_to_exclude)) {
                continue;
            }

            // Name is set to false since we wil add a brick later on which will give its name to the layout
            $layout = new Layout($layout_settings['layout_label'], false, $layout_settings['layout_key']);

            $brick_class_name = 'App\Fewbricks\Bricks\\' . $layout_settings['brick_class_name'];
            $brick = new $brick_class_name($layout_settings['brick_key'], $layout_settings['brick_name']);

            $layout->add_brick($brick);

            $flexible_content->add_layout($layout);

        }

        $flexible_content->set_button_label('Add module to column');

        $this->add_flexible_content($flexible_content);

    }

    /**
     *
     */
    private function add_settings() {

        //$this->add_field(new Tab($this->get_argument('tabs_prefix', '') . 'Column settings', 'settings_tab', '2001022127a'));
        $this->add_field(new Accordion($this->get_argument('tabs_prefix', '') . 'Column settings', 'settings_accordion', '2001022241o'));

        if(!$this->get_argument('hide_backend_name', false)) {
            $this->add_field(CommonFields::get_instance()->get_field('backend_name', '2001022213a'));
        }

        $this->add_column_width_settings();

        $this->add_field(
            CommonFields::get_instance()->get_field('column_offset_1', '2001022207a')
            ->set_name('column_offset')
        );

        $this->add_field(CommonFields::get_instance()->get_field('element_id', '2001022236a'));

    }

    /**
     *
     */
    private function add_column_width_settings() {

        $forced_column_width = $this->get_argument('forced_column_width', false);
        $allowed_column_widths = $this->get_argument('allowed_column_widths', false);

        if (!empty($forced_column_width)) {

            $this->add_field(
                (new FewbricksHidden('Forced column width', 'column_width', '2001022129a'))
                ->set_default_value($forced_column_width)
            );

        } else {

            $shared_field = CommonFields::get_instance()->get_field('column_width_1', '2001022129c');

            if(!empty($allowed_column_widths)) {

                $existing_choices = $shared_field->get_choices();

                foreach ($existing_choices AS $existing_choice_value => $existing_choice_text) {

                    if (!in_array($existing_choice_value, $allowed_column_widths)) {
                        unset($existing_choices[$existing_choice_value]);
                    }

                }

                $shared_field->set_choices($existing_choices);

            }

            $shared_field->set_name('column_width');

            $this->add_field($shared_field);

        }

        $this->add_field((new Message('Attention', 'small_col_warning', '2001022201i'))
            ->set_message('<span style="color:red">Consider using a larger value for the column width. If you do use the selected value, be careful when adding other sub modules than images to the column since they are not intended to be added to such narrow columns.</span>')
            ->add_conditional_logic_rule_group((new ConditionalLogicRuleGroup())
                ->add_conditional_logic_rule(new ConditionalLogicRule('2001022129c', '<', '4'))
            )
        );

    }

    /**
     * @return string
     */
    public function get_column_offset_css_classes()
    {

        $css_classes = [];

        $offset = $this->get_field_value('column_offset');

        if(!empty($offset)) {
            $css_classes[] = 'offset-md-' . $offset;
        }

        return $css_classes;

    }

    /**
     * @return string
     */
    public function get_css_classes()
    {

        $css_classes_array = array_merge(
            $this->get_column_css_classes(),
            $this->get_column_offset_css_classes()
        );

        return implode(' ', $css_classes_array);

    }

    /**
     * @param null $void1
     * @param null $void2
     * @param null $void3
     * @return array
     */
    public function get_column_css_classes($void1 = null, $void2 = null, $void3 = null)
    {

        return ['col-md-' . $this->get_field_value('column_width')];

    }

    /**
     *
     */
    public function get_bricks()
    {

        $bricks = [];

        $flexible_content = $this->get_flexible_content_for_view('content');
        $column_css_classes = $this->get_column_css_classes();

        if($flexible_content->have_rows()) {

            while($flexible_content->have_rows()) {

                $flexible_content->the_row();

                /** @var Brick $brick */
                $brick = $flexible_content->get_brick_in_row();

                $brick->set_container_css_classes($this->container_css_classes);
                $brick->set_column_css_classes($column_css_classes);
                $brick->set_is_standalone(false);

                $brick->detach_from_acf_loop();

                $bricks[] = $brick;

            }

        }

        return $bricks;

    }

    /**
     * @return array|void
     */
    public function get_view_data()
    {

        return [
            'main_wrapper_css_classes' => $this->get_css_classes(),
            'bricks' => $this->get_bricks(),
        ];

    }

}
