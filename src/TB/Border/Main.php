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

    public function onMove(PlayerMoveEvent $ev){
        $x = $ev->getPlayer()->x;
        $z = $ev->getPlayer()->z;
        $add = $this->getServer()->getSpawnRadius();
        $minZ = $this->getConfig()->get("minZ") + $add;
        $maxZ = $this->getConfig()->get("maxZ")  + $add;
        $minX = $this->getConfig()->get("minX")  + $add;
        $maxX = $this->getConfig()->get("maxX")  + $add;
        if($minX <= $x and $x <= $maxX and $minZ <= $z and $z <= $maxZ){
            $ev->setCancelled(true);
            $message = $this->getConfig()->get("Message1");
            $message1 = $this->getConfig()->get("Message2");
            $ev->getPlayer()->addTitle($message, $message1, 90, 40, 90);
        }
    }
}
