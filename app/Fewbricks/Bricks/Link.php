<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\Bricks\Links\Anything;
use App\Fewbricks\Bricks\Links\Email;
use App\Fewbricks\Bricks\Links\File;
use App\Fewbricks\Bricks\Links\Internal;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Select;

/**
 * Class Link
 * @package App\Fewbricks\Bricks
 */
class Link extends Brick
{

    protected $template_file_path = 'fewbricks.bricks.link';

    /**
     *
     */
    public function set_up()
    {

        $this->add_link_type_field();

        $this->add_brick(
            (new Anything('2001072053t', 'link'))
                ->add_argument('hide_style', $this->get_argument('hide_style', true))
                ->add_argument('hide_text_field', $this->get_argument('hide_text_field', false))
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                        new ConditionalLogicRule('2001072050a', '==', 'Anything')
                    )
                )
        );

        $this->add_brick(
            (new Email('2001072053u', 'link'))
                ->add_argument('hide_style', $this->get_argument('hide_style', true))
                ->add_argument('hide_text_field', $this->get_argument('hide_text_field', false))
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                        new ConditionalLogicRule('2001072050a', '==', 'Email')
                    )
                )
        );

        $this->add_brick(
            (new File('2001072053v', 'link'))
                ->add_argument('hide_style', $this->get_argument('hide_style', true))
                ->add_argument('hide_text_field', $this->get_argument('hide_text_field', false))
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                        new ConditionalLogicRule('2001072050a', '==', 'File')
                    )
                )
        );

        $this->add_brick(
            (new Internal('2001072053x', 'link'))
                ->add_argument('hide_style', $this->get_argument('hide_style', true))
                ->add_argument('hide_text_field', $this->get_argument('hide_text_field', false))
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                        new ConditionalLogicRule('2001072050a', '==', 'Internal')
                    )
                )
        );

    }

    /**
     *
     */
    private function add_link_type_field()
    {

        $link_type_choices = [];

        if($this->get_argument('allow_no_link')) {
            $link_type_choices[''] = 'No link';
        }

        // Key = ClassName
        $link_type_choices['Anything'] = 'Anything';
        $link_type_choices['Email'] = 'E-mail';
        $link_type_choices['File'] = 'File';
        $link_type_choices['Internal'] = 'Internal';

        $this->add_field(
            (new Select('Link type', 'link_type', '2001072050a'))
                ->set_choices($link_type_choices)
        );

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $link_type = $this->get_field_value('link_type');

        if(empty($link_type)) {
            return false;
        }

        $link_class_name = '\App\Fewbricks\Bricks\Links\\' . $this->get_field_value('link_type');

        /** @var Links\Link $brick */
        $brick = $this->get_child_brick($link_class_name, 'link');

        return array_merge([
            'main_wrapper_css_classes' => 'ec-m ec-m-link',
        ], $brick->get_view_data());

    }

}
