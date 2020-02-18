<?php

namespace App\Fewbricks\Bricks;

use App\Fewbricks\CommonFields;
use function App\template;

/**
 * Class Brick
 * @package App\Fewbricks\Bricks
 */
abstract class Brick extends \Fewbricks\Brick implements BrickInterface
{

    /**
     * Whether brick is part of another brick or not
     * @var bool
     */
    protected $is_standalone = true;

    /**
     * @var bool
     */
    protected $template_file_path = false;

    /**
     * There can be multiple column types. Bricks which are including bricks which are depending on the wrapping
     * container type are responsible for passing the container type down to the included bricks when rendering them.
     * All bricks using the image brick is depending on the wrapping column types and container type for calculating
     * sizes attributes and/or element attributes.
     * @var array
     */
    protected $column_css_classes = ['col-12'];

    /**
     * There can only be one container type. The container div can have multiple classes thar are unrelated to Bootstrap
     * but there can only be one type.
     * Bricks which are including bricks which are depending on the wrapping container type are responsible for passing
     * the container type down to the included bricks when rendering them.
     * All bricks using the image brick is depending on the wrapping column types and container type for calculating
     * sizes attributes and/or element attributes.
     * @link https://getbootstrap.com/docs/4.4/layout/overview/#containers
     * @var array
     */
    protected $container_css_classes = ['container'];

    /**
     * @var array
     */
    protected $row_css_classes = ['row'];

    /**
     * @var bool
     */
    protected $force_skip_wrap_in_container = false;

    /**
     * @var bool
     */
    protected $force_skip_wrap_in_row = false;

    /**
     * @var bool
     */
    protected $force_skip_wrap_in_column = false;

    /**
     * Brick constructor.
     * @param string $key
     * @param string $name
     * @param array $arguments
     */
    public function __construct(string $key = '', string $name = '', array $arguments = [])
    {

        parent::__construct($key, $name, $arguments);

    }

    /**
     * @param $css_classes
     * @return Brick
     */
    public function set_container_css_classes(array $css_classes) {

        $this->container_css_classes = $css_classes;
        return $this;

    }

    /**
     * @param string $css_class
     */
    public function add_container_css_class(string $css_class)
    {

        $this->container_css_classes[] = $css_class;

    }

    /**
     * @param string $return
     * @param string $string_separator
     * @return string
     */
    public function get_container_css_classes($return = 'array', $string_separator = ' ')
    {

        $container_css_classes = $this->container_css_classes;

        switch($this->get_field_value('container_width')) {

            case 'full_width_with_margin' :
                $container_css_classes[] = 'container-fluid';
                break;

            case 'full_width_without_margin' :

                $container_css_classes[] = 'container-fluid';
                $container_css_classes[] = 'ec-container-fluid--no-margin';
                break;

        }

        if(in_array('container-fluid', $container_css_classes)
            && false !== ($container_key = array_search('container',$container_css_classes))
        ) {

            unset($container_css_classes[$container_key]);

        }

        if($return === 'string') {
            $container_css_classes = implode($string_separator, $container_css_classes);
        }

        return $container_css_classes;

    }

    /**
     * @param array $css_classes
     */
    public function set_row_css_classes(array $css_classes)
    {

        $this->row_css_classes = $css_classes;

    }

    /**
     * @param string $css_class
     * @return $this
     */
    public function add_row_css_class(string $css_class)
    {

        $this->row_css_classes[] = $css_class;
        return $this;

    }

    /**
     * @param string $return
     * @param string $string_separator
     * @return array
     */
    public function get_row_css_classes($return = 'array', $string_separator = ' ') {

        $row_css_classes = ['row'];

        $vertical_alignment_classes = [
            'center' => 'align-items-center',
            'end' => 'align-items-end'
        ];

        $vertical_alignment_setting = $this->get_field_value('vertical_alignment');

        if(isset($vertical_alignment_classes[$vertical_alignment_setting])) {
            $row_css_classes[] = $vertical_alignment_classes[$vertical_alignment_setting];
        }

        if($return == 'string') {
            $row_css_classes = implode($string_separator, $row_css_classes);
        }

        return $row_css_classes;

    }

    /**
     * @param $css_classes
     * @return Brick
     */
    public function set_column_css_classes(array $css_classes) {

        $this->column_css_classes = $css_classes;
        return $this;

    }

    /**
     * @param string $return "array" or "string"
     * @param string $string_separator
     * @param string $void2
     * @return array|string
     */
    public function get_column_css_classes($return = 'array', $string_separator = ' ', $void2 = '')
    {

        $css_classes = $this->column_css_classes;

        if($return !== 'array') {

            if(is_array($css_classes)) {
                $css_classes = implode($css_classes, $string_separator);
            } else {
                $css_classes = (string) $css_classes;
            }

        }

        return $css_classes;

    }

    /**
     * @param $value
     * @return $this
     */
    public function set_force_skip_wrap_in_container($value)
    {

        $this->force_skip_wrap_in_container = $value;
        return $this;

    }

    /**
     * @return bool
     */
    public function get_force_skip_wrap_in_container()
    {

        return $this->force_skip_wrap_in_container;

    }

    /**
     * @param $value
     * @return $this
     */
    public function set_force_skip_wrap_in_row($value)
    {

        $this->force_skip_wrap_in_row = $value;
        return $this;

    }

    /**
     * @return bool
     */
    public function get_force_skip_wrap_in_row()
    {

        return $this->force_skip_wrap_in_row;

    }

    /**
     * @param $value
     * @return $this
     */
    public function set_force_skip_wrap_in_column($value)
    {

        $this->force_skip_wrap_in_column = $value;
        return $this;

    }

    /**
     * @return bool
     */
    public function get_force_skip_wrap_in_column()
    {

        return $this->force_skip_wrap_in_column;

    }

    /**
     * @param bool $is_standalone
     * @return Brick
     */
    public function set_is_standalone(bool $is_standalone)
    {

        $this->is_standalone = $is_standalone;
        return $this;

    }

    /**
     * @return bool
     */
    public function is_standalone()
    {

        return $this->is_standalone;

    }


    /**
     * @param string $template_file_path
     * @return Brick
     */
    public function set_template_file_path($template_file_path)
    {

        $this->template_file_path = $template_file_path;
        return $this;

    }

    /**
     * @return mixed
     */
    public function get_template_file_path()
    {

        return $this->template_file_path;

    }

    /**
     * @param $key
     * @return bool|Brick
     */
    public function add_backend_name_field($key)
    {

        if($this->get_argument('hide_backend_name', false)) {
            return false;
        }

        $this->add_field(CommonFields::get_instance()->get_field('backend_name', $key));

        return $this;

    }

    /**
     * @param $view_data
     * @return mixed
     */
    public function finalize_view_data($view_data)
    {

        return $view_data;

    }

    /**
     * @return string
     */
    public function render()
    {

        $view_data = static::get_view_data();

        if($view_data === false) {
            return '';
        }

        if(!isset($view_data['self'])) {
            $view_data['self'] = $this;
        }

        if(!isset($view_data['wrapping_elements_data'])) {

            $view_data['wrapping_elements_data'] = [
                'container_css_classes' => $this->get_container_css_classes('string'),
                'row_css_classes' => $this->get_row_css_classes('string'),
                'column_css_classes' => $this->get_column_css_classes('string'),
                'caller' => $this,
            ];

        }

        $view_data = $this->finalize_view_data($view_data);

        $template_file_path = $this->get_template_file_path();

        return template($template_file_path, $view_data);

    }

}
