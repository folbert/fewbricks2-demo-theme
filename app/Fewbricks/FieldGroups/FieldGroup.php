<?php

namespace App\Fewbricks\FieldGroups;

use Fewbricks\ACF\FieldCollection;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;

abstract class FieldGroup extends \Fewbricks\ACF\FieldGroup
{

    /**
     * @var bool
     */
    protected $in_container = false;

    /**
     * @param $in_container
     * @return $this
     */
    public function set_in_container($in_container)
    {

        $this->in_container = $in_container;
        return $this;

    }

    /**
     * @return bool
     */
    public function in_container()
    {

        return $this->in_container;

    }

}
