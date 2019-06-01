<?php
namespace HotbarSystemManager\System;

use HotbarSystemManager\HotbarSystemManager;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use UiLibrary\UiLibrary;

class CheckQuest {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function CheckQuest($player) {
        if ($player instanceof Player) {
            $form = $this->plugin->ui->SimpleForm(function (Player $player, array $data) {
            });
            if (isset($this->plugin->quest->udata[$player->getName()]["퀘스트 진행중..."])) {
                $quest = $this->plugin->quest->qidata[$this->plugin->quest->udata[$player->getName()]["퀘스트 진행중..."]];
                foreach ($quest as $key => $value) {
                    for ($i = 4; $i < count($quest); $i++) {
                        if ($i == 4) $msg = "\n§c▶ §f진행중인 메인 퀘스트 :\n  - {$quest[0]} - ({$quest[1]})\n  §6▶ §f퀘스트 진행\n";
                        else {
                            $count = $i - 4;
                            $msg .= "    Step {$count} : {$quest[$i]}\n";
                        }
                    }
                }
                foreach ($this->plugin->quest->qidata as $key => $value) {
                    if (!$this->plugin->quest->isQuest($player->getName(), $this->plugin->quest->qidata[$key][0])) {
                        if (!isset($c)) {
                            $c = true;
                            continue;
                        } else {
                            $msg .= "\n§c▶ §f다음 메인 퀘스트 :";
                            $msg .= "\n  - {$this->plugin->quest->qidata[$key][0]} - ({$this->plugin->quest->qidata[$key][1]})\n";
                            $msg .= "  - 필요 레벨 : Lv.{$this->plugin->quest->qidata[$key][3]}\n";
                            if ($this->plugin->quest->qidata[$key][4] !== null)
                                $msg .= "  - 필요 클리어 퀘스트 : {$this->plugin->quest->qidata[$key][4]}\n";
                            break;
                        }
                    }
                }
                if (count($this->plugin->subquest->udata[$player->getName()]["퀘스트 진행중..."]) > 0) {
                    $msg .= "\n§c▶ §f진행중인 서브 퀘스트 :\n";
                    foreach ($this->plugin->subquest->udata[$player->getName()]["퀘스트 진행중..."] as $key => $value) {
                        $msg .= "  - {$this->plugin->subquest->qidata[$value][0]} - ({$value})\n";
                        $msg .= "  §6▶ §f퀘스트 진행\n";
                        for ($i = 1; $i < count($this->plugin->subquest->qidata[$value]); $i++) {
                            $msg .= "    Step {$i} : {$this->plugin->subquest->qidata[$value][$i]}\n";
                        }
                    }
                }
                $msg .= "\n§c▶ §f클리어 한 퀘스트";
                if (count($this->plugin->quest->udata[$player->getName()]["클리어"]) <= 0) {
                    $msg .= "\n  - 없음";
                } else {
                    foreach ($this->plugin->quest->udata[$player->getName()]["클리어"] as $key => $value) {
                        $msg .= "\n  - {$key}";
                    }
                }
                $form->setTitle("Tele Quest");
                $form->setContent($msg);
                $form->sendToPlayer($player);
            } else {
                $form->setTitle("Tele Quest");
                $msg = "";
                $quest = $this->plugin->quest->qidata;
                foreach ($quest as $key => $value) {
                    if (!$this->plugin->quest->isQuest($player->getName(), $quest[$key][0]) && !isset($next)) {
                        $msg .= "\n§c▶ §f다음 메인 퀘스트 :";
                        $msg .= "\n  - {$quest[$key][0]} - ({$quest[$key][1]})\n";
                        $msg .= "  - 필요 레벨 : Lv.{$quest[$key][3]}\n";
                        if ($quest[$key][4] !== null)
                            $msg .= "  - 필요 클리어 퀘스트 : {$quest[$key][4]}\n";
                        $next = true;
                    }
                    if (!isset($this->plugin->quest->udata[$player->getName()]["클리어"][$quest[$key][0]]) and $this->plugin->util->getLevel($player->getName()) >= $quest[$key][3] and isset($this->plugin->quest->udata[$player->getName()]["클리어"][$quest[$key][4]]) && !isset($possible)) {
                        $msg .= "\n§c▶ §f진행 가능한 메인 퀘스트\n  §a▶ §f{$quest[$key][0]}\n    - {$quest[$key][1]} ({$quest[$key][2]})\n";
                        $possible = true;
                    }
                    if (isset($next) && isset($possible))
                        continue;
                }
                $msg .= "\n§c▶ §f클리어 한 퀘스트";
                if (count($this->plugin->quest->udata[$player->getName()]["클리어"]) <= 0) {
                    $msg .= "\n  - 없음";
                } else {
                    foreach ($this->plugin->quest->udata[$player->getName()]["클리어"] as $key => $value) {
                        $msg .= "\n  - {$key}";
                    }
                }
                $form->setContent($msg);
                $form->sendToPlayer($player);
            }
        }
    }
}
