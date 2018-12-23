<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\level\biome\SandyBiome;

class DesertPlus extends SandyBiome{
public function __construct(){
parent::__construct();
$this->setElevation(69, 72);
$this->temperature = 2;
$this->rainfall = 0;
}
public function getName() : string{
return "DesertPlus";
}
}