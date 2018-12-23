<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\biome\Biome;

class Beach extends Biome{
    public function __construct(){
        $this->setGroundCover([
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND)
        ]);
        $this->setElevation(63, 65);
    }
    public function getName() : string
    {
        return "Beach";
    }
}