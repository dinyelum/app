<?php include ROOT."/app/betagamers/incs/header.php";
if(count($data['singlebookie'])) {?>
    <meta http-equiv="refresh" content="7; url='<?=$data['singlebookie'][0]['reflink']?>'">
    <div class='w3-display-container' style="height:300px; background-color:#f1f1f1;">
        <div class='w3-display-middle w3-xlarge w3-center'>
            <p><?=$data['redirect']?>: </p>
            <p id="count"><?=$data['precount']?></p>
            <p><?=$data['alt']?></p>
        </div>
    </div>

    <script>
    var counter = 7;
    setInterval(function() {
        counter--;
        if (counter.toString().length == 1) {
            counter = "0" + counter;
            console.log(counter);
        }
        if(counter < 0) {
            // window.location = '$link';
        } else {
            document.getElementById("count").innerHTML = counter;
        }
    }, 1000);
    </script><?php
    
} else {?>

    <h1 style="color: green;"><?=$data['page_title']?></h1>
    <table class="w3-table">
        <tr>
            <th><?=implode('</th><th>', $data['tableheader'])?></th>
        </tr><?php
        foreach($data['bookiedata'] as $key=>$val) {?>
            <td><?=$key?></td>
            <td><a href="<?=$val['reflink']?>" rel="noopener nofollow" target="_blank"><?=str_replace('...', $key, $data['prompt'])?></a></td>
            <td><?=$val['promocode']?></td><?php
        }?>
    </table><?php
}?>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script src="<?=HOME.'/assets/js/gen.js'?>"></script>