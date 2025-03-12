<?php include ROOT."/app/betagamers/incs/header.php"?>
<table class=w3-section>
    <tr><th><?=implode('</th><th>', array_keys($data['userdata'][0]))?></th></tr><?php
    foreach($data['userdata'] as $ind=>$val) {?>
        <tr>
            <td><?=$val['fullname']?></td>
            <td><?=$val['country']?></td>
        </tr><?php
    }?>
</table>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>