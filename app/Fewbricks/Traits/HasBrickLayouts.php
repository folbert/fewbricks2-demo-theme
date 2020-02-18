<?php

namespace App\Fewbricks\Traits;

use App\Fewbricks\Bricks\Brick;
use Fewbricks\ACF\Fields\FlexibleContent;

trait HasBrickLayouts
{

    /**
     * If you both white- and blacklist, only blacklist will be used.
     * @var bool
     */
    protected $layout_whitelist = false;

    /**
     * If you both white- and blacklist, only blacklist will be used.
     * @var bool
     */
    protected $layout_blacklist = false;

    /**
     * @param $suffix
     * @return array
     */
    public function get_brick_layouts($suffix)
    {

        $bricks = [];

        $flexible_content = new FlexibleContent('', $this->field_names_prefix . $suffix);

        if($flexible_content->have_rows()) {

            while($flexible_content->have_rows()) {

                $flexible_content->the_row();

                /** @var Brick $brick */
                $brick = $flexible_content->get_brick_in_row();

                $this->alter_brick_before_detach($brick);

                $brick->detach_from_acf_loop();

                $bricks[] = $brick;

            }

        }

        return $bricks;

    }

    /**
     * @param $brick
     */
    protected function alter_brick_before_detach($brick)
    {


    }

    /**
     * @return mixed
     */
    protected function get_brick_layouts_settings()
    {

        $brick_layout_settings = $this->brick_layouts_settings;

        if($this->layout_blacklist !== false) {
            $brick_layout_settings = $this->apply_layout_blacklist($brick_layout_settings);
        } else if($this->layout_whitelist !== false) {
            $brick_layout_settings = $this->apply_layout_whitelist($brick_layout_settings);
        }

        return $brick_layout_settings;

    }

    /**
     * @param array $brick_layouts_settings
     * @return array
     */
    protected function apply_layout_blacklist($brick_layouts_settings)
    {

        if(!is_array($this->layout_blacklist)) {
            return $brick_layouts_settings;
        }

        foreach($brick_layouts_settings AS $brick_layouts_setting_key => $brick_layouts_setting) {

            if(in_array($brick_layouts_setting_key, $this->layout_blacklist)) {
                unset($brick_layouts_settings[$brick_layouts_setting_key]);
            }

        }

        return $brick_layouts_settings;

    }

    /**
     * @param array $brick_layouts_settings
     * @return array
     */
    protected function apply_layout_whitelist($brick_layouts_settings)
    {

        if(!is_array($this->layout_whitelist)) {
            return $brick_layouts_settings;
        }

        foreach($brick_layouts_settings AS $brick_layouts_setting_key => $brick_layouts_setting) {

            if(!in_array($brick_layouts_setting_key, $this->layout_whitelist)) {
                unset($brick_layouts_settings[$brick_layouts_setting_key]);
            }

        }

        return $brick_layouts_settings;

    }

    /**
     * @param array $brick_layout_settings_keys
     * @return HasBrickLayouts
     */
    public function add_to_layout_settings_whitelist(array $brick_layout_settings_keys)
    {

        if(!is_array($this->layout_whitelist)) {
            $this->layout_whitelist = [];
        }

        $this->layout_whitelist = array_merge(
            $this->layout_whitelist,
            $brick_layout_settings_keys
        );

        return $this;

    }

    /**
     * @param array $brick_layout_settings_keys
     * @return HasBrickLayouts
     */
    public function add_to_layout_settings_blacklist(array $brick_layout_settings_keys)
    {

        if(!is_array($this->layout_blacklist)) {
            $this->layout_blacklist = [];
        }

        $this->layout_blacklist = array_merge(
            $this->layout_blacklist,
            $brick_layout_settings_keys
        );

        return $this;

    }

}
