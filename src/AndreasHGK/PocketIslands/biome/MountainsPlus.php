<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\Main;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\biome\GrassyBiome;
use pocketmine\level\biome\Biome;

class MountainsPlus extends GrassyBiome{
    public function __construct(){
        parent::__construct();
        $trees = new Tree();
        $trees->setBaseAmount(1);
        $this->addPopulator($trees);
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(1);
        $this->addPopulator($tallGrass);
        $this->setElevation(63, 127);
        $this->temperature = 0.4;
        $this->rainfall = 0.5;
    }
    public function getName() : string{
        return "Mountains";
    }

    public function getId(): int {
        return Main::MOUNTAINS;
    }
}