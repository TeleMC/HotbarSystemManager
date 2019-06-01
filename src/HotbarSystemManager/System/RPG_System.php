<?php
namespace HotbarSystemManager\System;

use HotbarSystemManager\HotbarSystemManager;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use UiLibrary\UiLibrary;

class RPG_System {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function RPG_System($player) {
        if ($player instanceof Player) {
            $form = $this->plugin->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $form = $this->plugin->ui->SimpleForm(function (Player $player, array $data) {
                        if (!is_numeric($data[0])) return;
                        if ($data[0] == 0) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["나이트"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("나이트", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 나이트 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 나이트 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 1) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["아처"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("아처", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 아처 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 아처 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 2) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["마법사"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("마법사", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 마법사 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 마법사 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 3) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["마법사"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("프리스트", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 프리스트 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 프리스트 무기류 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 4) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["모자"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("모자", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 모자 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 모자 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 5) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["상의"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("상의", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 상의 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 상의 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 6) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["하의"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("하의", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 하의 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 하의 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 7) {
                            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                                if (!isset($data[0]) or !isset($data[1]) or !is_numeric($data[1])) {
                                    $player->sendMessage("{$this->plugin->pre} 제대로 기입하여주세요.");
                                    return;
                                }
                                if (!isset($this->plugin->Equipments->eqdata["신발"][$data[0]])) {
                                    $player->sendMessage("{$this->plugin->pre} 해당 이름의 장비는 존재하지 않습니다.");
                                    return;
                                }
                                $this->plugin->Equipments->adjustEquipment("신발", $data[0], $data[1]);
                                $player->sendMessage("{$this->plugin->pre} 신발 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                                    if ($players->isOp()) {
                                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 신발 방어구 {$data[0]}의 피지컬 수치를 {$data[1]}(으)로 수정하였습니다.");
                                    }
                                }
                            });
                            $form->setTitle("Tele Admin");
                            $form->addInput("장비 이름", "장비 이름을 입력해주세요...");
                            $form->addInput("피지컬 수치", "피지컬 수치를 입력해주세요...");
                            $form->addLabel("§a▶ §f장비의 기본 피지컬 수치를 수정하는곳입니다.");
                            $form->addLabel("§c▶ §f해당 기능으로 장비 기본 피지컬 수치를 수정할 경우,\n  §f해당 수정사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
                            $form->sendToPlayer($player);
                        }
                        if ($data[0] == 8) {

                        }
                        if ($data[0] == 9) {

                        }
                    });
                    $form->setTitle("Tele Admin");
                    $form->addButton("§l나이트 무기류\n§r§8나이트 무기류 수치를 수정합니다.");
                    $form->addButton("§l아처 무기류\n§r§8아처 무기류 수치를 수정합니다.");
                    $form->addButton("§l마법사 무기류\n§r§8마법사 무기류 수치를 수정합니다.");
                    $form->addButton("§l프리스트 무기류\n§r§8프리스트 무기류 수치를 수정합니다.");
                    $form->addButton("§l모자 방어구\n§r§8모자 방어구 수치를 수정합니다.");
                    $form->addButton("§l상의 방어구\n§r§8상의 방어구 수치를 수정합니다.");
                    $form->addButton("§l하의 방어구\n§r§8하의 방어구 수치를 수정합니다.");
                    $form->addButton("§l신발 방어구\n§r§8신발 방어구 수치를 수정합니다.");
                    $form->addButton("§l반지류\n§r§8반지류 수치를 수정합니다.");
                    $form->addButton("§l펜던트류\n§r§8펜던트류 수치를 수정합니다.");
                    $form->sendToPlayer($player);
                }
            });
            $form->setTitle("Tele Admin");
            $form->addButton("§l장비 수치조정\n§r§8장비 피지컬 수치를 조정합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }
}
