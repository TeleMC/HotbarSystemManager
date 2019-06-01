<?php
namespace HotbarSystemManager\System;

use HotbarSystemManager\HotbarSystemManager;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use UiLibrary\UiLibrary;

class ChatMode {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function ChatMode($player) {
        if ($player instanceof Player) {
            $name = $player->getName();
            $Guild = $this->plugin->Guild->getGuild($name);
            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                $name = $player->getName();
                if (($this->plugin->Guild->isGuild($name) == true) and ($this->plugin->Party->isParty($name) == true)) {
                    if (!isset($data[0]) or !isset($data[1])) return;
                    if ($data[0] == true) $this->plugin->Guild->setChatMode($name, true);
                    if ($data[0] == false) $this->plugin->Guild->setChatMode($name, false);
                    if ($data[1] == true) $this->plugin->Party->setChatMode($name, "on");
                    if ($data[1] == false) $this->plugin->Party->setChatMode($name, "off");
                } elseif (($this->plugin->Guild->isGuild($name) == true) and ($this->plugin->Party->isParty($name) == false)) {
                    if (!isset($data[0])) return;
                    if ($data[0] == true) $this->plugin->Guild->setChatMode($name, true);
                    if ($data[0] == false) $this->plugin->Guild->setChatMode($name, false);
                } elseif (($this->plugin->Guild->isGuild($name) == false) and ($this->plugin->Party->isParty($name) == true)) {
                    if (!isset($data[0])) return;
                    if ($data[0] == true) $this->plugin->Party->setChatMode($name, "on");
                    if ($data[0] == false) $this->plugin->Party->setChatMode($name, "off");
                } elseif (($this->plugin->Guild->isGuild($name) == false) and ($this->plugin->Party->isParty($name) == false)) return;
            });
            $form->setTitle("Tele Menu");
            if (($this->plugin->Guild->isGuild($name) == false) and ($this->plugin->Party->isParty($name) == false)) $form->addLabel("길드와 파티에 소속되어있지 않습니다!");
            if ($this->plugin->Guild->isGuild($name) == true) $form->addToggle("길드 채팅 ( 오프 / 온 )", $this->plugin->Guild->getChatMode($name));
            if ($this->plugin->Party->isParty($name) == true) $form->addToggle("파티 채팅 ( 오프 / 온 )", $this->plugin->Party->getChatMode($name));
            $form->sendToPlayer($player);
        }
    }
}
