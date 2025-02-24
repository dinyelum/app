<?php
class Odds {
    use db, validate;
    protected static $table = 'odds';
    protected $columns = ['id', 'date', 'games']; //restructure odds table, add games column.

    /*
    alter table odds 
    Add column games varchar(20) not null after date,
    Add column totalodds decimal(9,2) not null after games,
    drop ap,
    drop bigodds,
    drop weekend;
    */

    
    public function validate(array $fields) {
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['date'])) {
            $data['date'] = $this->validate_date($fields['date']);
        }

        if(isset($fields['games'])) {
            $gamesclass = new Games;
            $data['games'] = $this->validate_in_array($fields['games'], $gamesclass->games, fieldname:'games');
        }

        if(isset($fields['totalodds'])) {
            $data['totalodds'] = $this->validate_number($fields['totalodds'], fieldname:'totalodds');
        }

        return [$data, $this->err];
    }
}