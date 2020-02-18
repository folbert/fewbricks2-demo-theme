<?php

namespace App\Fewbricks\Bricks;

use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Tab;

class LinkGroup extends FlexibleContentBrick
{

    const TYPE_STANDARD = 'standard';

    const TYPE_NAV = 'nav';

    const TEMPLATE_FILE_PATH_STANDARD = 'fewbricks.bricks.link-group';

    const TEMPLATE_FILE_PATH_NAV = 'fewbricks.bricks.link-group--nav';

    protected $label = 'Links';

    protected $template_file_path = self::TEMPLATE_FILE_PATH_STANDARD;

    private $flexible_content_field_name = 'links';

    protected $type = self::TYPE_STANDARD;

    /**
     *
     */
    public function set_up()
    {

        $this->add_link_fields();
        $this->add_settings_fields();

    }

    /**
     *
     */
    private function add_link_fields()
    {

        if(!$this->get_argument('hide_settings', false)) {
            $this->add_field(new Tab('Links', 'links_tab', '1912031803e'));
        }

        $flexible_content = new FlexibleContent($this->label, $this->flexible_content_field_name, '1911292108a');

        $layouts_settings = [
            'email' => [
                'layout_label' => false,
                'layout_key' => '1911302323o',
                'brick_class' => 'Links\Email',
                'brick_name' => 'email_link',
                'brick_key' => '1911302323r',
            ],
            'download' => [
                'layout_label' => false,
                'layout_key' => '1912031736a',
                'brick_class' => 'Links\File',
                'brick_name' => 'download_link',
                'brick_key' => '1911302323o',
            ],
            'internal_link' => [
                'layout_label' => false,
                'layout_key' => '1911292111o',
                'brick_class' => 'Links\Internal',
                'brick_name' => 'internal_link',
                'brick_key' => '1911292110a',
            ],
            'anything' => [
                'layout_label' => false,
                'layout_key' => '1012031758i',
                'brick_class' => 'Links\Anything',
                'brick_name' => 'anything_link',
                'brick_key' => '1912031758l',
            ],
        ];

        $this->add_layouts($flexible_content, $layouts_settings);

        // @todo Better name than "argument"?
        $flexible_content->set_button_label($this->get_argument('button_label', $this->get_argument('button_label', 'Add link')));

        $this->add_flexible_content($flexible_content);

    }

    /**
     * @param Brick $brick
     * @return mixed
     */
    protected function alter_brick_before_add($brick)
    {

        $brick->set_argument('hide_style', $this->get_argument('hide_link_style', false));

        return $brick;

    }

    /**
     *
     */
    private function add_settings_fields()
    {

        if($this->get_argument('hide_settings', false)) {
            return;
        }

        $this->add_field(new Tab('Settings', 'settings_tab', '1912031805t'));

        $this->add_backend_name_field('2001071456a');

        $this->add_field((new Select('Layout', 'layout', '1912031806a'))
        ->set_choices([
            'horizontal--left' => 'Inline - Left Aligned',
            'horizontal--center' => 'Inline - Centered',
            'horizontal--right' => 'Inline - Right Aligned',
            'vertical--left' => 'One link per line - Left Aligned',
            'vertical--center' => 'One link per line - Centered',
            'vertical--right' => 'One link per line - Right Aligned',
        ])
        ->set_default_value('inline')
        ->set_allow_null(false));

    }

    /**
     * @param null $void
     * @return \Fewbricks\Brick
     */
    public function set_template_file_path($void = null)
    {

        switch($this->type) {

            case self::TYPE_NAV :

                $template_file_path = self::TEMPLATE_FILE_PATH_NAV;
                break;

            default :

                $template_file_path = self::TEMPLATE_FILE_PATH_STANDARD;

        }

        return parent::set_template_file_path($template_file_path);
    }

    /**
     * @param $type
     * @return LinkGroup
     */
    public function set_type($type)
    {

        if(!in_array($type, [
            self::TYPE_STANDARD,
            self::TYPE_NAV,
        ])) {

            $type = self::TYPE_STANDARD;

        }

        $this->type = $type;

        $this->set_template_file_path();

        return $this;

    }

    /**
     * @return string
     */
    public function get_main_wrapper_css_classes()
    {

        $css_classes = [];
        $css_classes[] = 'ec-m';
        $css_classes[] = 'ec-m-link-group';

        if($this->type === self::TEMPLATE_FILE_PATH_NAV) {
            $css_classes[] = 'ec-m-link-group--nav';
        }

        $layout = $this->get_field_value('layout');

        if(!empty($layout)) {

            list($direction, $alignment) = explode('--', $this->get_field_value('layout'));

            $css_classes[] = 'ec-m-link-group--' . $direction;
            $css_classes[] = 'text-' . $alignment;

        }

        return implode($css_classes, ' ');

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $links = $this->get_bricks_in_flexible_content($this->flexible_content_field_name);

        if(empty($links)) {
            return false;
        }

        return [
            'links' => $links,
            'main_wrapper_css_classes' => $this->get_main_wrapper_css_classes(),
        ];

    }

}
