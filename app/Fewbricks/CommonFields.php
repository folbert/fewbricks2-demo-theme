<?php

namespace App\Fewbricks;

use Fewbricks\ACF\Field;

class CommonFields
{

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var
     */
    private $registry;

    /**
     * SharedFields constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function get_instance() {

        if(self::$instance === null) {

            self::$instance = new self();

        }

        return self::$instance;

    }

    /**
     * @param string $shared_fields_index
     * @param string $key
     * @param array $settings Any settings that you want to override the shared fields settings
     * @return Field
     */
    public function get_field(string $shared_fields_index, string $key, array $settings = []) {

        $this->load_registry();

        /** @var Field $field */
        $field = clone $this->registry[$shared_fields_index];
        $field->set_key($key);
        $field->set_settings($settings);

        return $field;


    }

    /**
     *
     */
    private function load_registry() {

        if($this->registry !== null) {
            return;
        }

        $this->registry = require_once 'config/common-fields.php';

    }

}
