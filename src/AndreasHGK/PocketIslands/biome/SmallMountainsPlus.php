<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

class SmallMountainsPlus extends MountainsPlus{
    public function __construct(){
        parent::__construct();
        $this->setElevation(71, 97);
    }
    public function getName() : string{
        return "Small Mountains";
    }
}