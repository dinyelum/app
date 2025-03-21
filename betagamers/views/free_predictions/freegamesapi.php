<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <h1><?=$data['h1']?></h1><?php
        if($this->writeuponly===true) {?>
            <div class='tips-prof w3-hide-small'><?=$data['writeup']['p1']?></div>
            <div class='tips-prof w3-hide-medium w3-hide-large'><?=$data['writeup']['p2']?></div><?php
        } else {
            echo '<i>'.$data['lastmodified'].'</i><br><br>';
            echo $data['socials'].'<br>';
            include INCS.'/free_predicts_apis/football-prediction/'.LANG.'/'.$this->page.'.php';
        }?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script src="<?=HOME?>/assets/js/gen.js"></script>