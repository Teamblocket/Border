<?php

namespace TB\Border;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    public function onEnable(){
        $this->getServer()->getLogger()->info("World Border Plugin Made by TB!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }
    
    public function retrieveData($data){
        return $this->getConfig()->get($data);
    }

    public function onMove(PlayerMoveEvent $ev){
        $x = $ev->getPlayer()->x;
        $z = $ev->getPlayer()->z;
        $minZ = $this->retrieveData("minZ");
        $maxZ = $this->retrieveData("maxZ");
        
        $minX = $this->retrieveData("minX");
        $maxX = $this->retrieveData("maxX");
        if($minX <= $x and $x <= $maxX and $minZ <= $z and $z <= $maxZ){
            $ev->setCancelled(true);
            $message = array($this->retrieveData("Message1"), $this->retrieveData("Message2"));
            $ev->getPlayer()->addTitle($message[0], $message[1], 90, 40, 90);
        }
    }
}
