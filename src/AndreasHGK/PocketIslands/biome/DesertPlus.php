<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\Main;
use pocketmine\level\biome\SandyBiome;
use pocketmine\level\biome\Biome;

class DesertPlus extends SandyBiome{
public function __construct(){
parent::__construct();
$this->setElevation(69, 72);
$this->temperature = 2;
$this->rainfall = 0;
}
public function getName() : string{
return "Desert";
}
    public function getId(): int {
        return Main::DESERT;
    }

}