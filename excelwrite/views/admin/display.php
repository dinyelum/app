<?php include "../app/excelwrite/incs/header.php";
if($_GET['section'] == 'orders' || $_GET['section']=='writer') {
    $message = "You cannot add ".$_GET['section']." manually. ".($_GET['section']=='orders' ? 'You have to use the Submit Assignment button.': 'Tell the writer to use the Sign Up page and register as a writer.');
    echo "<button onclick=\"loadModal('message')\">Add ".$_GET['section']."</button>";
    include "../app/modals/message.php";
} else {?>
    <button><a href="process?action=add&section=<?=$_GET['section']?>">Add <?=$_GET['section']?></a></button><?php
}

if(!count($data['displaydata'])) {
    exit('No data found');
} else {
    $theaders = array_keys($data['displaydata'][0]);
}?>
<table>
    <tr><?php
    foreach ($theaders as $val) {
        if($val=='id' || $val=='icon' || $val=='note') {
            continue;
        }
        echo '<th>'.ucwords($val).'</th>';
    }?>
            <th>Actions</th>
        </tr><?php
    foreach ($data['displaydata'] as $value) {
        $counter = 0;
        echo "<tr id=row".$value['id'].">";
        foreach ($value as $key=>$val) {
            // if($counter == (count($value)-1)) {
            //     echo "<td class=none><input id=name".$value['id']." type=hidden value='".($value['name'] ?? $value['food'])."'>
            //     <input id=cat".$value['id']." type=hidden value='".($value['category'] ?? '')."'></td>";
            // }
            // $counter++;
            if($key=='id' || $key=='icon' || $key=='note') {
                continue;
            }
            if($key=='image' || ($key=='paymentproof' && $val != '')) {
                echo "<td class=center><img src='../images/$val' style=width:50px; height:50px></td>";
            } elseif($key=='link') {
                echo "<td><a href='$val' target='_blank'>$val</a></td>";
            } else {
                echo "<td>$val</td>";
            }
        }
        echo "
        <td class=center>
            <a href='process?action=update&id=".$value['id'].'&section='.$_GET['section']."'><button class='tablebtn safe rounded'>Edit</button></a>
        </tr>";
    }?>
</table>
<script src='<?=HOME?>/assets/js/gen.js'></script>
<?php include "../app/excelwrite/incs/footer.php"?>