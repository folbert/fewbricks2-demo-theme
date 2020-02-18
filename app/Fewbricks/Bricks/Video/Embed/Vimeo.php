<?php

namespace App\Fewbricks\Bricks\Video\Embed;

use Fewbricks\ACF\Fields\TrueFalse;

class Vimeo extends Video
{

    protected $name = 'embed_youtube';

    protected $label = 'Video - Embed - Vimeo';

    protected $template_file_path = 'fewbricks.bricks.video-embed';

    protected $start_time_arg_name = '#t';

    protected $start_time_suffix = 's';

    /**
     * Available settings can be found at https://vimeo.zendesk.com/hc/en-us/articles/360001494447-Using-Player-Parameters
     */
    protected function add_settings_fields()
    {

        $settings_added = parent::add_settings_fields();

        // We dont want this kind of feature to be used lightly...
        if($this->get_argument('add_setting_autoplay', false)) {

            $this->add_field((new TrueFalse('Play inline ', 'playsinline', '1912302126y'))
                ->set_instructions('From <a href="https://vimeo.zendesk.com/hc/en-us/articles/360001494447-Using-Player-Parameters" target="_blank">Vimeos Documentation</a>: Play video inline on mobile devices instead of automatically going into fullscreen mode.')
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

        $parameters = [
            'playsinline' => $this->get_field_value('playsinline') ? '1' : '0',
        ];

        return array_merge(parent::get_src_parameters(), $parameters);

    }

}
