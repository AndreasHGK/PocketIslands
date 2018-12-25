<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\Main;
use pocketmine\level\biome\SandyBiome;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\populator\Cactus;
use AndreasHGK\PocketIslands\populator\DeadBush;

class DesertPlus extends SandyBiome{

    public function __construct(){
        parent::__construct();
        $this->setElevation(68, 75);
        $this->temperature = 2;
        $this->rainfall = 0;
        $cactus = new Cactus();
        $cactus->setBaseAmount(0);
        $cactus->setRandomAmount(0);
        $this->addPopulator($cactus);

        $db = new DeadBush();
        $db->setBaseAmount(0);
        $db->setRandomAmount(0);
        $this->addPopulator($db);
    }

    public function getName() : string{
        return "Desert";
    }

    public function getId(): int {
        return Main::DESERT;
    }

}