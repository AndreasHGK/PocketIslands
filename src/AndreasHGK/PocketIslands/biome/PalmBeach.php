<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\Main;
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
        //todo: add palmtree populator
    }
    public function getName() : string
    {
        return "PalmBeach";
    }

    public function getId(): int {
        return Main::PALMBEACH;
    }
}