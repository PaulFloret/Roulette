<?php
require_once('../model/game_DAO.php');
require_once('../model/player_DAO.php');
session_start();

$messageHeader = 'Veuillez vous connecter'; 
$player_DAO = new player_DAO();
$page = 'connexion';
$btnDeco = null;

//lancer de la roulette
if(isset($_POST['btnJouer'])){
    LancerRoulette();
}
//déconnexion
if(isset($_POST['deco'])){
    session_destroy();
}

//accès à la page d'inscription
if(isset($_POST['btnInscr'])){
    $page = 'inscription';
}

//traitement de l'inscription
if(isset($_POST['btnVaInscr'])){
    if(isset($_POST['username']) && $_POST['username'] != ''
        && isset($_POST['password']) && $_POST['password'] != '') {
            $player_DAO->addPlayer($_POST['username'],$_POST['password'],$_POST['money']);
        }else{
            echo "champs inexistant ou vide";
        }
}

//connexion
    if(isset($_POST['btnValCo'])) {
        if(isset($_POST['username']) && $_POST['username'] != ''
        && isset($_POST['password']) && $_POST['password'] != ''){
            $player =  $player_DAO->lookForPlayer($_POST['username'],$_POST['password']);
            if(isset($player)){
                $_SESSION['id']=$player['id'];
                $_SESSION['username'] = $player['name'];
                $_SESSION['money'] = $player['money'];
                $portefeuille = $player['money'];
            }else {
                echo 'Erreur: utilisateur inconnu ou mot de passe erroné';
            }
        } else { echo 'Erreur: champs inexistant ou vide'; }
    }
    if(isset($_POST['deco']))    {
        unset($_SESSION['username']);
    }
    if(isset($_SESSION['username']))   {
        $page = 'roulette';
    }
    
switch($page){
    case'connexion':
        include('../view/start.php');
        include('../view/header.php');
        include('../view/formulaireConnexion.php');
        include('../view/footer.php');
        break;
    case 'roulette':
        $btnDeco = '<button name="deco">Se déconnecter</button>';
        $messageHeader = 'Bonjour '.$_SESSION['username']. ', bienvenue à la roulette !';
        $messagePF = '<h2>Porte-feuille actuel :'.$_SESSION['money'].'</h2>';
        include('../view/start.php');
        include('../view/header.php');
        include('../view/formulaireRoulette.php');
        break;
    case 'inscription':
        include('../view/start.php');
        include('../view/header.php');
        include('../view/formulaireInscription.php');
}

function LancerRoulette(){
    $Resultat=rand(1,36);
    $gain=-$_POST['bet'];
    $nv_money=$_SESSION['money'];
    $bet=$_POST['bet'];

    if(isset($_POST['bet']) && $_POST['bet']<$_SESSION['money']  
    && isset($_POST['choix'])&& $_POST['choix']!= ''){
        if(0<$_POST['choix'] && $_POST['choix']==$Resultat){
            $gain=$gain+35*$_POST['bet'];
            echo'<br/>Félicitations, vous avez choisi le numéro Gagnant: le'.$Resultat;
        }elseif($_POST['choix']=="paire" && $Resultat%2==0
        || $_POST['choix']=="impaire" && $Resultat%2==1){
            $gain=$gain+2*$_POST['bet'];
            echo'<br/>Félicitations, vous avez choisi la bonne parité: '.$_POST['choix'];
        }elseif($gain<$_POST['bet']){ 
            echo'<br/>Désolé, vous avez choisi '.$_POST['choix'] ;
            echo'<br/>Malheureusement, c\'est le '. $Resultat .' qui est sorti';
        }
        }else{
            echo'Erreur, vous avez lancé la roulette sans choisir de pari';
            header('roulette.php');
            die();
        }

        $nv_money=$nv_money+$gain;
        $game_DAO = new game_DAO();
        $player_DAO = new player_DAO();
        $now=date('Y-m-d H:i:s');

        $game_DAO->newGame($_SESSION['id'],$now, $_POST['bet'],$gain);
        $player_DAO->updatePlayer($_SESSION['id'],$nv_money);
        $_SESSION['money']=$nv_money;
    echo'<br/>Votre gain au lancer précédent est de '.$gain.' €';
    }
?>
