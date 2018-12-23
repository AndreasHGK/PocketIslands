<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\generator\populator\TallGrass;

class Lake extends Biome{
    public function __construct(){
        $this->setGroundCover([
            BlockFactory::get(Block::GRAVEL),
            BlockFactory::get(Block::GRAVEL),
            BlockFactory::get(Block::GRAVEL),
            BlockFactory::get(Block::GRAVEL),
            BlockFactory::get(Block::GRAVEL)
        ]);
        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(5);
        $this->addPopulator($tallGrass);
        $this->setElevation(58, 61);
        $this->temperature = 0.5;
        $this->rainfall = 0.5;
    }
    public function getName() : string{
        return "Lake";
    }
}