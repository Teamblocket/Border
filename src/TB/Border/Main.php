<?php

namespace TB\Border;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;


class Main extends PluginBase{
    
    public $prefs;
    
    public function onEnable(){
        $this->getServer()->getLogger()->info("World Border Plugin Made by Angel(@VortexZMcPe)!");
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new BorderCheck($this), 0);
        if(!file_exists($this->getDataFolder() . "prefs.yml")){
            $this->prefs = new Config($this->getDataFolder() . "prefs.yml", Config::YAML, [
            "Border" => 5000,
            "Message" => ["1" => "Border Reached!", "2" => "You have reached the end of the world"]
             ]);
            $this->prefs->save();
        }
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function inBorder(Player $player){
        $v = new \pocketmine\math\Vector3($player->getLevel()->getSpawnLocation()->getX(),$player->getPosition()->getY(),$player->getLevel()->getSpawnLocation()->getZ());
        if($player->getPosition()->distance($v) <= $this->prefs->get("Border")) {
            return true;
            // in border
        }
    }
}

class BorderCheck extends PluginTask{
    
    public function __construct(Main $plugin){
        parent::__construct($plugin):
        $this->plugin = $plugin;
    }
    
    public function onRun(int $currentTicks){
        $messages = $this->plugin->prefs->get("Message");
        $this->getOwner();
        foreach($this->plugin->getServer()->getOnlinePlayers() as $players){
            $player = $players;
            if(!$this->plugin->inBorder($player)){
                $coords = new Vector3($player->getX(), $player->getY(), $player()->getZ());
                $player->teleport($coords):
                $player->addTitle($messages["1"], $messages["2"], 50, 90, 40);
            }
        }
    }
}
