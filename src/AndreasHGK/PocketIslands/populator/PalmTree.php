<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\populator;

use pocketmine\block\Block;
use pocketmine\block\utils\WoodType;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\Tree as ObjectTree;
use pocketmine\utils\Random;
use pocketmine\level\generator\populator\Populator;

class PalmTree extends Populator{
    /** @var ChunkManager */
    private $level;
    private $randomAmount;
    private $baseAmount;
    private $type;
    public function __construct(int $type = WoodType::JUNGLE){
        $this->type = $type;
    }
    public function setRandomAmount(int $amount) : void{
        $this->randomAmount = $amount;
    }
    public function setBaseAmount(int $amount) : void{
        $this->baseAmount = $amount;
    }
    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void{
        $this->level = $level;
        $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
        for($i = 0; $i < $amount; ++$i){
            $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
            $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if($y === -1){
                continue;
            }
            ObjectTree::growTree($this->level, $x, $y, $z, $random, $this->type);
        }
    }
    private function getHighestWorkableBlock(int $x, int $z) : int{
        for($y = 127; $y > 0; --$y){
            $b = $this->level->getBlockAt($x, $y, $z)->getId();
            if($b === Block::DIRT or $b === Block::GRASS){
                break;
            }elseif($b !== Block::AIR and $b !== Block::SNOW_LAYER){
                return -1;
            }
        }
        return ++$y;
    }
}