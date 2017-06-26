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
    
    public function retrieveConfig($config){
        switch($config){
                
            case "minZ":
                return $this->getConfig()->get("minZ");
                break;
                
            case "maxZ":
                return $this->getConfig()->get("maxZ");
                break;
                
            case "minX":
                return $this->getConfig()->get("minX");
                break;
                
            case "maxX":
                return $this->getConfig()->get("maxX");
                break;
                
            case "msg1":
                return $this->getConfig()->get("Message1");
                break;
                
            case "msg2":
                return $this->getConfig()->get("Message2");
                break;
        }
    }

    public function onMove(PlayerMoveEvent $ev){
        $x = $ev->getPlayer()->x;
        $z = $ev->getPlayer()->z;
        $minZ = $this->retrieveConfig("minZ");
        $maxZ = $this->retrieveConfig("maxZ");
        
        $minX = $this->retrieveConfig("minX");
        $maxX = $this->retrieveConfig("maxX");
        if($minX <= $x and $x <= $maxX and $minZ <= $z and $z <= $maxZ){
            $ev->setCancelled(true);
            $message = array($this->retrieveConfig("msg1"), $this->retrieveConfig("msg2"));
            $ev->getPlayer()->addTitle($message[0], $message[1], 90, 40, 90);
        }
    }
}
