<?php

namespace up;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\level\Position;

use pocketmine\Player;

use pocketmine\block\Block;

use pocketmine\math\Vector3;

use pocketmine\event\player\PlayerInteractEvent;

class up extends PluginBase implements Listener {

public function onEnable() {

$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );

}

public function BlockKd(\pocketmine\event\block\BlockBreakEvent $ev){

 $p = $ev->getPlayer();

 $name = $p->getName();

 $block = $ev->getBlock();

 $item = $p->getInventory()->getItemInHand();

 if ($p->isOP()){

 if($item->getId() == 345){

 $p->teleport(new Vector3($p->getX(), $p->getLevel()->getHighestBlockAt($p->getFloorX() + 0.5, $p->getFloorZ()) + 1, $p->getZ()));

 //$p->teleport(new Vector3($block->getX(), $block->getLevel()->getHighestBlockAt($block->getFloorX(), $block->getFloorZ()) + 1, $block->getZ()));

  $ev->setCancelled ();

  }

 }

}

public function onToucsh(PlayerInteractEvent $ev){

  $p = $ev->getPlayer();

  $block = $ev->getBlock();

  $item = $p->getInventory()->getItemInHand();

  if ($p->isOP()){

  if($item->getId() == 345){

  if($ev->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR){

  $p->teleport(new Vector3($p->getX(), $p->getLevel()->getHighestBlockAt($p->getFloorX() + 0.5, $p->getFloorZ()) + 1, $p->getZ()));

   $ev->setCancelled ();

   }else{

   $p->teleport(new Position(floatval($block->x) + 0.5, floatval($block->y) +1, floatval($block->z) + 0.5, $block->getLevel()));

    $ev->setCancelled ();

    }

   }

  }

 }

public function onCommand(CommandSender $p, Command $command, string $label, array $args): bool {

$cmd = $command->getName ();

$name = $p->getName();

if ($cmd == "up"){

 if (! $p instanceof Player){

 $p->sendMessage("Please run it in the in-game!");

 return true;

 }

 if( ! isset($args[0]) ){

 $p->sendMessage("/up <number> goes to that height and a glass block is created at the player's feet.");

return true;

}

if(!is_numeric($args[0])){

$p->sendMessage("Please write a number.");

return true;

}

$y = intval($p->y);

if(($y + $args[0]) > 256){

$p->sendMessage("It is greater than the height limit than the number you enter. (Up: 256 blocks)");

return true;

}

if($args[0] < 0){

$p->sendMessage($t."Write down at least zero");

return true;

}

$y = $p->getY();

$p->teleport(new Position(floatval($p->x), floatval($p->y) + 

$args[0], floatval($p->z), $p->getLevel()));

$p->getLevel()->setBlock(new Vector3($p->getX(), $p->getY() -1,

$p->getZ()), Block::get(20));

$p->sendMessage("§b§l{$args[0]}We're up as far as we can");

}elseif ($cmd == "/desc"){

  if (! $p instanceof Player){

  $p->sendMessage("Please run it in the in-game!");

    return true;

  }

$y = $p->getY();

$p->teleport(new Vector3($p->getX(), $p->getLevel()->getHighestBlockAt($p->getFloorX(), $p->getFloorZ()) + 1, $p->getZ()));

$p->sendMessage("We've reached the roof of the block.");

  }

return true;

}

}
