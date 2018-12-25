<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\populator;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class DeadBush extends Populator {
    private $level;
    private $randomAmount;
    private $baseAmount;
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
            $x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
            $z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if($y !== -1){
                $this->level->setBlockIdAt($x, $y, $z, Block::DEAD_BUSH);
            }
        }
    }



    private function getHighestWorkableBlock(int $x, int $z) : int{
        for($y = 127; $y >= 0; --$y){
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if($b === Block::SAND){
                break;
            }
        }
        return $y === 0 ? -1 : ++$y;
    }
}