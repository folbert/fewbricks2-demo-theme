<?php

namespace App\Fewbricks\Bricks\Traits;

/**
 * Trait LazyLoadTrait
 * @package App\Fewbricks\Bricks\Traits
 */
trait LazyLoadTrait
{

    /**
     * @var bool
     */
    protected $do_lazy_load = false;

    /**
     * @param $do_lazy_load
     * @return $this
     */
    public function set_do_lazy_load($do_lazy_load)
    {

        $this->do_lazy_load = $do_lazy_load;
        return $this;

    }

    /**
     * @return mixed
     */
    public function do_lazy_load()
    {

        return $this->do_lazy_load;

    }

}
