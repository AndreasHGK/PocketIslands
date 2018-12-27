<?php

declare(strict_types=1);

namespace AndreasHGK\PocketIslands\populator;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Liquid;
use pocketmine\level\biome\Biome;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class GroundCoverPlus extends Populator {

    //make sure the snow doesn't interfere with mountains
    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void{
        $chunk = $level->getChunk($chunkX, $chunkZ);
        for($x = 0; $x < 16; ++$x){
            for($z = 0; $z < 16; ++$z){
                $biome = Biome::getBiome($chunk->getBiomeId($x, $z));
                $cover = $biome->getGroundCover();
                if(count($cover) > 0){
                    $diffY = 0;
                    if(!$cover[0]->isSolid()){
                        $diffY = 1;
                    }
                    for($y = 127; $y > 0; --$y){
                        $id = $chunk->getBlockId($x, $y, $z);
                        if($id !== Block::AIR and !BlockFactory::get($id)->isTransparent()){
                            break;
                        }
                    }
                    $startY = min(127, $y + $diffY);
                    $endY = $startY - count($cover);
                    for($y = $startY; $y > $endY and $y >= 0; --$y){
                        $b = $cover[$startY - $y];
                        $id = $chunk->getBlockId($x, $y, $z);
                        if($id === Block::AIR and $b->isSolid()){
                            break;
                        }
                        if($b->canBeFlowedInto() and BlockFactory::get($id) instanceof Liquid){
                            continue;
                        }
                        if($y < 127) {
                            $chunk->setBlock($x, $y, $z, $b->getId(), $b->getDamage());
                        }
                    }
                }
            }
        }
    }
}