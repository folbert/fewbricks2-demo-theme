<?php

namespace App\Fewbricks\Bricks\Video\Embed;

use Fewbricks\ACF\Fields\TrueFalse;

class YouTube extends Video
{

    protected $name = 'embed_youtube';

    protected $label = 'Video - Embed - YouTube';

    protected $template_file_path = 'fewbricks.bricks.video-embed';

    protected $start_time_arg_name = '&start';

    protected $start_time_suffix = '';

    /**
     * Available settings can be found at https://developers.google.com/youtube/player_parameters
     */
    protected function add_settings_fields()
    {

        $settings_added = parent::add_settings_fields();

        if(!$this->get_argument('remove_setting_controls', false)) {

            $this->add_field((new TrueFalse('Hide controls', 'hide_controls', '1912301754a'))
                ->set_instructions('Check this to hide the controls at the bottom of the video')
            );

            $settings_added = true;

        }

        if(!$this->get_argument('remove_rel', false)) {

            $this->add_field((new TrueFalse('Keep related videos to be of the same channel as the video', 'remove_rel', '1912301759a'))
                ->set_instructions('Keep the related vidoes at the end to be from the same channel as the video. Completely disabling related videos <a href="https://developers.google.com/youtube/player_parameters#release_notes_08_23_2018" target="_blank">is no longer possible</a>.')
                ->set_default_value(true)
            );

            $settings_added = true;

        }

        return $settings_added;

    }

    /**
     * @return array
     */
    protected function get_src_params()
    {

        return array_merge(parent::get_src_parameters(), [
            'modestbranding' => '1',
            'controls' => $this->get_field_value('hide_controls') ? '0' : '1',
            'rel' => $this->get_field_value('remove_rel') ? '0' : '1',
        ]);

    }

}
