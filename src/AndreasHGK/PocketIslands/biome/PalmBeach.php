<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\Main;
use AndreasHGK\PocketIslands\populator\PalmTree;
use pocketmine\level\biome\SandyBiome;

class PalmBeach extends Biome{
    public function __construct(){
        $this->setGroundCover([
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND)
        ]);
        $this->setElevation(64, 69);
        $pt = new PalmTree();
        $pt->setBaseAmount(0);
        $pt->setRandomAmount(1);
        $this->addPopulator($pt);
    }
    public function getName() : string
    {
        return "PalmBeach";
    }

    public function getId(): int {
        return Main::PALMBEACH;
    }
}