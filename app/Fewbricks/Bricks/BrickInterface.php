<?php

namespace App\Fewbricks\Bricks;

/**
 * Interface BrickInterface
 * @package App\Fewbricks\Bricks
 */
interface BrickInterface extends \Fewbricks\BrickInterface
{

    public function render();

    public function get_view_data();

}
