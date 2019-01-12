<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\Main;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\biome\GrassyBiome;
use pocketmine\level\biome\Biome;

class PlainsPlus extends GrassyBiome{
    public function __construct(){
        parent::__construct();
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(12);
        $this->addPopulator($tallGrass);
        $this->setElevation(64, 71);
        $this->temperature = 0.8;
        $this->rainfall = 0.4;
    }
    public function getName() : string{
        return "Plains";
    }

    public function getId(): int {
        return Main::PLAINS;
    }
}