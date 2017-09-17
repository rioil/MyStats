<?php

namespace MyStats\Task;

use MyStats\MyStats;
use pocketmine\Player;
use pocketmine\scheduler\Task;

/**
 * Class SendStatsTask
 * @package MyStats\Task
 */
class SendStatsTask extends Task  {

    /** @var  MyStats */
    public $plugin;

    /**
     * SendStatsTask constructor.
     * @param MyStats $plugin
     */
    public function __construct(MyStats $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param string $message
     * @param Player $player
     * @return string
     */
    public function translateMessage(string $message, Player $player):string {
        $data = $this->plugin->dataManager->getPlayerData($player);
        $message = str_replace("%name", $player->getName(), $message);
        $message = str_replace("%x", $player->getY(), $message);
        $message = str_replace("%y", $player->getY(), $message);
        $message = str_replace("%z", $player->getZ(), $message);
        $message = str_replace("%level", $player->getLevel()->getName(), $message);
        $message = str_replace("%broken", $data->getBrokenBlocks(), $message);
        $message = str_replace("%placed", $data->getPlacedBlocks(), $message);
        $message = str_replace("%kills", $data->getKills(), $message);
        $message = str_replace("%deaths", $data->getDeaths(), $message);
        $message = str_replace("%joins", $data->getJoins(), $message);
        $message = str_replace("%money", $data->getMoney(), $message);
        $message = str_replace("%online", $this->plugin->getServer()->getQueryInformation()->getPlayerCount(), $message);
        $message = str_replace("%max", $this->plugin->getServer()->getQueryInformation()->getMaxPlayerCount(), $message);
        $message = str_replace("%ip", $this->plugin->getServer()->getIp(), $message);
        $message = str_replace("%port", $this->plugin->getServer()->getPort(), $message);
        $message = str_replace("%version", $this->plugin->getServer()->getVersion(), $message);
        $message = str_replace("%line", "\n".str_repeat(" ", 60), $message);
        $message = str_replace("&", "§", $message);
        $message = str_replace("%tps", $this->plugin->getServer()->getTicksPerSecond(), $message);
        return $message;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick) {
        $format = $this->plugin->dataManager->mainFormat;
        if(count($this->plugin->getServer()->getOnlinePlayers()) > 0) {
            if(is_array($this->plugin->dataManager->tipWorlds)) {
                foreach ((array)$this->plugin->dataManager->tipWorlds as $world) {
                    if($this->plugin->getServer()->isLevelGenerated($world) && $this->plugin->getServer()->isLevelLoaded($world)) {
                        foreach ($this->plugin->getServer()->getLevelByName($world)->getPlayers() as $worldPlayer) {
                            $messageFormat = $this->translateMessage($format, $worldPlayer);
                            $worldPlayer->sendTip(str_repeat(" ",60).$messageFormat);
                        }
                    }
                }
            }
            if(is_array($this->plugin->dataManager->popupWorlds)) {
                foreach ((array)$this->plugin->dataManager->popupWorlds as $world) {
                    if($this->plugin->getServer()->isLevelGenerated($world) && $this->plugin->getServer()->isLevelLoaded($world)) {
                        foreach ($this->plugin->getServer()->getLevelByName($world)->getPlayers() as $worldPlayer) {
                            $messageFormat = $this->translateMessage($format, $worldPlayer);
                            $worldPlayer->sendPopup(str_repeat("  ", 30).$messageFormat);
                        }
                    }
                }
            }
        }
    }
}
