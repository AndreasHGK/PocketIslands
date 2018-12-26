<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use AndreasHGK\PocketIslands\object\PalmTree as ObjectPalm;
use pocketmine\utils\Random;
use pocketmine\level\generator\populator\Populator;

class PalmTree extends Populator{
    /** @var ChunkManager */
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
            $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
            $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if($y === -1){
                continue;
            }
            ObjectPalm::placeObject($this->level, $x, $y, $z, $random);
        }
    }
    private function getHighestWorkableBlock(int $x, int $z) : int{
        for($y = 127; $y > 0; --$y){
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if($b === Block::SAND){
                break;
            }elseif($b !== Block::AIR and $b !== Block::SNOW_LAYER){
                return -1;
            }
        }
        return ++$y;
    }
}