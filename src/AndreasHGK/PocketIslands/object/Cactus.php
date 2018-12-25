<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\object;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class Cactus{

    public static function growCactus(ChunkManager $level, Vector3 $pos, Random $random, int $count = 15, int $radius = 10) : void{

        for($c = 0; $c < $count; ++$c){
            $x = $random->nextRange($pos->x - $radius, $pos->x + $radius);
            $z = $random->nextRange($pos->z - $radius, $pos->z + $radius);
            if($level->getBlockAt($x, $pos->y + 1, $z)->getId() === Block::AIR and $level->getBlockAt($x, $pos->y, $z)->getId() === Block::GRASS){
                $level->setBlockAt($x, $pos->y + 1, $z, $arr[$random->nextRange(0, $arrC)]);
            }
        }
    }

    private function randomHeight(Random $random) : int{
        return $random->nextRange(1, 3);
    }

    private function growCactus() : void{
        $height = $this->randomHeight(new Random());
        for($h = 0; $h < $height; $h++){
            $this->level->setBlockAt($x, $y+$h, $z, Block::CACTUS);
        }
    }
}