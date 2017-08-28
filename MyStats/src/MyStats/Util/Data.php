<?php

namespace MyStats\Util;

use pocketmine\Player;

/**
 * Class Data
 * @package MyStats\Util
 */
class Data {

    /** @var  DataManager $dataManager */
    public $dataManager;

    /** @var  Player $player */
    public $player;

    /** @var  array $configData */
    public $configData;

    /** @var array $data */
    public $data = [];

    /**
     * Data constructor.
     * @param Player $player
     * @param DataManager $dataManager
     * @param array $configData
     */
    public function __construct(Player $player, DataManager $dataManager, array $configData) {
        $this->player = $player;
        $this->dataManager = $dataManager;
        $this->configData = $configData;
        var_dump($configData);
    }

    public function getFormat() {

    }

    /**
     * @param int $id
     */
    public function add(int $id){
        switch ($id) {
            case DataManager::BREAKED:
                $this->addBreakedBlock();
                break;
            case DataManager::PLACE:
                $this->addPlacedBlock();
                break;
            case DataManager::KILL:
                $this->addKill();
                break;
            case DataManager::DEATH:
                $this->addDeath();
                break;
            case DataManager::JOIN:
                $this->addJoin();
                break;
        }
    }

    public function addBreakedBlock() {
        isset($this->data["BreakedBlocks"]) ? $this->data["BreakedBlocks"] = $this->data["BreakedBlocks"]+1 : $this->data["BreakedBlocks"] = 1;
    }

    public function addPlacedBlock() {
        isset($this->data["PlacedBlocks"]) ? $this->data["PlacedBlocks"] = $this->data["PlacedBlocks"]+1 : $this->data["PlacedBlocks"] = 1;
    }

    public function addKill() {
        isset($this->data["Kills"]) ? $this->data["Kills"] = $this->data["Kills"]+1 : $this->data["Kills"] = 1;
    }

    public function addDeath() {
        isset($this->data["Deaths"]) ? $this->data["Deaths"] = $this->data["Deaths"]+1 : $this->data["Deaths"] = 1;
    }

    public function addJoin() {
        isset($this->data["Joins"]) ? $this->data["Joins"] = $this->data["Joins"]+1 : $this->data["Joins"] = 2;
    }

    /**
     * @return int
     */
    public function getBreakedBlocks() {
        return isset($this->data["BreakedBlocks"]) ? intval($this->data["BreakedBlocks"]) : intval(0);
    }

    /**
     * @return int
     */
    public function getPlacedBlocks() {
        return isset($this->data["PlacedBlocks"]) ? intval($this->data["PlacedBlocks"]) : intval(0);
    }

    /**
     * @return int
     */
    public function getKills() {
        return isset($this->data["Kills"]) ? intval($this->data["Kills"]) : intval(0);
    }

    /**
     * @return int
     */
    public function getDeaths() {
        return isset($this->data["Deaths"]) ? intval($this->data["Deaths"]) : intval(0);
    }

    /**
     * @return int
     */
    public function getJoins() {
        return isset($this->data["Joins"]) ? intval($this->data["Joins"]) : intval(1);
    }

    /**
     * @return int
     */
    public function getMoney() {
        return intval($this->dataManager->plugin->economyManager->getPlayerMoney($this->player));
    }
}