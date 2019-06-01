<?php
namespace HotbarSystemManager\System;

use HotbarSystemManager\HotbarSystemManager;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use UiLibrary\UiLibrary;

class Profile {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function Profile($player) {
        if ($player instanceof Player) {
            $per = "％";
            $name = $player->getName();
            $money = $this->plugin->money->getMoney($name);
            $Level = $this->plugin->util->getLevel($name);
            $Exp = $this->plugin->util->getExp($name);
            $MaxExp = $this->plugin->util->getMaxExp($name);
            $AllExp = $this->plugin->util->getAllExp($name);
            $ExpBar = $this->plugin->util->ExpBar($player);
            $ExpPercentage = round(($Exp / $MaxExp) * 10000) / 100;
            $Job = $this->plugin->util->getJob($name);
            $ATK = $this->plugin->util->getATK($name);
            $DEF = $this->plugin->util->getDEF($name);
            $MATK = $this->plugin->util->getMATK($name);
            $MDEF = $this->plugin->util->getMDEF($name);
            $e_ATK = $this->plugin->Equipments->getATK($player);
            $e_DEF = $this->plugin->Equipments->getDEF($player);
            $e_MATK = $this->plugin->Equipments->getMATK($player);
            $e_MDEF = $this->plugin->Equipments->getMDEF($player);
            $STR = $this->plugin->Stat->getStat($name, "힘");
            $SPD = $this->plugin->Stat->getStat($name, "민첩");
            $LUK = $this->plugin->Stat->getStat($name, "운");
            $HP = $this->plugin->Stat->getStat($name, "체력");
            $INT = $this->plugin->Stat->getStat($name, "지능");
            $Guild = $this->plugin->Guild->getGuild($name);
            $All_ATK = (float) $ATK + (float) $e_ATK;
            $All_MATK = (float) $MATK + (float) $e_MATK;
            $All_DEF = (float) $DEF + (float) $e_DEF;
            $All_MDEF = (float) $MDEF + (float) $e_MDEF;
            $inJob = $this->plugin->ability->getInbornJob($player->getName());
            $d = $this->plugin->ability->getAbility($player->getName());
            $AllBorns = $this->plugin->ability->getAllBorns($player->getName());
            $borns = $this->plugin->ability->getBorns($player->getName());
            $a = "";
            $b = "";
            if (count($AllBorns) > 0) {
                foreach ($AllBorns as $ability => $point) {
                    $a .= "  - {$ability}: {$point}\n";
                }
            }
            if (count($borns) > 0) {
                foreach ($borns as $key => $ability) {
                    $b .= "  - {$ability}\n";
                }
            }
            $form = $this->plugin->ui->CustomForm(function (Player $player, array $data) {
            });
            $form->setTitle("Tele Menu");
            $form->addLabel("§c▶ §f기본 정보\n  §f- 돈 : {$money}테나\n  §f- 직업 : {$Job}\n  §f- 레벨 : Lv.{$Level}\n  §f- 경험치 : {$Exp} / {$MaxExp} ({$ExpPercentage}{$per})\n  §f- 누적경험치 : {$AllExp}\n  {$ExpBar}");
            $form->addLabel("§c▶ §f스탯\n  §f- 힘 : {$STR}\n  §f- 지능 : {$INT}\n  §f- 민첩 : {$SPD}\n  §f- 체력 : {$HP}\n  §f- 운 : {$LUK}");
            $form->addLabel("§c▶ §f피지컬 ( 기본 피지컬 + §a장비 피지컬 §f+ §b스탯 피지컬 §f)\n  §f- ATK : {$All_ATK}\n  §f- DEF : {$All_DEF}\n  §f- MATK : {$All_MATK}\n  §f- MDEF : {$All_MDEF}");
            $form->addLabel("§c▶ §f천직 및 천성\n  천직 : {$inJob}\n  천성 : {$d}");
            $form->addLabel("§c▶ §f재능\n  §f숙련도:\n{$a}  §f재능:\n{$b}");
            $form->addLabel("§c▶ §f소속 길드 : {$Guild}");
            $form->sendToPlayer($player);
        }
    }
}
