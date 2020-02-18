<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Radio;
use Fewbricks\ACF\Fields\Repeater;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Tab;
use Fewbricks\ACF\Fields\Text;

/**
 * Class SimpleList
 * @package App\Fewbricks\Bricks
 */
class SimpleList extends Brick
{

    /**
     * @var string
     */
    protected $label = 'List - Simple';

    /**
     * @var string
     */
    protected $template_file_path = 'fewbricks.bricks.simple-list';

    /**
     * @var int
     */
    private $max_nesting_levels = 3;

    /**
     * @var int
     */
    private $nesting_level = 1;

    /**
     *
     */
    public function set_up() {

        $this->add_content_fields();
        $this->add_settings_fields();

    }

    /**
     * @param $nesting_level
     * @return SimpleList
     */
    public function set_nesting_level($nesting_level) {

        $this->nesting_level = $nesting_level;
        return $this;

    }

    /**
     *
     */
    private function add_content_fields()
    {

        $this->add_field(new Tab('Content', 'content_tab', '1912202153a'));

        $repeater = (new Repeater('List Items', 'items', '1912202110a'))
            ->set_button_label('Add to level ' . $this->nesting_level)
            ->set_layout('row')
            ->set_min(1);

        // Only items if we have reached max nesting levels so no need for settings.
        if($this->nesting_level < $this->max_nesting_levels) {

            $repeater->add_field((new Radio('Type', 'type', '1912202212a'))
                ->set_choices([
                    'item' => 'Item',
                    'sub_list' => 'Sub list',
                ]));

        }

        $text_field = (new Text('Text', 'text', '1912202111o'))
            ->set_required(true);

        // Only items if we have reached max nesting levels so no need for conditional logic.
        if($this->nesting_level < $this->max_nesting_levels) {

            $text_field->add_conditional_logic_rule_group((new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                new ConditionalLogicRule('1912202212a', '==', 'item')
            ));

        }

        $repeater->add_field($text_field);

        if($this->nesting_level < $this->max_nesting_levels) {

            $repeater->add_brick((new self('1912202223a', str_repeat('sub_', $this->nesting_level) . 'list'))
                ->add_conditional_logic_rule_group((new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                    new ConditionalLogicRule('1912202212a', '==', 'sub_list')
                ))
                ->set_nesting_level($this->nesting_level+1));

        }

        $this->add_repeater($repeater);

    }

    /**
     *
     */
    private function add_settings_fields()
    {

        $this->add_field(new Tab('Settings', 'settings_tab', '1912202153o'));

        $this->add_field((new Select('List type and style', 'list_type_and_style', '1912202155a'))
            ->set_choices([
                'ul--circle' => 'Unordered - Circle',
                'ul--square' => 'Unordered - Square',
                'ol--1' => 'Ordered - Numbers',
                'ol--A' => 'Ordered - Alphabetically Uppercase',
                'ol--a' => 'Ordered - Alphabetically Lowercase',
            ]));

    }

    /**
     *
     */
    private function get_type_and_style()
    {

        if($this->nesting_level == 1) {
            $value = $this->get_field_value('list_type_and_style');
        } else {
            $selector = str_repeat('sub_', $this->nesting_level-1) . 'list_list_type_and_style';
            $value = $this->get_sub_field_value($selector);
        }

        list($list_tag_name, $list_type) = explode('--', $value);

        return [
            'list_tag_name' => $list_tag_name,
            'list_type' => $list_type,
        ];

    }

    /**
     * @return array|bool|void
     */
    private function get_item_data()
    {

        $type = $this->get_sub_field_value('type');

        if($type === 'sub_list') {

            $item_data = (new self('', str_repeat('sub_', $this->nesting_level) . 'list'))
                ->set_nesting_level($this->nesting_level + 1)
                ->get_view_data();

        } else {

            $item_data = $this->get_sub_field_value('text');

        }

        return $item_data;

    }

    /**
     * @return array|void
     */
    public function get_view_data() {

        $data['template_file_path'] = $this->template_file_path;
        $data = array_merge($this->get_type_and_style(), $data);
        $data['items'] = [];

        if($this->have_rows('items')) {

            while($this->have_rows('items')) {

                $this->the_row();

                $data['items'][] = $this->get_item_data();

            }

        }

        return $data;

    }

}

