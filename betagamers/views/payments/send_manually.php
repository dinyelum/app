<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class='tips-prof'>
        <div class=w3-center>
            <p><img src="<?=$data['image']['url']?>" alt="<?=$data['image']['alt']?>" class='w3-image' width="<?=$data['image']['width']?>" height="<?=$data['image']['height']?>"></p>
            <?=$data['p']?>
        </div>
    </div>
</div>
<?php include INCS.'/footer.php';?>
<script src="<?=HOME?>/assets/js/gen.js"></script>