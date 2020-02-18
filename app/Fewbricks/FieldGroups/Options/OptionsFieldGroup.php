<?php

namespace App\Fewbricks\FieldGroups\Options;

use App\Fewbricks\FieldGroups\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;

class OptionsFieldGroup extends FieldGroup
{

    /**
     * @param $page_title
     * @param $menu_slug
     * @param $parent_slug
     * @param array $settings
     */
    protected function add_options_sub_page($page_title, $menu_slug, $parent_slug, $settings = [])
    {

        acf_add_options_sub_page(array_merge([
            'page_title' => $page_title,
            'menu_slug' => $menu_slug,
            'parent_slug' => $parent_slug,
        ], $settings));

    }

    /**
     * @param $menu_slug
     */
    protected function add_to_options_page($menu_slug)
    {

        $this->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('options_page', '==', $menu_slug)
                )
        );

    }

}
