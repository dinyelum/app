<?php
class Freegames extends Games {
    protected static $table = 'freegames';
    protected $columns = ['id', 'league', 'fixture', 'tip', 'recent', 'result', 'regdate'];
    public $leagues = [
        'epl'=>'English Premier League',
        'laliga'=>'Spanish La Liga',
        'bundesliga'=>'German Bundesliga',
        'ligue1'=>'French Ligue 1',
        'seriea'=>'Italian Serie A',
        'ucl'=>'UEFA Champions League',
        'europa'=>'UEFA Europa League',
        'afcon'=>'African Cup of Nations',
        'euro'=>'European Championship',
        'unl'=>'UEFA Nations League',
        'worldcup'=>'World Cup',
    ];
}