<?php

declare(strict_types=1);



namespace AndreasHGK\PocketIslands\generator;

//require 'vendor/autoload.php';
use AndreasHGK\PocketIslands\biome\IslandSelector;
use AndreasHGK\PocketIslands\Main;

use pocketmine\level\biome\Biome;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\Generator;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;
use pocketmine\block\BlockFactory;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\level\generator\object\OreType;
use pocketmine\level\generator\populator\GroundCover;
use pocketmine\level\generator\populator\Ore;
use pocketmine\level\generator\populator\Populator;

use AndreasHGK\PocketIslands\biome\Beach;
use AndreasHGK\PocketIslands\biome\DeepSea;
use AndreasHGK\PocketIslands\biome\DesertPlus;
use AndreasHGK\PocketIslands\biome\ForestPlus;
use AndreasHGK\PocketIslands\biome\IcePlainsPlus;
use AndreasHGK\PocketIslands\biome\Lake;
use AndreasHGK\PocketIslands\biome\MountainsPlus;
use AndreasHGK\PocketIslands\biome\PalmBeach;
use AndreasHGK\PocketIslands\biome\PlainsPlus;
use AndreasHGK\PocketIslands\biome\Shore;
use AndreasHGK\PocketIslands\biome\TaigaPlus;

class IslandGenerator extends Generator{

    public static $biomes = [ ];
    public static $biomeById = [ ];

    protected $selector;
    protected $level;
    protected $random;
    protected $populators = [ ];
    protected $generationPopulators = [ ];
    public static $levels = [ ];
    protected static $GAUSSIAN_KERNEL = null; // From main class
    protected static $SMOOTH_SIZE = 5;
    public $options = [];
    protected $waterHeight = 63;
    protected $noiseBase;

    /**
     * Picks a biome by X and Z
     *
     * @param	$x	int
     * @param	$z 	int
     * @return Biome
     */
    private function pickBiome(int $x, int $z) : Biome{
        $hash = $x * 2345803 ^ $z * 9236449 ^ $this->level->getSeed ();
        $hash *= $hash + 223;
        $xNoise = $hash >> 20 & 3;
        $zNoise = $hash >> 22 & 3;
        if($xNoise == 3){
            $xNoise = 1;
        }
        if($zNoise == 3){
            $zNoise = 1;
        }
        return $this->selector->pickBiome($x + $xNoise - 1, $z + $zNoise - 1);
    }

    /**
     * Inits the class for the var
     * @param		ChunkManager		$level
     * @param		Random				$random
     * @return		void
     */
    public function init(ChunkManager $level, Random $random) : void{
        $this->level = $level;
        $this->random = $random;

        self::$levels[] = $level;

        $this->random->setSeed($this->level->getSeed ());
        $this->noiseBase = new Simplex($this->random, 6, 0.3, 1/45);
        $this->random->setSeed($this->level->getSeed ());

        $this->selector = new class($this->random) extends IslandSelector{
            protected function lookup(float $temperature, float $rainfall) : int{
                if($rainfall < 0.50){
                    return Main::DEEPSEA;
                }elseif($rainfall < 0.58){
                    return Main::SHORE;
                }elseif($rainfall < 0.62){
                    return Main::BEACH;
                }elseif($rainfall < 0.65){
                    return Main::PALMBEACH;
                }elseif($rainfall < 0.88){
                    if($temperature < 0.1){
                        return Main::ICE_PLAINS;
                    }elseif($temperature < 0.2){
                        return Main::TAIGA;
                    }elseif($temperature < 0.45){
                        return Main::FOREST;
                    }elseif($temperature < 0.6){
                        return Main::PLAINS;
                    }elseif($temperature < 0.8){
                        return Main::MOUNTAINS;
                    }elseif($temperature < 0.9){
                        return Main::PLAINS;
                    }else{
                        return Main::DESERT;
                    }
                }elseif($rainfall < 92){
                    return Main::BEACH;
                }else{
                    return Main::LAKE;
                }
            }
        };

        $this->selector->recalculate ();

    }

    /**
     * Generates a chunk.
     *
     * Cloning method to make it work with new methods.
     * @param int $chunkX
     * @param int $chunkZ
     */
    public function generateChunk(int $chunkX, int $chunkZ) : void{
        $this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed ());
        $noise = $this->noiseBase->getFastNoise3D(16, 128, 16, 4, 8, 4, $chunkX * 16, 0, $chunkZ * 16);
        $chunk = $this->level->getChunk($chunkX, $chunkZ);
        $biomeCache = [];
        for($x = 0; $x < 16; ++$x){
            for($z = 0; $z < 16; ++$z){
                $minSum = 0;
                $maxSum = 0;
                $weightSum = 0;
                $biome = $this->pickBiome($chunkX * 16 + $x, $chunkZ * 16 + $z);
                $chunk->setBiomeId($x, $z, $biome->getId());
                for($sx = -self::$SMOOTH_SIZE; $sx <= self::$SMOOTH_SIZE; ++$sx){
                    for($sz = -self::$SMOOTH_SIZE; $sz <= self::$SMOOTH_SIZE; ++$sz){
                        $weight = self::$GAUSSIAN_KERNEL[$sx + self::$SMOOTH_SIZE][$sz + self::$SMOOTH_SIZE];
                        if($sx === 0 and $sz === 0){
                            $adjacent = $biome;
                        }else{
                            $index = Level::chunkHash($chunkX * 16 + $x + $sx, $chunkZ * 16 + $z + $sz);
                            if(isset($biomeCache[$index])){
                                $adjacent = $biomeCache[$index];
                            }else{
                                $biomeCache[$index] = $adjacent = $this->pickBiome($chunkX * 16 + $x + $sx, $chunkZ * 16 + $z + $sz);
                            }
                        }
                        $minSum += ($adjacent->getMinElevation() - 1) * $weight;
                        $maxSum += $adjacent->getMaxElevation() * $weight;
                        $weightSum += $weight;
                    }
                }
                $minSum /= $weightSum;
                $maxSum /= $weightSum;
                $smoothHeight = ($maxSum - $minSum) / 2;
                for($y = 0; $y < 128; ++$y){
                    if($y === 0){
                        $chunk->setBlock($x, $y, $z, Block::BEDROCK, 0);
                        continue;
                    }
                    $noiseValue = $noise[$x][$z][$y] - 1 / $smoothHeight * ($y - $smoothHeight - $minSum);
                    if($noiseValue > 0){
                        $chunk->setBlock($x, $y, $z, Block::STONE, 0);
                    }elseif($y <= $this->waterHeight){
                        $chunk->setBlock($x, $y, $z, Block::STILL_WATER, 0);
                    }
                }
            }
        }
        foreach($this->generationPopulators as $populator){
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random);
        }
    }

    /**
     * Populates a chunk
     *
     * @param int $chunkX
     * @param int $chunkZ
     * @return void
     */
    public function populateChunk(int $chunkX, int $chunkZ) : void{
        $this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->level->getSeed ());
        foreach($this->populators as $populator){
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random);
        }
        $chunk = $this->level->getChunk($chunkX, $chunkZ);
        $biome = Biome::getBiome($chunk->getBiomeId(7, 7));
        $biome->populateChunk($this->level, $chunkX, $chunkZ, $this->random);
    }

    /**
     * Constructs the class
     *
     * @param array $options
     */
    public function __construct(array $options = []){

        \pocketmine\level\biome\Biome::init();

        $reflect = new \ReflectionMethod(\pocketmine\level\biome\Biome::class, 'register');
        $reflect->setAccessible(true);

        $reflect->invoke(null, Main::BEACH, new Beach());
        $reflect->invoke(null, Main::LAKE, new Lake());
        $reflect->invoke(null, Main::PALMBEACH, new PalmBeach());
        $reflect->invoke(null, Main::SHORE, new Shore());
        $reflect->invoke(null, Main::DESERT, new DesertPlus());
        $reflect->invoke(null, Main::FOREST, new ForestPlus());
        $reflect->invoke(null, Main::ICE_PLAINS, new IcePlainsPlus());
        $reflect->invoke(null, Main::MOUNTAINS, new MountainsPlus());
        $reflect->invoke(null, Main::PLAINS, new PlainsPlus());
        $reflect->invoke(null, Main::TAIGA, new TaigaPlus());
        $reflect->invoke(null, Main::DEEPSEA, new DeepSea());

        $this->options = $options;
        if (self::$GAUSSIAN_KERNEL === null) {
            self::generateKernel ();
        }

        $cover = new GroundCover();
        $this->generationPopulators[] = $cover;
        $ores = new Ore();
        $ores->setOreTypes([
            new OreType(BlockFactory::get(Block::COAL_ORE), 20, 16, 0, 128),
            new OreType(BlockFactory::get(Block::IRON_ORE), 20, 8, 0, 64),
            new OreType(BlockFactory::get(Block::REDSTONE_ORE), 8, 7, 0, 16),
            new OreType(BlockFactory::get(Block::LAPIS_ORE), 1, 6, 0, 32),
            new OreType(BlockFactory::get(Block::GOLD_ORE), 2, 8, 0, 32),
            new OreType(BlockFactory::get(Block::DIAMOND_ORE), 1, 7, 0, 16),
            new OreType(BlockFactory::get(Block::DIRT), 20, 32, 0, 128),
            new OreType(BlockFactory::get(Block::GRAVEL), 10, 16, 0, 128)
        ]);
        $this->populators[] = $ores;
    }

    /**
     * Generates the generation kernel based on smooth size (here 2)
     */
    protected static function generateKernel() : void{
        self::$GAUSSIAN_KERNEL = [ ];

        $bellSize = 1 / self::$SMOOTH_SIZE;
        $bellHeight = 2 * self::$SMOOTH_SIZE;

        for($sx = - self::$SMOOTH_SIZE; $sx <= self::$SMOOTH_SIZE; $sx++) {
            self::$GAUSSIAN_KERNEL[$sx + self::$SMOOTH_SIZE] = [ ];

            for($sz = - self::$SMOOTH_SIZE; $sz <= self::$SMOOTH_SIZE; $sz++) {
                $bx = $bellSize * $sx;
                $bz = $bellSize * $sz;
                self::$GAUSSIAN_KERNEL[$sx + self::$SMOOTH_SIZE] [$sz + self::$SMOOTH_SIZE] = $bellHeight * exp(- ($bx * $bx + $bz * $bz) / 2);
            }
        }
    }

    /**
     * Return the name of the generator
     *
     * @return string
     */
    public function getName(): string {
        return "islands";
    }

    /**
     * Gives the generators settings.
     *
     * @return array
     */
    public function getSettings(): array {
        return self::$options;
    }

    /**
     * Returns spawn location
     *
     * @return Vector3
     */
    public function getSpawn(): Vector3 {
        return new Vector3(127.5, 128, 127.5);
    }

}