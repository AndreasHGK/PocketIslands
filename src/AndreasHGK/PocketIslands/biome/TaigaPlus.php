<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\utils\WoodType;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\biome\SnowyBiome;

class TaigaPlus extends SnowyBiome{
    public function __construct(){
        parent::__construct();
        $trees = new Tree(WoodType::SPRUCE);
        $trees->setBaseAmount(10);
        $this->addPopulator($trees);
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(1);
        $this->addPopulator($tallGrass);
        $this->setElevation(69, 73);
        $this->temperature = 0.05;
        $this->rainfall = 0.8;
    }
    public function getName() : string{
        return "TaigaPlus";
    }
}