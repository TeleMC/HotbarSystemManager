<?php
namespace HotbarSystemManager\System;

use HotbarSystemManager\HotbarSystemManager;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use UiLibrary\UiLibrary;

class User {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function User($player) {
        if ($player instanceof Player) {
            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
                $speed = $this->plugin->sdata["유저속도"];
                if (!isset($data[2])) return;
                if ($data[2] == false) {
                    $this->plugin->sdata["유저채팅"] = "허용";
                }
                if ($data[2] == true) {
                    $this->plugin->sdata["유저채팅"] = "금지";
                }
                if ($data[3] == false) {
                    $this->plugin->sdata["유저전투"] = "허용";
                }
                if ($data[3] == true) {
                    $this->plugin->sdata["유저전투"] = "금지";
                }
                if ($data[4] == false) {
                    $this->plugin->sdata["유저사냥"] = "허용";
                }
                if ($data[4] == true) {
                    $this->plugin->sdata["유저사냥"] = "금지";
                }
                if ($data[5] == false) {
                    $this->plugin->sdata["유저이동"] = "허용";
                }
                if ($data[5] == true) {
                    $this->plugin->sdata["유저이동"] = "금지";
                }
                if ($data[6] == false) {
                    $this->plugin->sdata["유저워프"] = "허용";
                }
                if ($data[6] == true) {
                    $this->plugin->sdata["유저워프"] = "금지";
                }
                if ($data[7] == false) {
                    $this->plugin->sdata["유저줍기"] = "허용";
                }
                if ($data[7] == true) {
                    $this->plugin->sdata["유저줍기"] = "금지";
                }
                if ($data[8] == false) {
                    $this->plugin->sdata["유저버리기"] = "허용";
                }
                if ($data[8] == true) {
                    $this->plugin->sdata["유저버리기"] = "금지";
                }
                if ($data[9] == 0) {
                    $this->plugin->sdata["유저속도"] = 0.1;
                }
                if ($data[9] !== 0) {
                    $this->plugin->sdata["유저속도"] = 0.1 + ($data[9] / 100);
                }
                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                    $attribute = $players->getAttributeMap()->getAttribute(5)->getValue();
                    $add = 1;
                    if ($this->plugin->skill->isSkill($player->getName(), "아처의 정신"))
                        $add *= $this->plugin->getSkillInfo("아처의 정신", $this->plugin->skill->getSkillLevel($player->getName(), "아처의 정신"));
                    $players->getAttributeMap()->getAttribute(5)->setValue(($attribute * ($this->plugin->sdata["유저속도"] * 100) / ($speed * 100)) * $add);
                    if ($players->isOp()) {
                        $players->sendMessage("{$this->plugin->pre} {$player->getName()}님이 유저관리를 제어하였습니다.");
                        $players->sendMessage("{$this->plugin->pre} 유저채팅 ({$this->plugin->sdata["유저채팅"]}), 유저전투 ({$this->plugin->sdata["유저전투"]})");
                        $players->sendMessage("{$this->plugin->pre} 유저사냥 ({$this->plugin->sdata["유저사냥"]}), 유저이동 ({$this->plugin->sdata["유저이동"]})");
                        $players->sendMessage("{$this->plugin->pre} 유저워프 ({$this->plugin->sdata["유저워프"]}), 아이템 줍기 ({$this->plugin->sdata["유저줍기"]})");
                        $players->sendMessage("{$this->plugin->pre} 아이템 버리기 ({$this->plugin->sdata["유저버리기"]}), 유저 속도 ({$this->plugin->sdata["유저속도"]})");
                    }
                }
            });
            $arr = ["1.0", "1.1", "1.2", "1.3", "1.4", "1.5", "1.6", "1.7", "1.8", "1.9", "2.0"];
            $form->setTitle("Tele Admin");
            $form->addLabel("§a▶ §f온라인 유저의 행동을 제어합니다.");
            $form->addLabel("§c▶ §f해당 관리사항은 모두 로그로 기록되오니,\n  §f부정 사용으로 적발시 불이익이 있을 수 있습니다.");
            $form->addToggle("유저 채팅 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저채팅"));
            $form->addToggle("유저 전투 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저전투"));
            $form->addToggle("유저 사냥 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저사냥"));
            $form->addToggle("유저 이동 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저이동"));
            $form->addToggle("유저 워프 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저워프"));
            $form->addToggle("유저 아이템줍기 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저줍기"));
            $form->addToggle("유저 아이템버리기 관리 ( 허용 / 금지 )", $this->plugin->getData1("유저버리기"));
            $form->addStepSlider("유저 속도 제어", $arr, ($this->plugin->sdata["유저속도"] * 100) - 10);
            $form->sendToPlayer($player);
        }
    }
}
