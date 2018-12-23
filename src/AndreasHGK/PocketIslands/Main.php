<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands;

use AndreasHGK\PocketIslands\biome\IslandSelector;
use pocketmine\plugin\PluginBase;
use pocketmine\level\generator\GeneratorManager;
use AndreasHGK\PocketIslands\generator\IslandGenerator;
use pocketmine\level\biome\Biome;
use AndreasHGK\PocketIslands\biome\Beach;

class Main extends PluginBase{

    public const BEACH = 201;

    public function onLoad() : void{
        GeneratorManager::addGenerator(IslandGenerator::class, "islands", true);
    }

	public function onEnable() : void{
        $gens = GeneratorManager::getGeneratorList();
        foreach($gens as $gen){
            $this->getLogger()->info("generator: ".$gen);
        }

	}

    public function onDisable() : void{
	}
}
