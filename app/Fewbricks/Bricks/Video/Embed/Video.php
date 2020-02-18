<?php

namespace App\Fewbricks\Bricks\Video\Embed;

use App\Fewbricks\Bricks\Brick;
use App\Fewbricks\Bricks\Traits\LazyLoadTrait;
use App\Fewbricks\CommonFields;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Number;
use Fewbricks\ACF\Fields\Oembed;
use Fewbricks\ACF\Fields\Tab;
use Fewbricks\ACF\Fields\TrueFalse;

abstract class Video extends Brick
{

    use LazyLoadTrait;

    /**
     *
     */
    public function set_up()
    {

        $this->add_url_field();

        if($this->add_settings_fields()) {

            $this->add_field_after_field_by_name(new Tab('Settings', 'settings_tab', '1912301738a'), $this->name . '_url');

            $this->add_field_after_field_by_name((new Message('', 'settings_message', '1912302129i'))
                ->set_message('Some of these settings may not work in all browsers and may be dependant on your account type with the video provider.')
                , $this->name . '_settings_tab'
            );

            $this->add_field_before_field_by_name(
                CommonFields::get_instance()->get_field('backend_name', '2001051917a'), $this->name . '_settings_message');

        }

    }

    /**
     * @return bool
     */
    protected function add_settings_fields()
    {

        $settings_added = false;

        $this->add_argument('add_setting_autoplay', true);

        // We dont want this kind of feature to be used lightly...
        if($this->get_argument('add_setting_autoplay', false)) {

            $this->add_field((new TrueFalse('Autoplay', 'autoplay', '1912301736a'))
                ->set_instructions('Use with care in order to not unnecessarily annoy visitors')
            );

            $settings_added = true;

        }

        if($this->get_argument('add_setting_start_time', true)) {

            $this->add_field((new Number('Start time', 'start_time', '1912302137u'))
                ->set_instructions('Enter the nr of seconds in to the movie where you want it to start')
                ->set_default_value(0)
                ->set_min(0)
            );

            $settings_added = true;

        }

        return $settings_added;

    }

    /**
     *
     */
    private function add_url_field()
    {

        $this->add_field(new Tab('Video URL', 'video_tab', '1912301653a'));

        $this->add_field((new Oembed('', 'url', '1912301654u'))
            ->set_required(true)
        );

    }

    /**
     * @return array
     */
    protected function get_src_parameters()
    {

        return [
            'autoplay' => $this->get_field_value('autoplay') ? '1' : '0',
        ];

    }

    /**
     * @return bool
     */
    private function get_iframe_html()
    {

        // This will return an iframe element
        $iframe_html = $this->get_field_value('url');

        if(empty($iframe_html)) {
            return false;
        }

        $iframe_html = $this->apply_custom_attributes($iframe_html);

        return $iframe_html;

    }

    /**
     * @param $iframe_html
     * @return mixed
     */
    protected function apply_custom_attributes($iframe_html)
    {

        $iframe_html = $this->apply_custom_classes($iframe_html);
        $iframe_html = $this->edit_src($iframe_html);

        return $iframe_html;

    }

    /**
     * @param string $iframe_html
     * @return string
     */
    private function edit_src($iframe_html) {

        preg_match('/src="(.+?)"/', $iframe_html, $matches);
        $src = $matches[1];

        $new_src = add_query_arg($this->get_src_params(), $src);

        $new_src = $this->add_start_time($new_src);

        return str_replace($src, $new_src, $iframe_html);

    }

    /**
     * @param $src
     * @return mixed
     */
    private function add_start_time($src) {

        $start_time = $this->get_field_value('start_time');
        if(!empty($start_time)) {
            $src .= $this->start_time_arg_name . '=' . $start_time . $this->start_time_suffix;
        }

        return $src;

    }

    /**
     * @param $iframe_html
     * @return string
     */
    protected function apply_custom_classes($iframe_html)
    {

        preg_match('/class="(.+?)"/', $iframe_html, $class_matches);

        if(!empty($class_matches)) {
            $class_string = trim($class_matches[1]) . ' ';
        } else {
            $class_string = '';
        }

        $class_string .= 'embed-responsive-item';

        if(!empty($class_matches)) {
            $iframe_html = str_replace($class_matches[0], 'class="' . $class_string . '"', $iframe_html);
        } else {

            $pos = strpos($iframe_html, '>');
            if ($pos !== false) {
                $iframe_html = substr_replace($iframe_html, ' class="' . $class_string . '"', $pos, 0);
            }

        }

        // To fix caching issue in some browsers. This is mostly annoying in development when testing stuff.
        if(defined('WP_ENV') && WP_ENV === 'development') {
            $iframe_html = preg_replace('/src="(.*?)"/', 'src="$1&ec-cache-killer=' . microtime(true) . '"', $iframe_html);
        }

        if($this->do_lazy_load()) {
            $iframe_html = str_replace('class="', 'data-ec-do-lazy-load="1" class="', $iframe_html);
            $iframe_html = str_replace('src="', 'data-src="', $iframe_html);
        }

        return $iframe_html;

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $iframe_html = $this->get_iframe_html();

        if(empty($iframe_html)) {
            return false;
        }

        return [
            'iframe_html' => $iframe_html,
            'main_wrapper_css_classes' => 'ec-m ec-m-video',
        ];

    }


}
