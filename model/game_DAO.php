<?php

require_once('game_DTO.php');

class game_DAO{
    private $bdd;

    public function __construct(){
        try{
            $this->bdd = new PDO('mysql:dbname=roulette;host=127.0.0.1;charset=utf8','Paul','JeSuisTriste');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            die('Erreur'.$e->getMessage());
        }
    }

    public function getGame($player_id){
        $i=0;
        $query = 'SELECT * FROM `game` WHERE player = ?';
        $q = $this->bdd->prepare($query);
        $q->execute($player_id);
        while($data = $q->fetch()){
            $game[$i]=$data;
            $i++;
        }
        return $game;
    }

    public function newGame($player_id, $date, $bet, $profit){
        $query = 'INSERT INTO `game` (`player`,`date`,`bet`,`profit`) VALUES (:t_player, :t_date, :t_bet, :t_profit)';
        $q = $this->bdd->prepare($query);
        $q->bindParam("t_player", $player_id);
        $q->bindParam("t_date",$date);
        $q->bindParam("t_bet",$bet);
        $q->bindParam("t_profit",$profit);
        $q->execute();
    }
}
?>