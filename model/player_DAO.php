<?php

require_once('player_DTO.php');

class player_DAO{
    private $bdd;

    public function __construct(){
        try{
            $this->bdd = new PDO('mysql:dbname=roulette;host=127.0.0.1;charset=utf8','Paul','JeSuisTriste');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            die('Erreur'.$e->getMessage());
        }
    }

    public function getPlayer($player_name){
        $query = 'SELECT * FROM player WHERE name = ?';
        $q = $this->bdd->prepare($query);
        $q->execute($player_name);
        $data=$q->fetch();
        $player = new player_DTO($data['id'],$data['name'],$data['password'],$data['money']);
        return $player;
    }

    public function addPlayer($name,$password,$money){
        $query = 'INSERT INTO `player` (`name`, `password`, `money`) values (:t_name, :t_password, :t_money)';
        $q = $this->bdd->prepare($query);
        $q->bindParam("t_name",$name);
        $q->bindParam("t_password",$password);
        $q->bindParam("t_money",$money);
        $q->execute();
    }

    public function lookForPlayer($name,$password){
        $query = 'SELECT * FROM `player` WHERE name = ?';
        $q = $this->bdd->prepare($query);
        $q->execute(array($name));
        while($data = $q->fetch()){
            if($password == $data['password']){
                return $data;
            }
        }
    }

    public function updatePlayer($player_id, $money){
        $query = 'UPDATE `player` SET money = ? WHERE id = ?';
        $q = $this->bdd->prepare($query);
        $q->execute(array($money,$player_id));
    }
}
?>