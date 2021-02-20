<?php
class game_DTO{
    private $player_id;
    private $date;
    private $bet;
    private $profit;

    public function __construct($c_id, $c_date, $c_bet, $c_profit){
        $this->player_id = $c_id;
        $this->date = $c_date;
        $this->bet = $c_bet;
        $this->profit = $c_profit;
    }

    public function __get($attribut){
        switch ($attribut) {
            case 'player_id':
                return $this->player_id;
                break;
    
            case 'date':
                return $this->date;
                break;
    
            case 'bet':
                return $this->bet;
                break;
    
            case 'profit':
                return $this->profit;
                break;
        }
    }
}

?>