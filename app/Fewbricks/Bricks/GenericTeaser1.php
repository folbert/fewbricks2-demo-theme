<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\Fields\Accordion;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Textarea;

class GenericTeaser1 extends Brick
{

    protected $label = 'Teaser - Generic';

    protected $template_file_path = 'fewbricks.bricks.generic-teaser-1';

    private $layout_choices = [
        'text-over-image' => 'Text over image',
        'text-below-image' => 'Text below image',
        'text-to-the-right' => 'Text to the right',
        'text-to-the-left' => 'Text to the left',
    ];

    /**
     *
     */
    public function set_up()
    {

        $this->add_content_fields();

    }

    public function add_content_fields()
    {

        $this->add_text_fields();
        $this->add_image_fields();
        $this->add_link_fields();
        $this->add_settings_fields();

    }

    /**
     *
     */
    private function add_text_fields()
    {

        $this->add_field(new Accordion('Text', 'text_accordion', '2001071539a'));
        $this->add_field(new Text('Headline', 'headline', '2001071540p'));
        $this->add_field(new Textarea('Text', 'text', '2001071608a'));
        $this->add_field((new Text('Button text', 'button_text', '2001292537a'))
            ->set_required(true));

    }

    /**
     *
     */
    private function add_link_fields()
    {

        $this->add_field(new Accordion('Link', 'link_accordion', '2001072052a'));
        $this->add_brick(
            (new Link('2001072053a', 'link'))
                ->set_argument('hide_text_field', true)
                ->set_argument('allow_no_link', false)
        );

    }

    /**
     *
     */
    private function add_image_fields()
    {

        $this->add_field(new Accordion('Image', 'image_accordion', '2001071539o'));
        $this->add_brick(
            (new Image('2001071629a', 'image'))
                ->set_argument('hide_backend_name', true)
                ->set_argument('require_main_image', false)
                ->set_argument('hide_custom_caption', true)
        );

    }

    /**
     * @param $keys_to_remove
     */
    public function remove_layout_choices($keys_to_remove) {

        foreach($keys_to_remove AS $key_to_remove) {

            unset($this->layout_choices[$key_to_remove]);

        }

    }

    /**
     *
     */
    private function add_settings_fields()
    {

        $this->add_field(new Accordion('Settings', 'settings_accordion', '2001291542a'));
        $this->add_field((new Select('Layout', 'layout', '2002060915a'))
            ->set_choices($this->layout_choices)
            ->set_allow_null(false)
            ->set_instructions('If "Text to the left" is available and you select it, we will make sure that the image is placed above the text on smaller screens where the horizontal layout collapses into a vertical layout.<br>If "Text to the left" or "Text to the right" is available and you select it and also upload an image, we will make the image the same height as the text column and zoom the image. The zoom will depend on the amount of text which will affect the height of the content column.')
        );
        $this->add_backend_name_field('2001291542p');

    }

    /**
     * @return string
     */
    private function get_main_wrapper_css_classes()
    {

        $css_classes = [];
        $css_classes[] = 'ec-m';

        if($this->is_standalone) {
            $css_classes[] = 'ec-m--standalone';
        }

        $css_classes[] = 'ec-m-generic-teaser-1';
        $css_classes[] = 'ec-m-generic-teaser-1--' . $this->get_field_value('layout');

        if($this->is_standalone) {
            $css_classes[] = 'ec-m-generic-teaser-1--standalone';
        }

        return implode($css_classes, ' ');

    }

    /**
     *
     */
    private function set_wrapping_elms_css_classes() {

        if($this->is_standalone) {

            $this->set_container_css_classes(['container']);
            $this->set_row_css_classes(['row']);

            if(!$this->is_horizontal_layout()) {

                $this->set_column_css_classes(['col-md-12']);

            } else {

                $this->set_column_css_classes([]);

            }

        }

    }

    /**
     * @return array
     */
    private function get_horizontal_layout_view_data()
    {

        $view_data = [];

        $view_data['image_col_css_classes'] = 'col-md-7';
        $view_data['content_col_css_classes'] = 'col-md-5';

        if($this->get_field_value('layout') === 'text-to-the-left') {

            $view_data['content_col_css_classes'] .= ' order-md-first';

        }

        return $view_data;

    }

    /**
     * @return mixed
     */
    private function get_image_brick()
    {

        return $this->get_child_brick('\App\Fewbricks\Bricks\Image', 'image')
            ->set_column_css_classes($this->column_css_classes)
            ->set_container_css_classes($this->container_css_classes)
            ->set_picture_element_is_forced(true)
            ->set_is_standalone(false);

    }

    /**
     * @return bool
     */
    private function is_horizontal_layout()
    {

        return in_array($this->get_field_value('layout'), [
            'text-to-the-right',
            'text-to-the-left',
        ]);

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        $view_data = $this->get_field_values([
            'headline',
            'text',
            'button_text',
        ]);

        $view_data['link_data'] = $this->get_child_brick('\App\Fewbricks\Bricks\Link', 'link')->get_view_data();

        $view_data['raw_text'] = trim(strip_tags($view_data['text']));

        $view_data['main_wrapper_css_classes'] = $this->get_main_wrapper_css_classes();

        $view_data['image_brick'] = $this->get_image_brick();

        if(!($view_data['image_brick'])->has_image()) {
            $view_data['main_wrapper_css_classes'] .= ' ec-m-generic-teaser-1--no-image';
        }

        $view_data['is_horizontal_layout'] = $this->is_horizontal_layout();

        if($this->is_horizontal_layout()) {
            $view_data = array_merge($view_data, $this->get_horizontal_layout_view_data());
        }

        $this->set_wrapping_elms_css_classes();

        return $view_data;

    }

}
