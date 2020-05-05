<?php

//Namespace
namespace bumcbe\core;

//Imports (uses)
//PluginBase (Haupt Teil des Plugins(selbsterklärend))
use pocketmine\plugin\PluginBase;
//Listener ("Hört" auf andere Events)
use pocketmine\event\Listener;
//SpielerJoinEvent (triggered durch joinen des Servers)
use pocketmine\event\player\PlayerJoinEvent;
//SpielerQuitEvent (triggered durch quiten des Servers)
use pocketmine\event\player\PlayerQuitEvent;
//PlayerInteractEvent (triggered durch benutzen/Klicken von Sachen)
use pocketmine\event\player\PlayerInteractEvent;
//Configs
use pocketmine\utile\Config;
//TextFormat für Farben
use pocketmine\utile\TextFormat;
//Items für StarterKit etc
use pocketmine\item\Item;

//Class (Klasse) starten (PluginBase)
class main extends PluginBase implements Listener
{
  //Öffentliche funktion, die durch den Server / Plugin start getriggerd wird
  public function onEnable() 
  {
    //Listener + Events registrieren!
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    //Konsolen Log
    $this->getLogger()->info("Plugin wurde geladen!");
  }
  //Öffentliche Funktion die durch den Join getriggerd wird
  public function onJoin(PlayerJoinEvent $event)
  {
    //User definieren
    $user = $event->getPlayer();
    //Username definieren
    $username = $user->getName();
    //Alle Online Spieler definieren mit einem foreach
    foreach($this->getOnlinePlayers() as $p);
    //Von allen die Online sind die Namen getten 
    $onlinenames = $p->getName();
    //Join Nachricht ändern
    $event->setJoinMessage(TextFormat::BLACK . "BlackUnity >> " . TextFormat::GREEN . $username . TextFormat::AQUA . " ist gejoint!");
    //IF überprüfung, ob jemand das erste mal gejoint ist
    if (!$user->hasPlayedBefore())
    {
      //Was passieren soll, wenn jmd das erste mal joint
      //Andere Join Nachricht setzen 
      $event->setJoinMessage(TextFormat::BLACK . "BlackUnity >> " . TextFormat::GOLD . $username . TextFormat::AQUA . "ist das erste mal gejoint!");
      $user->getInventory()->set(1, Item::get());
    }
  }
}
