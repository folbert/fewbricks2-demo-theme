<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\Helpers\Images;
use App\Fewbricks\Bricks\Traits\LazyLoadTrait;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Tab;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\TrueFalse;

/**
 * Class Image
 * @package App\Fewbricks\Bricks
 */
class Image extends Brick
{

    use LazyLoadTrait;

    /**
     * @var string
     */
    protected $default_size = 'ec_1140w';

    /**
     * @var string
     */
    protected $label = 'Image';

    /**
     * @var string
     */
    protected $template_file_path = 'fewbricks.bricks.image';

    /**
     * @var string
     */
    private $template_file_path_picture = 'fewbricks.bricks.picture';

    /**
     * @var bool
     */
    protected $picture_element_is_forced = false;

    /**
     *
     */
    public function set_up() {

        $this->add_main_image();
        $this->add_additional_sizes();
        $this->add_custom_meta_fields();
        $this->add_settings_fields();

    }

    /**
     *
     */
    private function add_main_image()
    {

        $additional_sizes = $this->get_additional_sizes_settings();

        if(count($additional_sizes) > 0) {

            $this->add_field(new Tab('Main Image', 'main_image_tab', '1912271656u'));
            $label = '';

        } else {

            $label = 'Main Image';

        }

        $this->add_field((new \Fewbricks\ACF\Fields\Image($label, 'image_main', '1912232248a'))
            ->set_required($this->get_argument('require_main_image', true))
            ->set_preview_size('large')
        );

    }

    /**
     *
     */
    private function add_additional_sizes()
    {

        $additional_sizes = $this->get_additional_sizes_settings();

        if(count($additional_sizes) === 0) {
            return;
        }

        $this->add_field(new Tab('Additional Images', 'additional_images_tab', '1912271656i'));

        $this->add_field((new Message('', 'additional_images_message', '1912282147u'))
            ->set_message('Here you can specify images that should be displayed on specific screen sizes. You should only use this if you want to display a completely different image on narrower screens. For example, if the main image is wide and not very high, it may not look good when scaled down on narrow screens. In those cases, you can upload for example a square version of the wide image to display on narrow screens.<p>Note that if you want to use the same narrow version image for all narrow screens below, you only need to set the image on the top most field. It will then be used for all screens from 0 up to the specified width.</p>')
        );

        foreach($additional_sizes AS $additional_size_name => $additional_size_settings) {

            $this->add_field((new \Fewbricks\ACF\Fields\Image($additional_size_settings['label'], 'image_' . $additional_size_name, $additional_size_settings['key']))
                ->set_preview_size($additional_size_settings['preview_size'])
            );

        }

    }

    /**
     * @return array
     */
    private function get_additional_sizes_settings()
    {

        return [
            'up_to_sm' => [
                'label' => 'Image for screens up to 767px wide',
                'key' => '1912272338a',
                'breakpoint' => 'sm',
                'preview_size' => 'ec_900w',
            ],
            'up_to_xs' => [
                'label' => 'Image for screens up to 575px wide',
                'key' => '1912272338o',
                'breakpoint' => 'xs',
                'preview_size' => 'ec_576w',
            ]
        ];

    }

    /**
     *
     */
    private function add_settings_fields() {

        if($this->add_backend_name_field('20001071503a')) {

            $this->add_field_before_field_by_key((new Tab('Settings', 'settings_tab', '2001071505a')),
                '20001071503a');

        }

    }

    /**
     * @return array
     */
    private function get_custom_meta_settings()
    {

        // 'name_of_meta_in_img_array' => 'field_name
        $custom_meta_settings = [
            'alt' => [
                'true_false_label' => 'Use custom alt-text',
                'true_false_description' => 'Check this if you want to enter a custom alt text instead of the one set in the media library.',
                'text_label' => 'Custom alt-text',
                'key_base' => '1912232310o',
                'required' => false,
            ],
        ];

        if(!$this->get_argument('hide_custom_caption', false)) {

            $custom_meta_settings['caption'] = [
                'true_false_label' => 'Use custom caption',
                'true_false_description' => 'Check this if you want to enter a custom caption instead of the one set in the media library.',
                'text_label' => 'Custom caption',
                'key_base' => '1912232311o',
                'required' => false,
            ];

        }

        return $custom_meta_settings;

    }

    /**
     *
     */
    private function add_custom_meta_fields() {

        $custom_meta_settings = $this->get_custom_meta_settings();

        if(empty($custom_meta_settings)) {
            return;
        }

        $this->add_field(new Tab('Meta data', 'meta_data_tab', '1912271656a'));

        foreach($this->get_custom_meta_settings() AS $custom_meta_name => $custom_meta_settings) {

            $this->add_field((new TrueFalse($custom_meta_settings['true_false_label'], 'use_custom_' . $custom_meta_name, $custom_meta_settings['key_base'] . 'q'))
                ->set_instructions($custom_meta_settings['true_false_description']));

            $this->add_field((new Text($custom_meta_settings['text_label'], 'custom_' . $custom_meta_name, $custom_meta_settings['key_base'] . 'p'))
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())->add_conditional_logic_rule(
                        new ConditionalLogicRule($custom_meta_settings['key_base'] . 'q', '==', '1')
                    )
                )
                ->set_required($custom_meta_settings['required'])
            );

        }

    }

    /**
     * @param $img_data
     * @return mixed
     */
    private function apply_custom_meta($img_data)
    {

        foreach($this->get_custom_meta_settings() AS $custom_meta_name => $custom_meta_settings) {

            if($this->get_field_value('use_custom_' . $custom_meta_name)) {
                $img_data[$custom_meta_name] = $this->get_field_value('custom_' . $custom_meta_name);
            }

        }

        return $img_data;

    }

    /**
     * @return string
     */
    private function get_sizes_attribute() {

        if($this->get_argument('skip_sizes_attribute', false)) {
            return false;
        }

        return Images::get_sizes($this->get_column_css_classes(), $this->container_css_classes, 'string');

    }

    /**
     * @param $image_id
     * @return bool|string
     */
    private function get_srcset_attribute($image_id) {

        if($this->get_argument('skip_srcset_attribute', false)) {
            return false;
        }

        return wp_get_attachment_image_srcset($image_id, 'full');

    }

    /**
     * @param $name
     * @return array
     */
    private function get_image_data($name)
    {

        // $wp_img_data will be false if the image has been deleted from the media library
        $wp_img_data = $this->get_field_value('image_' . $name);

        if(empty($wp_img_data)) {
            return [];
        }

        $wp_img_data = $this->apply_custom_meta($wp_img_data);

        $img_data = [
            'wp_img_data' => $wp_img_data,
            'alt' => $wp_img_data['alt'],
            'extra_attributes' => [
                'class' => 'img-fluid',
            ],
        ];

        $srcset = $this->get_srcset_attribute($wp_img_data['ID']);
        if(!empty($srcset)) {
            $img_data['extra_attributes']['srcset'] = $srcset;
        }

        $sizes = $this->get_sizes_attribute();
        if(!empty($sizes)) {
            $img_data['extra_attributes']['sizes'] = $sizes;
        }

        $img_data['src'] = wp_get_attachment_image_src($wp_img_data['ID'], $this->default_size)[0];

        if($this->do_lazy_load()) {

            $img_data = $this->prepare_image_data_for_lazy_load($img_data);

        }

        return $img_data;

    }

    /**
     * @param array $img_data
     * @return array
     */
    private function prepare_image_data_for_lazy_load($img_data)
    {

        $img_data['extra_attributes']['data-src'] = $img_data['src'];
        $img_data['extra_attributes']['data-ec-do-lazy-load'] = 1;

        //$img_data['src'] = wp_get_attachment_image_src($img_data['wp_img_data']['ID'], 'ec_200w')[0];
        $img_data['src'] = '';

        if(isset($img_data['extra_attributes']['srcset'])) {

            $img_data['extra_attributes']['data-srcset'] = $img_data['extra_attributes']['srcset'];
            unset($img_data['extra_attributes']['srcset']);

        }

        if(isset($img_data['extra_attributes']['sizes'])) {

            $img_data['extra_attributes']['data-sizes'] = $img_data['extra_attributes']['sizes'];
            unset($img_data['extra_attributes']['sizes']);

        }

        return $img_data;

    }

    /**
     * @param $name
     * @param $data
     * @param bool $previous_data
     * @return array
     */
    private function get_source_data($name, $data, $previous_data = false) {

        $return_data = [];

        $img_data = $this->get_field_value('image_' . $name);

        if(empty($img_data)) {

            if(!empty($previous_data)) {

                $return_data['media'] = Images::get_source_media_attribute($data['breakpoint']);
                $return_data['extra_attributes'] = [];
                $return_data['extra_attributes']['sizes'] =
                    Images::get_size_for_breakpoint(
                        $data['breakpoint'], $this->column_css_classes, $this->container_css_classes
                    );

                if($this->do_lazy_load()) {

                    $return_data['extra_attributes']['data-srcset'] = $previous_data['extra_attributes']['data-srcset'];
                    $return_data['extra_attributes']['data-sizes'] = $return_data['extra_attributes']['sizes'];
                    unset($return_data['extra_attributes']['sizes']);

                } else {

                    $return_data['extra_attributes']['srcset'] = $previous_data['extra_attributes']['srcset'];

                }

            }

        } else {

            $return_data = [
                'media' => Images::get_source_media_attribute($data['breakpoint']),
                'extra_attributes' => [
                    'srcset' => wp_get_attachment_image_srcset($img_data['ID'], 'full'),
                    'sizes' => Images::get_size_for_breakpoint($data['breakpoint'], $this->column_css_classes, $this->container_css_classes),
                ]
            ];

            if ($this->do_lazy_load()) {

                $return_data['extra_attributes'] = [
                    'data-srcset' => $return_data['extra_attributes']['srcset'],
                    'data-sizes' => $return_data['extra_attributes']['sizes'],
                ];

                unset($return_data['extra_attributes']['srcset']);
                unset($return_data['extra_attributes']['sizes']);

            }

        }

        return $return_data;

    }

    /**
     * @return array
     */
    private function get_sources_data()
    {

        $data = [];

        $previous_size_data = false;

        foreach($this->get_additional_sizes_settings() AS $additional_size_name => $additional_size_data) {

            $fetched_additional_size_data = $this->get_source_data($additional_size_name, $additional_size_data, $previous_size_data);

            if(!empty($fetched_additional_size_data)) {

                $data[$additional_size_name] = $fetched_additional_size_data;
                $previous_size_data = $fetched_additional_size_data;

            }

        }

        // reverse to get the sources in smallest to largest
        return array_reverse($data);

    }

    /**
     * @param $force
     * @return Image
     */
    public function set_picture_element_is_forced($force)
    {

        $this->picture_element_is_forced = $force;

        return $this;

    }

    /**
     * @return bool
     */
    public function has_image()
    {

        return !empty($this->get_field_value('image_main'));

    }

    /**
     * @param array $view_data
     * @return array
     */
    private function apply_extra_wrapper_view_data(array $view_data)
    {

        $img_data = $view_data['img']['wp_img_data'];

        if($this->template_file_path === $this->template_file_path_picture) {

            $view_data['main_wrapper_css_classes'] .= ' lazy-load-wrapper';

        } else {

            $view_data['extra_wrapper_attributes']['class'] = [
                'lazy-load-wrapper'
            ];

        }

        $view_data['extra_wrapper_attributes']['style'] = [
            'padding-bottom:' . (($img_data['height'] / $img_data['width']) * 100) . '%',
            'height:0',
        ];

        return $view_data;

    }

    /**
     * @return bool|array;
     */
    public function get_view_data() {

        $main_img_data = $this->get_image_data('main');

        if(empty($main_img_data)) {
            return false;
        }

        $view_data = [
            'img' => $main_img_data,
        ];

        $sources_data = $this->get_sources_data();

        if($this->picture_element_is_forced || !empty($sources_data)) {

            $view_data['sources'] = $sources_data;
            $this->template_file_path = $this->template_file_path_picture;

        }

        $view_data['extra_wrapper_attributes'] = [];
        $view_data['use_extra_wrapper'] = $this->do_lazy_load();

        $view_data['main_wrapper_css_classes'] = 'ec-m ec-m-image';

        if($view_data['use_extra_wrapper']) {

            $view_data = $this->apply_extra_wrapper_view_data($view_data);

        }

        $view_data['parent_column_types_string'] = $this->get_column_css_classes('string');
        $view_data['parent_container_types_string'] = $this->get_container_css_classes('string');

        return $view_data;

    }

}

