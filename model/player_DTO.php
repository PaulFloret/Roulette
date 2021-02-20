<?php
class player_DTO{
    private $id;
    private $name;
    private $password;
    private $money;

    public function __construct($c_id, $c_name, $c_password, $c_money)
    {
        $this->id = $c_id;
        $this->name = $c_name;
        $this->password = $c_password;
        $this->money = $c_money;
    }

    public function __get($attribut){
        switch ($attribut) {
            case 'id':
                return $this->id;
                break;
            case 'name':
                return $this->name;
                break;
            case 'password':
                return $this->password;
                break;
            case 'money':
                return $this->money;
        }
    }

    public function __set($attribut, $valeur){
        switch($attribut){
            case 'name':
                $this->name = $valeur;
            break;
            case 'password':
                $this->password = $valeur;
                break;
            case 'money':
                $this->money = $valeur;
                break;
        }
    }
}

?>