<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\utils\WoodType;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\biome\GrassyBiome;

class ForestPlus extends GrassyBiome{

    public function __construct(){
        parent::__construct();
        $this->type = $type;
        $trees = new Tree();
        $trees->setBaseAmount(5);
        $this->addPopulator($trees);
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(3);
        $this->addPopulator($tallGrass);
        $this->setElevation(69, 73);
        $this->temperature = 0.7;
        $this->rainfall = 0.8;
    }
    public function getName() : string{
        return "ForestPlus";
    }
}