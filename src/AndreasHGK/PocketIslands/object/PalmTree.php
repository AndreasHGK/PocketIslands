<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\object;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Wood;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;
use pocketmine\level\generator\object\Tree;

class PalmTree extends Tree{

    public function __construct(){
        parent::__construct(BlockFactory::get(Block::LOG, Wood::JUNGLE), BlockFactory::get(Block::LEAVES, Wood::JUNGLE), 10);
    }

    public function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void{
        $this->treeHeight = $random->nextBoundedInt(4) + 6;
        $topSize = $this->treeHeight - (1 + $random->nextBoundedInt(2));
        $lRadius = 2 + $random->nextBoundedInt(2);
        $this->placeTrunk($level, $x, $y, $z, $random, $this->treeHeight - $random->nextBoundedInt(3));
        $radius = $random->nextBoundedInt(2);
        $maxR = 1;
        $minR = 0;
        for($yy = 0; $yy <= $topSize; ++$yy){
            $yyy = $y + $this->treeHeight - $yy;
            for($xx = $x - $radius; $xx <= $x + $radius; ++$xx){
                $xOff = abs($xx - $x);
                for($zz = $z - $radius; $zz <= $z + $radius; ++$zz){
                    $zOff = abs($zz - $z);
                    if($xOff === $radius and $zOff === $radius and $radius > 0){
                        continue;
                    }
                    if(!$level->getBlockAt($xx, $yyy, $zz)->isSolid()){
                        $level->setBlockAt($xx, $yyy, $zz, $this->leafBlock);
                    }
                }
            }
            if($radius >= $maxR){
                $radius = $minR;
                $minR = 1;
                if(++$maxR > $lRadius){
                    $maxR = $lRadius;
                }
            }else{
                ++$radius;
            }
        }
    }
}