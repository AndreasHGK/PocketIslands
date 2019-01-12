<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\biome;

use AndreasHGK\PocketIslands\generator\IslandGenerator;
use pocketmine\level\biome\Biome;
use pocketmine\level\biome\UnknownBiome;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\level\generator\noise\Noise;
use pocketmine\utils\Random;

abstract class IslandSelector{

    private $height;
    /** @var Simplex */
    private $temperature;
    /** @var Simplex */
    private $rainfall;
    /** @var Biome[]|\SplFixedArray */
    private $map = null;
    public function __construct(Random $random){
        $this->height = new Simplex($random, 6, 0.50, 1 / 512);
        $this->temperature = new Simplex($random, 8, 1/8, 1 / 1024);
        $this->rainfall = new Simplex($random, 4, 0.75, 1 / 1024);
    }
    /**
     * Lookup function called by recalculate() to determine the biome to uste for this temperature and rainfall.
     *
     * @param float $temperature
     * @param float $rainfall
     *
     * @return int biome ID 0-255
     */
    abstract protected function lookup(float $height, float $temperature, float $rainfall) : int;
    public function recalculate() : void{
        $this->map = new \SplFixedArray(64 * 64 * 64);
        for($i = 0; $i < 64; ++$i){
            for($j = 0; $j < 64; ++$j){
                for($k = 0; $k < 64; ++$k) {
                    $biome = Biome::getBiome($this->lookup($i / 63, $j / 63, $k / 63));
                    if ($biome instanceof UnknownBiome) {
                        throw new \RuntimeException("Unknown biome returned by selector with ID " . $biome->getId());
                    }
                    $this->map[$j + ($k << 6) + ($i << 12)] = $biome;
                }
            }
        }
    }

    public function getHeight($x, $z){
        return ($this->height->noise2D($x, $z, true) + 1) / 2;
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
        $height = (int) ($this->getHeight($x, $z) * 63);
        $temperature = (int) ($this->getTemperature($x, $z) * 63);
        $rainfall = (int) ($this->getRainfall($x, $z) * 63);
        return $this->map[$temperature + ($rainfall << 6) + ($height << 12)];
    }
}