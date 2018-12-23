<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\biome\SnowyBiome;

class IcePlainsPlus extends SnowyBiome{
    public function __construct(){
        parent::__construct();
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(5);
        $this->addPopulator($tallGrass);
        $this->setElevation(69, 73);
        $this->temperature = 0.05;
        $this->rainfall = 0.8;
    }
    public function getName() : string{
        return "IcePlainsPlus";
    }
}