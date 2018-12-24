<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\Main;

class Beach extends Biome{
    public function __construct(){
        $this->setGroundCover([
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND),
            BlockFactory::get(Block::SAND)
        ]);
        $this->setElevation(64, 65);
    }
    public function getName() : string
    {
        return "Beach";
    }

    public function getId(): int {
        return Main::BEACH;
    }
}