<?php

declare(strict_types=1);

namespace JoinUIWorking;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
//use pocketmine\event\player\PlayerPreLoginEvent; - TODO?

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getLogger()->info("§aJoinUIWorking enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
    }
    
    public function onDisable()
    {
        $this->getLogger()->info("§cJoinUIWorking disabled!");
    }
    
    public function onJoin(PlayerJoinEvent $event)
    {
        if ($this->getConfig()->get("enabled-joinui") == "true") {
            $player = $event->getPlayer();
            if ($player instanceof Player) {
                $this->openUI($player);
            }
        }
        
        if($this->getConfig()->get("enabled-joinui") == "false") {
            $player = $event->getPlayer();
            $player->sendMessage($this->getConfig()->get("no-joinui-message"));
        }
    }
    
    public function openUI($player)
    {
        $form = new SimpleForm(function (Player $player, $data) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    break;
            }
        });
        
        $form->setTitle($this->getConfig()->get("joinui-title"));
        $form->setContent(str_replace(["{player}", "&"], [$player->getName(), "§"], $this->getConfig()->get("joinui-message")));
        $form->addButton($this->getConfig()->get("joinui-button"));
        $form->sendToPlayer($player);
        return true;
    }
}

