<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use pocketmine\level\biome\Biome;
use pocketmine\level\biome\UnknownBiome;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;

abstract class IslandSelector{
    protected $biomes;
    /** @var Simplex */
    private $temperature;
    /** @var Simplex */
    private $rainfall;
    /** @var Biome[]|\SplFixedArray */
    private $map = null;
    public function __construct(Random $random){
        $this->temperature = new Simplex($random, 2, 1 / 16, 1 / 1024);
        $this->rainfall = new Simplex($random, 2, 1 / 16, 1 / 700);
    }
    /**
     * Lookup function called by recalculate() to determine the biome to use for this temperature and rainfall.
     *
     * @param float $temperature
     * @param float $rainfall
     *
     * @return int biome ID 0-255
     */
    abstract protected function lookup(float $temperature, float $rainfall) : int;
    public function recalculate() : void{
        $this->map = new \SplFixedArray(64 * 64);
        for($i = 0; $i < 64; ++$i){
            for($j = 0; $j < 64; ++$j){
                $biome = Biome::getBiome($this->lookup($i / 63, $j / 63));
                if($biome instanceof UnknownBiome){
                    throw new \RuntimeException("Unknown biome returned by selector with ID " . $biome->getId());
                }
                $this->map[$i + ($j << 6)] = $biome;
            }
        }
    }

    public function getTemperature($x, $z){
        return ($this->temperature->noise2D($x, $z, true) + 1) / 2;
    }
    public function getRainfall($x, $z){
        return ($this->rainfall->noise2D($x, $z, true) + 1) / 2;
    }
    /**
     * @param $x
     * @param $z
     *
     * @return Biome
     */
    public function pickBiome($x, $z) : Biome{
        $temperature = (int) ($this->getTemperature($x, $z) * 63);
        $rainfall = (int) ($this->getRainfall($x, $z) * 63);
        return $this->map[$temperature + ($rainfall << 6)];
    }
}