<?php
namespace HotbarSystemManager;

use pocketmine\entity\Attribute;
use pocketmine\entity\AttributeMap;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\inventory\PlayerInventory;
use pocketmine\inventory\transaction\action\CreativeInventoryAction;
use pocketmine\inventory\transaction\action\DropItemAction;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class EventListener implements Listener {

    public function __construct(HotbarSystemManager $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $ev) {
        $server = Server::getInstance();
        $player = $ev->getPlayer();
        $name = strtolower($player->getName());
        if (!isset($this->plugin->slot[$player->getName()]))
            $this->plugin->slot[$player->getName()] = 0;
        if (!file_exists("{$server->getDataPath()}players/{$name}.dat")) {
            $item_1 = $this->plugin->NBT(383, 38, 1, "§r§c빈칸");
            $player->getInventory()->setItem(1, $item_1, true);
            $player->getInventory()->setItem(2, $item_1, true);
            $player->getInventory()->setItem(3, $item_1, true);
            $player->getInventory()->setItem(4, $item_1, true);
        }
        $item = $this->plugin->NBT(370, 0, 1, "§r§f메뉴");
        $item->setLore(["§r§5메뉴를 실행합니다."]);
        $player->getInventory()->setItem(0, $item, true);
        $add = 1;
        if ($this->plugin->skill->isSkill($player->getName(), "아처의 정신") && $this->plugin->skill->getSkillLevel($player->getName(), "아처의 정신") > 0)
            $add *= $this->plugin->skill->getSkillInfo("아처의 정신", $this->plugin->skill->getSkillLevel($player->getName(), "아처의 정신"));
        $player->getAttributeMap()->getAttribute(Attribute::MOVEMENT_SPEED)->setValue($this->plugin->sdata["유저속도"] * $add);
    }

    public function onChange(InventoryTransactionEvent $ev) {
        foreach ($ev->getTransaction()->getActions() as $action) {
            if ($ev->getTransaction()->getSource() instanceof Player) {
                if ($action instanceof DropItemAction)
                    return;
                elseif ($action instanceof CreativeInventoryAction) {
                    if ($action->getSourceItem()->getId() == 383 && $action->getSourceItem()->getDamage() == 38)
                        $ev->setCancelled(true);
                } else {
                    /*$itemCode_1 = $action->getSourceItem()->getId();
                    $itemCode_2 = $action->getTargetItem()->getId();
                    if($itemCode_1 == 351 || $itemCode_1 == 370 || ($itemCode_1 == 383 && $action->getSourceItem()->getDamage() == 38))
                      $ev->setCancelled(true);*/
                    //if($itemCode_1 == 351 || $itemCode_1 == 370 || ($itemCode_1 == 383 && $action->getSourceItem()->getDamage() == 38))
                    if ($action->getInventory() instanceof PlayerInventory) {
                        if ($action->getSlot() == 0 and $action->getSourceItem()->getId() == 370) $ev->setCancelled(true);
                        if ($action->getSlot() == 1) $ev->setCancelled(true);
                        if ($action->getSlot() == 2) $ev->setCancelled(true);
                        if ($action->getSlot() == 3) $ev->setCancelled(true);
                        if ($action->getSlot() == 4) $ev->setCancelled(true);
                        if (4 < $action->getSlot()) {
                            if ($action->getSourceItem()->getId() == 383 && $action->getSourceItem()->getDamage() == 38) {
                                $ev->setCancelled(true);
                                $action->getInventory()->setItem($action->getSlot(), new Item(0, 0));
                            }
                        }
                    }
                }
            }
        }
    }

    public function onHeld(PlayerItemHeldEvent $ev) {
        $player = $ev->getPlayer();
        $this->plugin->slot[$player->getName()]++;
        if ($ev->getItem()->getId() == 370 and $ev->getSlot() == 0) {
            //$this->DelayUI($ev->getPlayer(), $ev, $ev->getItem(), $ev->getSlot(), $this->plugin->slot[$player->getName()]);
            $ev->setCancelled(true);
            if (!$ev->getPlayer()->isOp()) $this->plugin->MenuUI($ev->getPlayer());
            if ($ev->getPlayer()->isOp()) $this->plugin->AdminUI($ev->getPlayer());
        }
        if ($ev->getSlot() == 1) {
            //$this->DelayUI($ev->getPlayer(), $ev, $ev->getItem(), $ev->getSlot(), $this->plugin->slot[$player->getName()]);
            $ev->setCancelled(true);
            if ($ev->getItem()->getId() == 383 and $ev->getItem()->getDamage() == 38) return;
            else
                $this->plugin->skill->Skill($ev->getPlayer(), $ev->getItem()->getCustomName());
        }
        if ($ev->getSlot() == 2) {
            //$this->DelayUI($ev->getPlayer(), $ev, $ev->getItem(), $ev->getSlot(), $this->plugin->slot[$player->getName()]);
            $ev->setCancelled(true);
            if ($ev->getItem()->getId() == 383 and $ev->getItem()->getDamage() == 38) return;
            else
                $this->plugin->skill->Skill($ev->getPlayer(), $ev->getItem()->getCustomName());
        }
        if ($ev->getSlot() == 3) {
            //$this->DelayUI($ev->getPlayer(), $ev, $ev->getItem(), $ev->getSlot(), $this->plugin->slot[$player->getName()]);
            $ev->setCancelled(true);
            if ($ev->getItem()->getId() == 383 and $ev->getItem()->getDamage() == 38) return;
            else
                $this->plugin->skill->Skill($ev->getPlayer(), $ev->getItem()->getCustomName());
        }
        if ($ev->getSlot() == 4) {
            //$this->DelayUI($ev->getPlayer(), $ev, $ev->getItem(), $ev->getSlot(), $this->plugin->slot[$player->getName()]);
            $ev->setCancelled(true);
            if ($ev->getItem()->getId() == 383 and $ev->getItem()->getDamage() == 38) return;
            else
                $this->plugin->skill->Skill($ev->getPlayer(), $ev->getItem()->getCustomName());
        }
    }

    public function onRespawn(PlayerRespawnEvent $ev) {
        $this->plugin->getScheduler()->scheduleDelayedTask(
                new class ($this->plugin, $ev->getPlayer()) extends Task {
                    public function __construct(HotbarSystemManager $plugin, Player $player) {
                        $this->plugin = $plugin;
                        $this->player = $player;
                    }

                    public function onRun($currentTick) {
                        $add = 1;
                        if ($this->plugin->skill->isSkill($this->player->getName(), "아처의 정신") && $this->plugin->skill->getSkillLevel($this->player->getName(), "아처의 정신") > 0)
                            $add *= $this->plugin->skill->getSkillInfo("아처의 정신", $this->plugin->skill->getSkillLevel($this->player->getName(), "아처의 정신"));
                        $this->player->getAttributeMap()->getAttribute(5)->setValue($this->plugin->sdata["유저속도"] * $add);
                    }
                }, 2);
    }

    public function onMove(PlayerMoveEvent $ev) {
        if ($ev->getPlayer()->isOp()) return;
        if ($this->plugin->sdata["유저이동"] == "금지") {
            $ev->setCancelled(true);
            $ev->getPlayer()->sendMessage("{$this->plugin->pre} 운영 시스템에 의해 움직일 수 없습니다.");
        }
    }

    public function onChat(PlayerChatEvent $ev) {
        if ($ev->getPlayer()->isOp()) return;
        if ($this->plugin->sdata["유저채팅"] == "금지") {
            $ev->setCancelled(true);
            $ev->getPlayer()->sendMessage("{$this->plugin->pre} 운영 시스템에 의해 말할 수 없습니다.");
        }
    }

    public function onPickUp(InventoryPickupItemEvent $ev) {
        if ($ev->getInventory()->getHolder()->isOp()) return;
        if ($this->plugin->sdata["유저줍기"] == "금지") {
            $ev->setCancelled(true);
            $ev->getInventory()->getHolder()->sendMessage("{$this->plugin->pre} 운영 시스템에 의해 아이템을 주울 수 없습니다.");
        }
    }

    public function onDrop(PlayerDropItemEvent $ev) {
        if ($ev->getItem()->getId() == 383 and $ev->getItem()->getDamage() == 38) $ev->setCancelled(true);
        if ($ev->getPlayer()->isOp()) return;
        if ($this->plugin->sdata["유저버리기"] == "금지") {
            $ev->setCancelled(true);
            $ev->getPlayer()->sendMessage("{$this->plugin->pre} 운영 시스템에 의해 아이템을 버릴 수 없습니다.");
        }
    }

    private function DelayUI(Player $player, PlayerItemHeldEvent $ev, Item $item, int $slot, int $count) {
        $this->plugin->getScheduler()->scheduleDelayedTask(
                new class ($this->plugin, $player, $ev, $item, $slot, $count) extends Task {
                    public function __construct(HotbarSystemManager $plugin, Player $player, PlayerItemHeldEvent $ev, Item $item, int $slot, int $count) {
                        $this->plugin = $plugin;
                        $this->player = $player;
                        $this->ev = $ev;
                        $this->item = $item;
                        $this->slot = $slot;
                        $this->count = $count;
                    }

                    public function onRun($currentTick) {
                        if ($this->count !== $this->plugin->slot[$this->player->getName()])
                            return;
                        if ($this->slot == 0) {
                            if ($this->player->isOp()) $this->plugin->AdminUI($this->player);
                            if (!$this->player->isOp()) $this->plugin->MenuUI($this->player);
                            $this->ev->setCancelled(true);
                        } elseif (1 <= $this->slot && $this->slot <= 4) {
                            $this->plugin->skill->Skill($this->player, $this->item->getCustomName());
                            $this->ev->setCancelled(true);
                        }
                    }
                }, 2);
    }
}
