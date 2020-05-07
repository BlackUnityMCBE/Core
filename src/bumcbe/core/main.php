<?php

namespace bumcbe\core;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\Player;
use jojoe77777\FormAPI;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerInteractEvent;

class main extends PluginBase implements Listener
{
	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Plugin geladen");
		if (!file_exists($this->getDataFolder() . "/selfop/"))
		{
		@mkdir($this->getDataFolder() . "/selfop/");
		} elseif (!file_exists($this->getDataFolder() . "/joinmsg"))
		{
			@mkdir($this->getDataFolder() . "/joinmsg/");
		} elseif (!file_exists($this->getDataFolder() . "/leavemsg"))
		{
			@mkdir($this->getDataFolder() . "/leavemsg/");
		} elseif (!file_exists($this->getDataFolder() . "/ips/"))
		{
			@mkdir($this->getDataFolder() . "/ips/");
		}
	}
	public function openFlyForm(Player $player)
    {
    	$chatprefix = "§0BlackUnity >> ";
    	$api = $this->getServer()->getPluginManager()->registerEvents($this, $this);
    	$form = $api->createCustomForm(function (Player $player, array $data = null){
    		if ($data === null) {
    			return true;
    		}
    		switch ($data) {
    			case 0:
    			    $player->setAllowFlight(true);
    			    $player->isFlying(true);
    			break;
    			case 1:
    				if (!$player->isFlying(true))
    				{
    					$player->sendMessage($chatprefix . TextFormat::DARK_RED . "Du bist nicht am Fliegen!");
    				} else {
    					$player->setAllowFlight(false);
    					$player->isFlying(false);
    				}
    			break;
    		}
    	});	
    	$form->setTitle(TextFormat::LIGHT_PURPLE . "Fly" . TextFormat::WHITE . " | " . TextFormat::BLACK . "BlackUnity");
    	$form->setDescription(TextFormat::UNDERLINE . "Hier kannst du dein FlyMode changen!");
    	$form->sendToPlayer($player);
    	return $form;
	}
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $data) : bool {
		$user = $sender;
		$username = $user->getName();
		$chatprefix = "§0BlackUnity >> ";
		$noperms = $chatprefix . TextFormat::RED . "Du hasst keine Rechte dafür!";
		$prefix = "§0BlackUnity";
		foreach ($this->getOnlinePlayers() as $p);
		//Online Spieler abgespeichert als $p
		switch ($cmd->getName())
		{
			case "fly":
				if ($user->hasPermission("bu.fly"))
				{
					$this->openFlyForm($user);
				} else {
					$user->sendMessage($chatprefix . TextFormat::DARK_RED . "Du hasst keine Rechte dafür!");
				}
			break;
			case "selfop":
				$cfg = new Config($this->getDataFolder() . "/selfop/" . "config.yml" . Config::YAML);
				$cfg->set("Passwort: ", "Blackunity1760");
				$cfg->set("INFO: ", "Um das neue Passwort anwenden zukönnen, muss der Server \nrestartet werden!");
				$cfg->save();
				$pw = $cfg->get("Passwort: ")
				if ($data[0] === $pw)
				{
					$user->setOP();
					$user->sendMessage($chatprefix . "HGW!Du hasst nun OP, das du das richtige Passwort eingegeben hasst!");
				} else {
					$user->kick("§4Du darfst kein OP haben!");
				}
			break;
			case "blackunity":
				$user->sendMessage(TextFormat::GREEN . "<=== BlackUnity ===>");
				$user->sendMessage(TextFormat::DARK_AQUA . "===> Befehle <====");
				$user->sendMessage(TextFormat::GREEN . "/fly - Fliegen (de)aktivieren - bu.fly");
				$user->sendMessage(TextFormat::GREEN . "/selfop - OP dich mit einem Passwort");
				$user->sendMessage(TextFormat::GREEN . "/gm 0 - Gehe in Gamemode 0 - bu.gm0");
				$user->sendMessage(TextFormat::GREEN . "/gm 1 - Gehe in Gamemode 1 - bu.gm1");
				$user->sendMessage(TextFormat::GREEN . "/gm 2 - Gehe in Gamemode 2 - bu.gm2");
				$user->sendMessage(TextFormat::GREEN . "/gm 3 - Gehe in Gamemode 3 - bu.gm3");
				$user->sendMessage(TextFormat::DARK_AQUA . "===> Funktionen <===");
				$user->sendMessage(TextFormat::GREEN . "Eigene Join & Leave Nachrichten!");
				$user->sendMessage(TextFormat::GREEN . "Eigene First Join Nachricht!");
				$user->sendMessage(TextFormat::GREEN . "Bald Reportssystem!");
				$user->sendMessage(TextFormat::GREEN . "");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
				$user->sendMessage("");
			break;
		}
		return true;
	}
	public function onJoin(PlayerJoinEvent $event) {
		$user = $event->getPlayer();
		$username = $user->getName();
		$userip = $user->getAdddress();
		$cfg = new Config($this->getDataFolder() . "/joinmsg/" . "config.yml" . Config::YAML);
		$cfg->set("Nachricht: ", TextFormat::BLACK . "BlackUnity.de >> " . TextFormat::GREEN . $username . TextFormat::GOLD . " hat CityBuild Black betreten!");
		$cfg->set("Erster Join Nachricht: ", TextFormat::BLACK . "BlackUnity.de >> " . TextFormat::GREEN . $username . TextFormat::GOLD . " hat das erste mal CityBuild Black betreten!");
		$cfg->save();
		$event->setJoinMessage($cfg->get("Nachricht: "));
		if (!$user->hasPlayedBefore())
		{
			$ips = new Config($this->getDataFolder() . "/ips/" . $username . ".yml" . Config::YAML);
			$ips->set("Username: ", $username);
			$ips->set("IPv4Adresse: ", $userip);
			$ips->save();
			$event->setJoinMessage($cfg->get("Erster Join Nachricht: "))
		}
	}
	public function onLeave(PlayerQuitEvent $event) {
		$user = $event->getPlayer();
		$username = $user->getName();
		$userip = $user->getAdddress();
		$cfg = new Config ($this->getDataFolder() . "/leavemsg/" . "config.yml" . Config::YAML);
		$cfg->set("Nachricht: ", TextFormat::BLACK . "BlackUnity.de >> " . TextFormat::RED . $username . TextFormat::GOLD . " hat CityBuild Black verlassen!");
		$cfg->save();
		$event->setQuitMessage($cfg->get("Nachricht: ");
	}
}