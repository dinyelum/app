<?php
class Games {
    use db, validate;
    protected static $table = 'games';
    protected $columns = ['id', 'date', 'league', 'fixture', 'tip', 'free', 'recent', 'result', 'games'];
    public $games = [
        'ap'=>'Alpha Picks',
        'ape'=>'Alpha Extra',
        'single'=>'Single',
        '2odds'=>'2 Odds',
        '3odds'=>'3 Odds',
        '3odds2'=>'3 Odds 2',
        '5odds'=>'5 Odds',
        '5odds2'=>'5 Odds 2',
        '5odds3'=>'5 Odds 3',
        '10odds'=>'10 Odds',
        '10odds2'=>'10 Odds 2',
        '10odds3'=>'10 Odds 3',
        'dblchance'=>'Double Chance',
        'bts'=>'BTS',
        'straight'=>'Straight Win',
        'ovun'=>'Over / Under',
        'draw'=>'Draw',
        'cscore'=>'Correct Score',
        'p2s'=>'Player to Score',
        'bigodds'=>'Big Odds',
        'weekend'=>'Mega Weekend',
        'popular'=>'Popular / Upcoming',
        'others'=>'Others',
    ];

    public $gamesmain = [
        'ap'=>'Alpha Picks',
        'ape'=>'Alpha Extra',
        'single'=>'Single',
        '2odds'=>'2 Odds',
        '3odds'=>'3 Odds',
        '5odds'=>'5 Odds',
        '10odds'=>'10 Odds',
        'dblchance'=>'Double Chance',
        'bts'=>'BTS',
        'straight'=>'Straight Win',
        'ovun'=>'Over / Under',
        'draw'=>'Draw',
        'cscore'=>'Correct Score',
        'p2s'=>'Player to Score',
        'bigodds'=>'Big Odds',
        'weekend'=>'Mega Weekend',
        'popular'=>'Popular / Upcoming',
        'recent'=>'Recent Wins',
        'free'=>'Free Games'
    ];

    public $gamesfocus = ['ap', 'ape', 'single', '2odds', '3odds', '5odds', '10odds'];

    public function validate(array $fields) {
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['date'])) {
            $data['date'] = $this->validate_date($fields['date']);
        }

        if(isset($fields['league'])) {
            if(isset($this->leagues)) {
                $data['league'] = $this->validate_in_array($fields['league'], $this->leagues, fieldname:'league');
            } else {
                $fields['league'] = str_replace([' - ', ' > '], ': ', ucwords($fields['league']));
                $data['league'] = $this->validate_text($fields['league'], fieldname:'league');
            }
        }

        if(isset($fields['fixture'])) {
            $fields['fixture'] = str_ireplace([' - ', ' vs ', '		', ' v '], ' vs ', ucwords($fields['fixture']));
            $data['fixture'] = $this->validate_text($fields['fixture'], fieldname:'fixture');
        }

        if(isset($fields['tip'])) {
            if(isset($fields['games']) && $fields['games']=='cscore') {
                $data['tip'] = str_ends_with($fields['tip'], 'Correct Score') ? $fields['tip'] : $fields['tip'].' Correct Score';
            }
            $data['tip'] = $this->validate_text($fields['tip'], fieldname:'tip');
        }

        if(isset($fields['free'])) {
            $data['free'] = $this->validate_toggle($fields['free'], false, 'free');
        }

        if(isset($fields['recent'])) {
            if(in_array($fields['recent'], ['none', 'prev', 'cur'])) {
                $data['recent'] = $fields['recent'];
            } else {
                $data['recent'] = $this->validate_toggle($fields['recent'], false, 'recent');
            }
        }

        if(isset($fields['result'])) {
            $data['result'] = $this->validate_text($fields['result'], required:false, fieldname:'result');
        }

        if(isset($fields['games'])) {
            $data['games'] = $this->validate_in_array($fields['games'], $this->games, fieldname:'games');
        }

        return [$data, $this->err];
    }
}