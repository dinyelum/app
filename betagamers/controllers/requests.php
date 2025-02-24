<?php
class Requests {
//upload games
    public $columns;
    public $gamedata;
    public $errdata;
    public $gametypes = ['free', 'vip'];

    function gamerows($init, $add) {
        for($x=$init; $x < $init+$add; $x++) {
            foreach($this->columns as $key=>$val) {
                $inputs[] = "<div class='w3-col $val'><input type='text' name=row[$x][$key] value='".($this->gamedata[$x][$key] ?? '')."'><br><span class='error'>".($this->errdata[$x][$key] ?? '')."</span></div>";
            }
            $rows[] = "<div class='w3-row-padding w3-stretch inputcontainer'>".implode('', $inputs)."</div>";
            $inputs = [];
        }
        return implode('', $rows);
    }

    function addfields() {
        check_admin();
        if(isset($_GET['gametype']) && isset($_GET['add'])) {
            extract($_GET);
            if(in_array($gametype, $this->gametypes) && is_numeric($add)) {
                $this->columns = match ($gametype) {
                    'free' => ['fixture'=>'m7', 'tip'=>'m5'],
                    default => ['league'=>'m4', 'fixture'=>'m5', 'tip'=>'m3'],
                };
                $init = $_SESSION['addfields'][$gametype] ?? 0;
                $_SESSION['addfields'][$gametype] = isset($_SESSION['addfields'][$gametype]) ? $_SESSION['addfields'][$gametype] + $add : $add;

                echo $this->gamerows($init, $add);
            }
        }
    }

    function addupdatefields() {
        //date, games, type
        //if(isset($_GET['date']) && isset($_GET[$gleaguetxt]))
        //show($_GET);
        extract($_GET);
        date_default_timezone_set('Africa/Lagos');
        $today = date('Y-m-d');
        $_GET['date'] = ($_GET['date'] ?? '') ?: $today;
        $table = match ($gametype) {
            'free' => 'freegames',
            default => 'games',
        };
        $this->setcolumns('update', $gametype);
        if($gametype=='vip' && $_GET['games']=='') {
            unset($_GET['games']);
            $allgames = " and games in ('ap', 'ape', 'single', '2odds', '3odds', '3odds2', '5odds', '5odds2', '5odds3', '10odds', '10odds2', '10odds3', 'draw', 'cscore', 'others')";
        } elseif($gametype=='free' && isset($date) && $date=='') {
            unset($_GET['date']);
            $allgames = " and recent='cur'";
        }
        $gamesclass = new $table;
        $validate = $gamesclass->validate($_GET);
        $wharr = array_map(fn($val)=>"$val=:$val", array_keys($validate[0]));
        //show($wharr);

        if(!$gamesclass->err) {
            $gamedata = $gamesclass->select(implode(', ', array_keys($this->columns)))->where(implode(' and ', $wharr).($allgames ?? '').'  order by id', $validate[0]);
            //show($gamedata);
            if(is_array($gamedata) && count($gamedata)) {
                $this->gamedata = $gamedata;
                echo $this->gamerows(0, count($gamedata)).
                "<div class='w3-row-padding w3-stretch inputcontainer'><input type=date class='w3-col m3 w3-padding' name=date value=''></div>";
            } else {
                echo "No games found";
            }
        }
        // show($gamesclass->err);


    }

    function setcolumns($action, $gametype) {
        if($action=='input') {
            $this->columns = match ($gametype) {
                'free' => ['fixture'=>'m7', 'tip'=>'m5'],
                default => ['league'=>'m4', 'fixture'=>'m5', 'tip'=>'m3'],
            };
        } else {
            $this->columns = match ($gametype) {
                'free' => ['id'=>'w3-hide', 'date'=>'m2', 'league'=>'m2', 'fixture'=>'m3', 'tip'=>'m2', 'recent'=>'m1', 'result'=>'m2'],
                default => [
                    'id'=>'w3-hide',
                    'date'=>'m2',
                    'league'=>'m2',
                    'fixture'=>'m2',
                    'tip'=>'m2',
                    ...array_fill_keys(['games', 'free', 'recent', 'result'], 'm1')
                ],
            };
        }
    }
    
    function gamehandler() {
        check_admin();
        $actions = ['input', 'update'];
        extract($_GET);
        if(isset($action) && in_array($action, $actions) && isset($gametype) && in_array($gametype, $this->gametypes)) {
            $table = match ($gametype) {
                'free' => 'freegames',
                default => 'games',
            };
            $gamesclass = new $table;
            if(!isset($_POST['row'])) {
                exit('No games sent');
            }
            foreach($_POST['row'] as $ind=>$val) {
                if(count(array_filter($val)) < 1) {
                    unset($_POST['row'][$ind]);
                    continue;
                }
                if($action=='input') {
                    $formdata = array_merge($val, ['date'=>$_POST['date']], $gametype=='vip' ? ['games'=>$_POST['games']] : ['league'=>$_POST['league']], ($gametype=='free' || $_POST['games'] == 'weekend') ? ['recent'=>'cur'] : []);
                } else {
                    $date = $gamesclass->validate_date($_POST['date'], false);
                    $val['date'] = $date && !isset($gamesclass->err['date']) ? $date : $val['date'];
                }
                $validate = $gamesclass->validate($formdata ?? $val);
                $gamedata[$ind] = $validate[0];
                $errdata[$ind] = $validate[1];
                $genErr = $gamesclass->err['date'] ?? $gamesclass->err['games'] ?? $gamesclass->err['gen'] ?? ($gametype=='free' ? ($gamesclass->err['league'] ?? '') : '');
                $gamesclass->err = null;
                if(!isset($errdata[$ind])) {
                    $idquery = isset($gamedata[$ind]['id']) ? 'AND id != :id' : '';
                    $arr = ['date'=>$gamedata[$ind]['date'], ':games'=>$gamedata[$ind]['league'], ':fixture'=>$gamedata[$ind]['fixture']];
                    $wharr = $idquery ? array_merge($arr, [':id'=>$gamedata[$ind]['id']]) : $arr;
                    $check_fixture = $gamesclass->select('fixture')->where("date = :date AND league = :games AND fixture = :fixture $idquery", $wharr);
                    if(count($check_fixture)) {
                        $errdata[$ind]['fixture'] = 'Already Exists';
                    }
                }
            }
            if(!isset($gamedata)) {
                exit('No games sent');
            }
            $this->gamedata = array_values($gamedata);
            $this->errdata = array_values($errdata);
            //show($errdata);
            if(!count(array_filter($errdata, 'is_array'))) {
                if($action=='input') {
                    if($gametype=='free' || $_POST['games'] == 'weekend') {
                        $columntxt = $gametype=='free' ? "league='".$_POST['league']."'" : "games='".$_POST['games']."'";
                        $db = $gamesclass->custom_query(
                            "select DATEDIFF(NOW(), date) into @vardate from $table where $columntxt AND recent = 'cur' order by date asc limit 1;
                            UPDATE $table SET recent = if(@vardate >= 2, 
                             CASE
                                WHEN recent = 'prev' THEN 'none'
                                WHEN recent = 'cur' THEN 'prev'
                                ELSE recent
                                END,
                            recent) WHERE ".($gametype=='free' ? "league='".$_POST['league']."'" : "games='weekend'")." and recent  in ('prev','cur')",
                            'update'
                        );
                    }
                    // show($this->gamedata);
                    $db = $gamesclass->insert_multi($this->gamedata);
                    $display = date('l, d', strtotime($this->gamedata[0]['date']));
                } else {
                    foreach($this->gamedata as $ind=>$val) {
                        $transarr[$ind.'update'] = [array_diff_key($val, ['id'=>'dropkey'])];
                        $transarr[$ind.'where'] = ["id=:id$ind", [":id$ind"=>$this->gamedata[$ind]['id']]];
                    }
                    $tabqueries = [
                        $table=>[
                            ...$transarr
                        ]
                    ];
                    //show($tabqueries);
                    $db = $gamesclass->transaction($tabqueries, 'update');
                    // var_dump($db);
                    if(is_array($db)) {
                        echo $maxkey = ((count($db[$table])/2)-1).'where';
                    }
                }
                if($db===true || (isset($db[$table][$maxkey]) && $db[$table][$maxkey]===true)) {
                    echo "<span class=success>".($action=='input' ? ($this->gamedata[0]['games'] ?? $this->gamedata[0]['league']) : '')." success. ".($display ?? '')."</span>";
                    return true;
                }
            } else {
                //show($errdata);
                $countdata = count($this->gamedata);
                if($countdata >= 1) {
                    $_SESSION['addfields'][$gametype] = $countdata;
                }
                $this->setcolumns($action, $gametype);
                echo "<span class='error'>$genErr</span><br>".$this->gamerows(0, $countdata);
                if($action=='update') {
                    echo "<div class='w3-row-padding w3-stretch inputcontainer'><input type=date class='w3-col m3 w3-padding' name=date value='".($date ?? '')."'></div>";
                }
            }
        }
    }

    function updateodds() {
        // show($_POST);
        $oddsclass = new Odds;
        if(!isset($_POST['date']) || !isset($_POST['games']) || !isset($_POST['totalodds'])) {
            exit('Invalid Parameters');
        }
        $validate = $oddsclass->validate($_POST);
        if(!$oddsclass->err) {
            $db = $oddsclass->insert($validate[0]);
            if($db===true) {
                $display = date('l, d', strtotime($validate[0]['date']));
                echo "<span class=success>".$validate[0]['games']." success. $display</span>";
            }
        } else {
            echo "<span class=error>".implode('<br>', $validate[1])."</span>";
        }
    }
//end upload games
}