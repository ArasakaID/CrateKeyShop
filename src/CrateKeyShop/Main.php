<?php

namespace CrateKeyShop;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\Config;
use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
		$this->getLogger()->info("has been Enable");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args): bool{
		switch($cmd->getName()){
			case "keyshop":
			if(!$sender instanceof Player){
			$sender->sendMessage("You can only use this command In-Game");
			return false;
			}
			if($sender instanceof Player){
			$this->shopFrom($sender);
			}
			break;		
		}
		return true;
	}
	
	public function shopFrom(Player $player){
		$form = new SimpleForm(function (Player $player, $data){
		$result = $data;
		if($result === null){
			return true;
			}
			switch($result){
				case 0:
					if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($player) >= $this->getConfig()->get("common.price")){
						$this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), "key Common ".$player->getName()." ".$this->getConfig()->get("common.amount"));
						$player->sendMessage($this->getConfig()->get("common.success.purchase"));
						EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("common.price"));
					} else {
						$player->sendMessage($this->getConfig()->get("not.enough.money"));
					}
				break;
				case 1:
					if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($player) >= $this->getConfig()->get("uncommon.price")){
						$this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), "key UnCommon ".$player->getName()." ".$this->getConfig()->get("uncommon.amount"));
						$player->sendMessage($this->getConfig()->get("uncommon.success.purchase"));
						EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("uncommon.price"));
					} else {
						$player->sendMessage($this->getConfig()->get("not.enough.money"));
					}
				break;
				case 2:
					if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($player) >= $this->getConfig()->get("mythic.price")){
						$this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), "key Mythic ".$player->getName()." ".$this->getConfig()->get("mythic.amount"));
						$player->sendMessage($this->getConfig()->get("mythic.success.purchase"));
						EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("mythic.price"));
					} else {
						$player->sendMessage($this->getConfig()->get("not.enough.money"));
					}
				break;
				case 3:
					if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($player) >= $this->getConfig()->get("legendary.price")){
						$this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), "key Legendary ".$player->getName()." ".$this->getConfig()->get("legendary.amount"));
						$player->sendMessage($this->getConfig()->get("legendary.success.purchase"));
						EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("legendary.price"));
					} else {
						$player->sendMessage($this->getConfig()->get("not.enough.money"));
					}
				break;
			}
		});					
		$form->setTitle("CrateKey Shop");
		$form->addButton("§eCommon\n§aPrice: §e".$this->getConfig()->get("common.price"));
		$form->addButton("§eUnCommon\n§aPrice: §e".$this->getConfig()->get("uncommon.price"));
		$form->addButton("§eMythic\n§aPrice: §e".$this->getConfig()->get("mythic.price"));
		$form->addButton("§eLegendary\n§aPrice: §e".$this->getConfig()->get("legendary.price"));
		$form->sendToPlayer($player);
	}
}
