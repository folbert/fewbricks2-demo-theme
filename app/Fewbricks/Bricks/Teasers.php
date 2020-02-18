<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\CommonFields;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Tab;

class Teasers extends FlexibleContentBrick
{

    protected $label = 'Teasers';

    protected $template_file_path = 'fewbricks.bricks.teasers';

    protected $layouts_settings = [
        'image_and_text' => [
            'layout_label' => false,
            'layout_key' => '2001071533b',
            'brick_class' => 'GenericTeaser1',
            'brick_name' => 'generic_teaser_1',
            'brick_key' => '2001071533a',
        ],
    ];

    /**
     *
     */
    public function set_up()
    {

        $this->add_content_fields();
        $this->add_settings_fields();
        $this->add_instructions_fields();

    }

    /**
     *
     */
    private function add_content_fields()
    {

        $this->add_field(new Tab('Teasers', 'teasers_accordion', '2001071547a'));

        $flexible_content = (new FlexibleContent('', 'teasers', '2001071511a'))
            ->set_button_label('Add teaser')
            ->set_min(2)
            ->set_max(4);

        $flexible_content = $this->add_layouts($flexible_content, $this->layouts_settings);

        $this->add_flexible_content($flexible_content);

    }

    /**
     * @param $brick
     * @return GenericTeaser1
     */
    protected function alter_brick_before_add($brick) {

        $brick->remove_layout_choices([
            'text-to-the-right',
            'text-to-the-left',
        ]);

        return $brick;

    }

    /**
     *
     */
    private function add_settings_fields()
    {

        $this->add_field(new Tab('Settings', 'settings_accordion', '2001071632a'));
        $this->add_field((CommonFields::get_instance()->get_field('container_width_1', '2001291814a')));
        $this->add_backend_name_field('2001071633u');

    }

    /**
     *
     */
    private function add_instructions_fields()
    {

        $this->add_field((new Tab('Instructions', 'instructions_tab', '2002061204a')));

        $this->add_field((new Message('', 'instructions', '2002061205a'))
            ->set_message('All teasers will be stretched to be the same height. So any images added to teasers with the Layout set to "Text over image" will, if needed, stretch to take up the entire space of the teaser it belongs to. To avoid undesired effects, try to keep the amount of text the same in all the teasers and use the same size for all the images.')
        );

    }

    /**
     * @return Brick[] array
     */
    public function get_teasers()
    {

        $teasers = $this->get_bricks_in_flexible_content('teasers');

        /**
         * @var  $teaser_key
         * @var GenericTeaser1 $teaser
         */
        foreach($teasers AS $teaser_key => $teaser) {
            $teasers[$teaser_key]
                ->set_is_standalone(false)
                ->set_column_css_classes($this->get_teaser_column_css_classes($teasers))
                ->set_container_css_classes($this->get_container_css_classes());
        }

        return $teasers;

    }

    /**
     * @param $teasers
     * @param string $return
     * @param string $string_separator
     * @return int|void
     */
    public function get_teaser_column_css_classes($teasers, $return = 'array', $string_separator = ' ')
    {

        $classes = [];
        $classes[] = 'col-md-' . 12 / count($teasers);
        $classes[] = 'ec-m-teasers__col';

        if($return === 'array') {
            return $classes;
        }

        return implode($classes, $string_separator);

    }

    /**
     * @param $view_data
     * @return mixed|void
     */
    public function finalize_view_data($view_data)
    {

        unset($view_data['wrapping_elements_data']['column_css_classes']);

        return $view_data;

    }

    /**
     * @return bool|array
     */
    public function get_view_data()
    {

        $teasers = $this->get_teasers();

        if(empty($teasers)) {
            return false;
        }

        return [
            'main_wrapper_css_classes' => 'ec-m ec-m-teasers',
            'teasers' => $teasers,
            'container_css_classes' => $this->get_container_css_classes('string'),
            'row_css_classes' => $this->get_row_css_classes(),
            'column_css_classes' => $this->get_teaser_column_css_classes($teasers, 'string'),
        ];

    }

}
