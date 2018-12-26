<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\object;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Wood;
use pocketmine\block\Leaves;
use pocketmine\level\ChunkManager;
use pocketmine\level\SimpleChunkManager;
use pocketmine\utils\Random;
use pocketmine\level\generator\object\Tree;

class PalmTree{

    public static function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random) : void{
        $trunkheight = $random->nextRange(5, 9);
        $offset = 0;
        $offsetq = 0;
        $offsetdirection = $random->nextRange(1, 4);
        $ox = 0;
        $oz = 0;
        for($t = 0; $t < $trunkheight; ++$t){
            if($random->nextRange(0, $offsetq) > 2){
                ++$offset;
                $offsetq = 0;
                switch ($offsetdirection){
                    case 1:
                        $ox = $offset;
                        $oz = 0;
                        break;
                    case 2:
                        $ox = 0;
                        $oz = $offset;
                        break;
                    case 3:
                        $ox = -$offset;
                        $oz = 0;
                        break;
                    case 4:
                        $ox = 0;
                        $oz = -$offset;
                        break;
                }
            }
            $level->setBlockIdAt($x+$ox, $y+$t, $z+$oz, Block::LOG);
            $level->setBlockDataAt($x+$ox, $y+$t, $z+$oz, Wood::JUNGLE);
            $offsetq++;
        }
        $level->setBlockIdAt($x+$ox, $y+$t+1, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox-1, $y+$t, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox+1, $y+$t, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t, $z+$oz+1, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t, $z+$oz-1, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t, $z+$oz+2, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t, $z+$oz-2, Block::LEAVES);
        $level->setBlockIdAt($x+$ox+2, $y+$t, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox-2, $y+$t, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox-3, $y+$t-1, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox+3, $y+$t-1, $z+$oz, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t-1, $z+$oz+3, Block::LEAVES);
        $level->setBlockIdAt($x+$ox, $y+$t-1, $z+$oz-3, Block::LEAVES);

        $level->setBlockDataAt($x+$ox, $y+$t+1, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox-1, $y+$t, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox+1, $y+$t, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t, $z+$oz+1, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t, $z+$oz-1, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t, $z+$oz+2, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t, $z+$oz-2, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox+2, $y+$t, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox-2, $y+$t, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox-3, $y+$t-1, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox+3, $y+$t-1, $z+$oz, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t-1, $z+$oz+3, Leaves::JUNGLE);
        $level->setBlockDataAt($x+$ox, $y+$t-1, $z+$oz-3, Leaves::JUNGLE);
    }
}