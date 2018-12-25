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
    public const LAKE = 202;
    public const PALMBEACH = 203;
    public const SHORE = 204;
    public const DESERT = 205;
    public const FOREST = 206;
    public const ICE_PLAINS = 207;
    public const TAIGA = 208;
    public const DEEPSEA = 209;
    public const PLAINS = 210;

    public function onLoad() : void{
        GeneratorManager::addGenerator(IslandGenerator::class, "islands", true);
    }

	public function onEnable() : void{

	}

    public function onDisable() : void{
	}
}
