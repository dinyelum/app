<?php
class Marks {
    use db, validate;
    protected static $table = 'marks';
    protected $columns = ['id', 'date', 'games', 'sports', 'mark', 'percent', 'best'];
    public $games = ['ap'=>'Alpha Picks', 'single'=>'Single', '2odds'=>'2 Odds', '3odds'=>'3 Odds', '5odds'=>'5 Odds', '10odds'=>'10 Odds',];
    public $allmarks = [
        'check,46px,green',
        'check,46px,yellow',
        'minus,46px,yellow',
        'question,46px,yellow',
        'times,46px,red',
    ];

    public function set_games() {
        return $games = [
            'ap'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'ALPHA PICKS',
            },
            'single'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'SUPER SINGLE',
            },
            '2odds'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'SURE 2 ODDS',
            },
            '3odds'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'3 ODDS BANKER',
            },
            '5odds'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'5 ODDS',
            },
            '10odds'=>match(LANG) {
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>'10 ODDS'
            },
        ];
    }
    /*
    alter table marks
    drop alpha,
    drop single,
    drop odds2,
    drop odds3,
    drop odds5,
    drop odds10,
    drop top,
    drop palpha,
    drop psingle,
    drop p2odds,
    drop p3odds,
    drop p5odds,
    drop p10odds,
    add column games varchar(20) not null after date,
    add column sports varchar(10) not null after games,
    add column mark varchar(30) not null after sports,
    add column percent decimal(4,2) not null after mark,
    add column best varchar(10) not null comment "0-don't show; yyyy/mm-show" after percent;
    TRUNCATE marks;

    select date, games, mark from marks where date like concat('%', (select best from marks where best != '' order by id desc limit 1), '%') and games=(select games from marks where best != '' order by id desc limit 1);
    */

    public function fa_fa_mark($sign, $size, $color, $date='') {
        return "<i class='fa fa-$sign-circle' style='font-size:$size;  color: $color;'></i><br><span>$date</span>";
    }

    public function get_percent(string|array $odds) {
        if(is_array($odd)) {
            $odds = array_filter($odds, fn($val)=>in_array($val, $this->games));
            $str_odds = implode(', ', $odds);
        } else {
            $str_odds = in_array($odds, $this->games) ? $odds : null;
        }
        return $this->select('games, percent')->where("games in ($str_odds)");
    }

    public function get_records($from, $to, array $odds) {
        // if(is_array($odd)) {
        //     $odds = array_filter($odds, fn($val)=>in_array($val, $this->games));
        //     $str_odds = implode(', ', $odds);
        // } else {
        //     $str_odds = in_array($odds, $this->games) ? $odds : null;
        // }
        //$odds array only foor easy formatting 
        $str_odds = implode(', ', array_map(fn($val)=>"'".$val."'", $odds));
        $findinset = implode(',', $odds);
        return $this->select('date, games, mark, percent')->where("date between :start and :stop and games in ($str_odds) order by FIND_IN_SET(games, '$findinset'), date", [':start'=>$from, ':stop'=>$to]);
    }

    function update_percent() {
        return [
            'custom_query'=>[
                "UPDATE marks m  JOIN (
                    WITH temp_table AS (
                        SELECT * FROM (
                            SELECT games, mark, percent, ROW_NUMBER() OVER(PARTITION BY games ORDER BY id desc ) AS 
                            RN FROM marks 
                            WHERE mark not in ('minus,46px,yellow', 'question,46px,yellow') and games in 
                            ('ap', 'single', '2odds', '3odds', '5odds', '10odds')) sub
                        WHERE RN <= 20),
                    temp_tab as (
                        SELECT if(t1.games='ap', ((COUNT(*) + greenmark) / allmark) / 2, COUNT(*) / allmark) * 100 as percent, t1.games FROM temp_table as t1 
                        left join (
                            SELECT COUNT(*) as allmark, t2.games FROM temp_table as t2 GROUP BY t2.games) t2 
                        on t1.games=t2.games 
                        left join (
                            SELECT COUNT(*) as greenmark, t3.games FROM temp_table as t3 
                            where t3.mark='check,46px,green' GROUP BY t3.games) t3 
                        on t1.games=t3.games 
                        WHERE mark in ('check,46px,green', 'check,46px,yellow') GROUP BY t1.games) 
                    select * from temp_tab) cte 
                ON m.games = cte.games
                SET m.percent = cte.percent where m.date=(select max(date) from marks)",
                'update'
            ]
        ];
    }

    public function validate(array $fields) {
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['date'])) {
            $data['date'] = $this->validate_date($fields['date']);
        }
        
        if(isset($fields['games'])) {
            $data['games'] = $this->validate_in_array($fields['games'], $this->games, fieldname:'games');
        }
        
        if(isset($fields['sports'])) {
            $data['sports'] = $this->validate_in_array($fields['sports'], ALLSPORTS, fieldname:'sports');
        }
        
        if(isset($fields['mark'])) {
            $data['mark'] = $this->validate_in_array($fields['mark'], $this->allmarks, fieldname:'mark');
        }
        
        if(isset($fields['percent'])) {
            $data['percent'] = $this->validate_number($fields['percent'], fieldname:'percent');
        }
        
        if(isset($fields['best'])) {
            $data['best'] = $fields['best']==0 ? $fields['best'] : $this->validate_year_month($fields['month'] ?? $fields['best'], fieldname:'best');
        }
        return [$data, $this->err];
    }
}