<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\Main;
use pocketmine\level\biome\SandyBiome;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\populator\Cactus;

class DesertPlus extends SandyBiome{

    public function __construct(){
        parent::__construct();
        $this->setElevation(68, 75);
        $this->temperature = 2;
        $this->rainfall = 0;
        $cactus = new Cactus();
        $cactus->setBaseAmount(2);
        $cactus->setBaseAmount(3);
    }

    public function getName() : string{
        return "Desert";
    }

    public function getId(): int {
        return Main::DESERT;
    }

}