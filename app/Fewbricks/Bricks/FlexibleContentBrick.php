<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;

abstract class FlexibleContentBrick extends Brick {

    /**
     * @param FlexibleContent $flexible_content_field
     * @param array $layouts_settings
     * @return FlexibleContent
     */
    public function add_layouts($flexible_content_field, $layouts_settings)
    {

        foreach($layouts_settings AS $layout_settings_key => $layout_settings) {

            // @todo Doc that you can send false as label in order to get the label from the brick
            /** @var Layout $layout */
            $layout = new Layout($layout_settings['layout_label'], false, $layout_settings['layout_key']);

            $brick_class_name = __NAMESPACE__ . '\\' . $layout_settings['brick_class'];
            $brick = (new $brick_class_name($layout_settings['brick_key'], $layout_settings['brick_name']));

            $brick = $this->alter_brick_before_add($brick);

            $layout->add_brick($brick);

            $flexible_content_field->add_layout($layout);

        }

        return $flexible_content_field;

    }

    /**
     * @param $flexible_content_field_name
     * @return array
     */
    public function get_bricks_in_flexible_content($flexible_content_field_name)
    {

        $bricks = [];

        $flexible_content = $this->get_flexible_content_for_view($flexible_content_field_name);

        if($flexible_content->have_rows()) {

            while($flexible_content->have_rows()) {

                $flexible_content->the_row();

                /** @var Brick $brick */
                $brick = $flexible_content->get_brick_in_row();
                $brick->set_container_css_classes($this->container_css_classes);
                $brick->set_column_css_classes($this->column_css_classes);
                //$link = $this->get_child_brick();

                $this->alter_brick_before_detaching($brick);

                // Using detach_from_acf_loop(), we can render the brick outside have_rows/the_row loops.
                // If you rather want to, you could render the brick here and for example store the html in an array.
                // But by using the detach-function, you have access to the entire object in the template which is more powerful.
                $brick->detach_from_acf_loop();
                // $links_html[] = $link->render() //

                $bricks[] = $brick;

            }

        }

        return $bricks;

    }

    /**
     * @param $brick
     * @return mixed
     */
    protected function alter_brick_before_add($brick)
    {

        return $brick;

    }

    /**
     * @param $brick
     * @return mixed
     */
    protected function alter_brick_before_detaching($brick)
    {

        return $brick;

    }

}
