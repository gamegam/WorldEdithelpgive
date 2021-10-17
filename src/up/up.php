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
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerInteractEvent;

class up extends PluginBase implements Listener {

public function onEnable() {
@mkdir ( $this->getDataFolder () );
$this->data= new Config ($this->getDataFolder () . "lau.yml", Config::YAML, );
$this->db = $this->data->getAll ();

$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
}
public function save() {
$this->data->setAll($this->db);
$this->data->save();
}
public function onJoin(\pocketmine\event\player\PlayerJoinEvent $ev){
$p = $ev->getPlayer();
$name = $p->getName();
if (!isset($this->db[$name])){
$this->db[$name]["언어"] = "eng";
}
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
   $p->sendMessage ("§d블럭 꼭지점으로 텔레포트했습니다");
   }else{
   $p->teleport(new Position(floatval($block->x) + 0.5, floatval($block->y) +1, floatval($block->z) + 0.5, $block->getLevel()));
    $ev->setCancelled ();
    $p->sendMessage ("§d이동중...");
    }
   }
  }
 }
public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
$cmd = $command->getName ();

$p = $sender->getPlayer ();
$name = $p->getName();
if ($cmd == "uplau"){
if (!isset($args[0])){
$p->sendMessage("/uplau (kor, eng)");
return true;
}
switch ($args[0]){
case "kor":
$this->db[$name]["언어"] = "kor";
$p->sendMessage("한국어로 변경되었습니다");
$this->save();
break;
case "eng":
$this->db[$name]["언어"] = "eng";
$p->sendMessage("It has been changed to the United States");
$this->save();
}
}elseif ($cmd == "up"){
if (! $p->hasPermission("test")){
return true;
}
if ($this->db[$name]["언어"] == "kor"){
if( ! isset($args[0]) ){
$p->sendMessage("/up <숫자> 치시면 해당 높이 가고 플레이어 발밑에 유리블럭이 생성됩니다.");
$p->sendMessage("/uplau (kor, eng)");
return true;
}
if(!is_numeric($args[0])){
$p->sendMessage("숫자을 써주세요.");
return true;
}
$y = intval($p->y);
if(($y + $args[0]) > 256){
$p->sendMessage("당신이 입력하는 수보다 높이제한수보다 큽니다. (최대: 256블럭)");
return true;
}
if($args[0] < 0){
$p->sendMessage($t."0이상 적어주세요~");
return true;
}
$y = $p->getY();
$p->teleport(new Position(floatval($p->x), floatval($p->y) + 
$args[0], floatval($p->z), $p->getLevel()));
$p->getLevel()->setBlock(new Vector3($p->getX(), $p->getY() -1,
$p->getZ()), Block::get(20));
$p->sendMessage("§b§l{$args[0]}만큼 올라갔습니다.");
return true;
}
if ($this->db[$name]["언어"] == "eng"){
if( ! isset($args[0]) ){
$p->sendMessage("/up <number> goes to that height and a glass block is created at the player's feet.");
$p->sendMessage("/uplau (kor, eng)");
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
}
}elseif ($cmd == "desc"){
if ($this->db[$name]["언어"] == "kor"){
$y = $p->getY();
$p->teleport(new Vector3($p->getX(), $p->getLevel()->getHighestBlockAt($p->getFloorX(), $p->getFloorZ()) + 1, $p->getZ()));
$p->sendMessage("블럭 옥상까지 올라갔습니다.");
return true;
}
if ($this->db[$name]["언어"] == "eng"){
$y = $p->getY();
$p->teleport(new Vector3($p->getX(), $p->getLevel()->getHighestBlockAt($p->getFloorX(), $p->getFloorZ()) + 1, $p->getZ()));
$p->sendMessage("We've reached the roof of the block.");
}
}
return true;
}
}
