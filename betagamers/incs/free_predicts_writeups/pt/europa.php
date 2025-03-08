<h2><?=$data['h2a']?></h2><?php
display_games($data['tabs'], $this->page, mode:'free');
$this->display_iframes()?>

<h2><?=$data['h2b']?></h2>
<?=$this->list_league_teams()?>