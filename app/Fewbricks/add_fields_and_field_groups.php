<?php

namespace App\Fewbricks;

use App\Fewbricks\FieldGroups\SmartFieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;

/**
 *
 */
add_action('fewbricks/init', function() {

    require_once 'add_options.php';

    /**
     * Lets set all field groups here to avoid creating a bunch of instances.
     * This could of course be done for example in the controller for each page type but that would mean
     * creating instances of field groups etc. over and over. This way is probably better for performance.
     */

    (new SmartFieldGroup(__('Main content', 'echo-crate-theme'), '1911281650a'))
        ->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
        )
        ->set_field_names_prefix('main_content_')
        ->set_hide_on_screen('all')
        ->set_show_on_screen(['permalink', 'page_attributes'])
        ->set_up()
        ->register();

    (new SmartFieldGroup(__('Main content', 'echo-crate-theme'), '2002101512a'))
        ->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'post')
                )
        )
        ->add_to_layout_settings_whitelist(['article'])
        ->set_field_names_prefix('main_content_')
        ->set_hide_on_screen('all')
        ->set_show_on_screen('permalink')
        ->set_up()
        ->register();

    (new SmartFieldGroup(__('Secondary content', 'echo-crate-theme'), '2002121549a'))
        ->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('page_template', '==', 'views/template-two-columns.blade.php')
                )
        )
        ->add_to_layout_settings_blacklist(['teasers', 'large_teaser'])
        ->set_field_names_prefix('secondary_content_')
        ->set_hide_on_screen('all')
        ->set_show_on_screen('permalink')
        ->set_up()
        ->register();

});
