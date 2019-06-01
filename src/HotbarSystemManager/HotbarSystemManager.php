<?php
namespace HotbarSystemManager;

use AbilityManager\AbilityManager;
use AreaManager\AreaManager;
use BGMManager\BGMManager;
use Core\Core;
use Core\util\Util;
use Equipments\Equipments;
use FriendManager\FriendManager;
use GuildManager\GuildManager;
use GuiLibrary\GuiLibrary;
use HotbarSystemManager\System\ChatMode;
use HotbarSystemManager\System\CheckQuest;
use HotbarSystemManager\System\Profile;
use HotbarSystemManager\System\RPG_System;
use HotbarSystemManager\System\User;
use Monster\Monster;
use Navigation\Navigation;
use ParticleManager\ParticleManager;
use PartyManager\PartyManager;
use PlayerInfo\PlayerInfo;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use PrefixManager\PrefixManager;
use QuestManager\QuestManager;
use ReportManager\ReportManager;
use SkillManager\SkillManager;
use Status\Status;
use SubQuestManager\SubQuestManager;
use TeleCash\TeleCash;
use TeleMoney\TeleMoney;
use UiLibrary\UiLibrary;

class HotbarSystemManager extends PluginBase {

    private static $instance = null;
    //public $pre = "§l§e[ §f시스템 §e]§r§e";
    public $pre = "§e•";
    public $slot = [];

    public static function getInstance() {
        return self::$instance;
    }

    public function onLoad() {
        self::$instance = $this;
    }

    public function onEnable() {
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->server = new Config($this->getDataFolder() . "server.yml", Config::YAML, [
                "유저채팅" => "허용",
                "유저전투" => "금지",
                "유저사냥" => "허용",
                "유저이동" => "허용",
                "유저워프" => "허용",
                "유저줍기" => "허용",
                "유저버리기" => "허용",
                "유저속도" => 0.1
        ]);
        $this->sdata = $this->server->getAll();
        $this->vector = new Config($this->getDataFolder() . "vector.yml", Config::YAML);
        $this->vdata = $this->vector->getAll();
        $this->core = Core::getInstance();
        $this->util = new Util($this->core);
        $this->money = TeleMoney::getInstance();
        $this->cash = TeleCash::getInstance();
        $this->ui = UiLibrary::getInstance();
        $this->Guild = GuildManager::getInstance();
        $this->Party = PartyManager::getInstance();
        $this->Prefix = PrefixManager::getInstance();
        $this->Equipments = Equipments::getInstance();
        $this->Stat = Status::getInstance();
        $this->Monster = Monster::getInstance();
        $this->quest = QuestManager::getInstance();
        $this->subquest = SubQuestManager::getInstance();
        $this->navigation = Navigation::getInstance();
        $this->gui = GuiLibrary::getInstance();
        $this->skill = SkillManager::getInstance();
        $this->area = AreaManager::getInstance();
        $this->ability = AbilityManager::getInstance();
        $this->bgm = BGMManager::getInstance();
        $this->playerinfo = PlayerInfo::getInstance();
        $this->particle = ParticleManager::getInstance();
        $this->friend = FriendManager::getInstance();
        $this->report = ReportManager::getInstance();
        $this->Profile = new Profile($this);
        $this->ChatMode = new ChatMode($this);
        $this->checkquest = new CheckQuest($this);
        $this->RPG_System = new RPG_System($this);
        $this->User = new User($this);
    }

    public function onDisable() {
        $this->save();
    }

    public function save() {
        $this->server->setAll($this->sdata);
        $this->server->save();
        $this->vector->setAll($this->vdata);
        $this->vector->save();
    }

    public function MenuUI($player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->ProfileUI($player);
                }
                if ($data[0] == 1) {
                    $this->checkquest->checkquest($player);
                }
                if ($data[0] == 2) {
                    $this->area->AreaUI($player);
                }
                if ($data[0] == 3) {
                    $this->CommunityUI($player);
                }
                if ($data[0] == 4) {
                    $this->ConvenienceUI($player);
                }
                if ($data[0] == 5) {
                    $this->CreditUI($player);
                }
                if ($data[0] == 6) {
                    $this->SettingUI($player);
                }
                if ($data[0] == 7) {
                    $this->playerinfo->PlayerInfoUI($player);
                }
                if ($data[0] == 8) {
                    $this->TransferUI($player);
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l프로필\n§r§8자신의 정보를 관리합니다.");
            $form->addButton("§l퀘스트\n§r§8퀘스트 정보를 확인합니다.");
            $form->addButton("§l사유지\n§r§8사유지 기능을 실행합니다.");
            $form->addButton("§l커뮤니티\n§r§8커뮤니티 관련 기능을 실행합니다.");
            $form->addButton("§l편의 기능\n§r§8편의 기능을 실행합니다.");
            $form->addButton("§l크레딧\n§r§8크레딧 기능을 이용합니다.");
            $form->addButton("§l사용자 설정\n§r§8사용자 설정을 관리합니다.");
            $form->addButton("§l사용자 정보\n§r§8사용자 정보를 확인합니다.");
            $form->addButton("§l디멘션 이동\n§r§8서버 이동 기능을 실행합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function ProfileUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->Profile->Profile($player);
                }
                if ($data[0] == 1) {
                    $this->skill->SkillUI($player);
                }
                if ($data[0] == 2) {
                    $this->Stat->StatUI($player);
                }
                if ($data[0] == 3) {
                    $this->Equipments->Equipment($player);
                }
                if ($data[0] == 4) {
                    $this->Monster->EtcUI($player);
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l프로필\n§r§8자신의 정보를 확인합니다.");
            $form->addButton("§l스킬\n§r§8스킬 기능을 실행합니다.");
            $form->addButton("§l스탯\n§r§8스탯 기능을 실행합니다.");
            $form->addButton("§l장비 장착\n§r§8장비창을 엽니다.");
            $form->addButton("§l전리품목록\n§r§8보유한 전리품목록을 봅니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function CommunityUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->Party->PartyUI($player);
                }
                if ($data[0] == 1) {
                    $this->Guild->GuildUI($player);
                }
                if ($data[0] == 2) {
                    $this->friend->FriendUI($player);
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l파티\n§r§8파티 기능을 실행합니다.");
            $form->addButton("§l길드\n§r§8길드 기능을 실행합니다.");
            $form->addButton("§l친구\n§r§8친구 기능을 실행합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function ConvenienceUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->navigation->NavigationUI($player);
                }
                if ($data[0] == 1) {
                    $tile = $this->gui->addWindow($player, "쓰레기통", 1);
                    $tile[0]->send($player);
                }
                if ($data[0] == 2) {
                    $this->report->ReportUI($player);
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l길 찾기\n§r§8길 안내를 시작합니다.");
            $form->addButton("§l쓰레기통\n§r§8필요없는 아이템을 버립니다.");
            $form->addButton("§l신고\n§r§8정상적이지 않은 플레이어나 시스템을 신고합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function CreditUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    if (!isset($this->vdata[$player->getName()])) {
                        $this->vdata[$player->getName()] = "{$player->getFloorX()}:{$player->getFloorY()}:{$player->getFloorZ()}:{$player->getLevel()->getName()}";
                        $player->teleport(new Position(346, 24, 1099, $this->getServer()->getLevelByName("ReWorld")));
                        $this->save();
                    } else {
                        $vec = explode(":", $this->vdata[$player->getName()]);
                        $player->teleport(new Position((float) $vec[0], (float) $vec[1], (float) $vec[2], $this->getServer()->getLevelByName($vec[3])));
                        unset($this->vdata[$player->getName()]);
                        $this->save();
                    }
                }
                if ($data[0] == 1) {
                    $this->cash->CashUI($player);
                }
                if ($data[0] == 2) {
                    $this->particle->ParticleUI($player);
                }
            });
            $form->setTitle("Tele Credit");
            if (!isset($this->vdata[$player->getName()]))
                $form->addButton("§l크레딧 상점\n§r§8크레딧 상점으로 이동합니다.");
            else
                $form->addButton("§l본래 위치\n§r§8본래 위치로 이동합니다.");
            $form->addButton("§l크레딧 충전\n§r§8코드를 이용하여 크레딧을 충전합니다.");
            $form->addButton("§l잔상 효과\n§r§8보유한 잔상 효과를 확인합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function SettingUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->Prefix->PrefixUI($player);
                }
                if ($data[0] == 1) {
                    $this->ChatMode->ChatMode($player);
                }
                if ($data[0] == 2) {
                    if ($this->bgm->udata[$player->getName()]["bgm"] == false) {
                        $this->bgm->setBgmPlaying($player, true);
                        $player->sendMessage("{$this->pre} 배경음악을 재생하였습니다.");
                    } elseif ($this->bgm->udata[$player->getName()]["bgm"] == true) {
                        $this->bgm->setBgmPlaying($player, false);
                        $player->sendMessage("{$this->pre} 배경음악을 정지하였습니다.");
                    }
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l칭호\n§r§8칭호 기능을 실행합니다.");
            $form->addButton("§l채팅 모드\n§r§8길드/채팅 모드를 관리합니다.");
            $form->addButton("§l배경음악 On, Off\n§r§8배경음악을 재생하거나 정지합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    /*public function Transfer(Player $player, port $port){
      if(isset($this->transfer[$player->getName()])) return false;
      $this->transfer[$player->getName()] = true;
      $name = $this->getIpPort($key)[2];
      $player->addTitle("{$name}§r§f로의 여행을 시작합니다.", "§f즐거운 여행이 되시길 바랍니다.");
      $this->getScheduler()->scheduleDelayedTask(
        new class($player, $this->getIpPort($key)[0], $this->getIpPort($key)[1]) extends Task{
          public function __construct(Player $player, string $ip, string $port){
            $this->player = $player;
            $this->ip = $ip;
            $this->port = (int)$port;
          }
          public function onRun($currentTick){
            if($this->player instanceof Player){
              $this->player->transfer($this->ip, $this->port);
            }
          }
        }, 4*20);
    }*/

    public function TransferUI(Player $player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    if ($this->getServer()->getPort() == 19132) {
                        $player->sendMessage("{$this->pre} 이미 접속중입니다.");
                        return false;
                    }
                    $player->transfer("atn.pe.kr", 19132);
                }
                if ($data[0] == 1) {
                    if ($this->getServer()->getPort() == 19131) {
                        $player->sendMessage("{$this->pre} 이미 접속중입니다.");
                        return false;
                    }
                    $player->transfer("atn.pe.kr", 19131);
                }
                if ($data[0] == 2) {
                    if ($this->getServer()->getPort() == 19130) {
                        $player->sendMessage("{$this->pre} 이미 접속중입니다.");
                        return false;
                    }
                    $player->transfer("mg.pe.kr", 19130);
                }
            });
            $form->setTitle("Tele Menu");
            $form->addButton("§l스퀘어\n§r§8스퀘어로 이동합니다.");
            $form->addButton("§l제네시스\n§r§8제네시스 채널로 이동합니다.");
            $form->addButton("§l브레아\n§r§8브레아 채널로 이동합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function AdminUI($player) {
        if ($player instanceof Player) {
            $form = $this->ui->SimpleForm(function (Player $player, array $data) {
                if (!is_numeric($data[0])) return;
                if ($data[0] == 0) {
                    $this->User->User($player);
                }
                if ($data[0] == 1) {
                    $this->ProfileUI($player);
                }
                if ($data[0] == 2) {
                    $this->checkquest->checkquest($player);
                }
                if ($data[0] == 3) {
                    $this->area->AreaUI($player);
                }
                if ($data[0] == 4) {
                    $this->CommunityUI($player);
                }
                if ($data[0] == 5) {
                    $this->ConvenienceUI($player);
                }
                if ($data[0] == 6) {
                    $this->CreditUI($player);
                }
                if ($data[0] == 7) {
                    $this->SettingUI($player);
                }
                if ($data[0] == 8) {
                    $this->playerinfo->PlayerInfoUI($player);
                }
                if ($data[0] == 9) {
                    $this->TransferUI($player);
                }
            });
            $form->setTitle("Tele Admin");
            $form->addButton("§l유저 관리\n§r§8유저를 관리합니다.");
            $form->addButton("§l프로필\n§r§8자신의 정보를 관리합니다.");
            $form->addButton("§l퀘스트\n§r§8퀘스트 정보를 확인합니다.");
            $form->addButton("§l사유지\n§r§8사유지 기능을 실행합니다.");
            $form->addButton("§l커뮤니티\n§r§8커뮤니티 관련 기능을 실행합니다.");
            $form->addButton("§l편의 기능\n§r§8편의 기능을 실행합니다.");
            $form->addButton("§l크레딧\n§r§8크레딧 기능을 이용합니다.");
            $form->addButton("§l사용자 설정\n§r§8사용자 설정을 관리합니다.");
            $form->addButton("§l사용자 정보\n§r§8사용자 정보를 확인합니다.");
            $form->addButton("§l디멘션 이동\n§r§8서버 이동 기능을 실행합니다.");
            $form->addButton("§l닫기");
            $form->sendToPlayer($player);
        }
    }

    public function getData1($type) {
        if ($this->sdata[$type] == "허용") return false;
        if ($this->sdata[$type] == "금지") return true;
    }

    public function getData(string $type) {
        if ($this->sdata[$type] == "허용") return true;
        if ($this->sdata[$type] == "금지") return false;
    }

    public function getSpeed() {
        return $this->sdata["유저속도"];
    }

    public function NBT($id, $dmg, $amount, $name) {
        $i = Item::get($id, $dmg, $amount);
        $i->setCustomName("§r{$name}");
        return $i;
    }
}
