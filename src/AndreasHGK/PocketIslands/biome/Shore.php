<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\biome\OceanBiome;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\Main;

class Shore extends Biome {
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
        $this->setElevation(56, 60);
        $this->temperature = 0.5;
        $this->rainfall = 0.5;
    }
    public function getName() : string{
        return "Shore";
    }

    public function getId(): int {
        return Main::SHORE;
    }
}