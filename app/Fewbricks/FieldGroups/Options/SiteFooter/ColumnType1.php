<?php

namespace App\Fewbricks\FieldGroups\Options\SiteFooter;

use App\Fewbricks\Bricks\LinkGroup;
use App\Fewbricks\FieldGroups\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;

class ColumnType1 extends FieldGroup
{

    /**
     * @return $this
     */
    public function set_up()
    {

        acf_add_options_sub_page([
            'page_title' => 'Site Footer',
            'menu_slug' => 'ec-site-settings-and-data--site-footer',
            'parent_slug' => 'ec-site-settings-and-data',
        ]);

        $this->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('options_page', '==', 'ec-site-settings-and-data--site-footer')
                )
        );

        $this->add_field(
            (new Text('Headline', 'headline', '1912942147a'))
            ->set_required(true)
        );

        $link_group = (new LinkGroup('1912022116a', 'links2'))
            ->set_label('Menu items')
            ->set_argument('hide_settings', true)
            ->set_argument('hide_link_style', true)
            ->set_argument('button_label', 'Add menu item');

        $this->add_brick($link_group);

        return $this;

    }

}
