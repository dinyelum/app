<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
            <h1><?=$data['h1']?></h1><?php
            if($this->page=='update_viprecords') {?>
                <form method="post" action="<?=htmlspecialchars(URI)?>" class=w3-container><?php
                    echo "<span class=success>".$data['formsuccess']."</span>";
                    echo "<span class=error>".$data['formerrors']['gen']."</span>";?>
                    <div class='w3-row w3-stretch'>
                        <div class=w3-half>
                            <input type=date name=date value='<?=$data['formdate']?>'>
                        </div>
                    </div><?php
                    $count = 0;
                    foreach($data['games'] as $key=>$val) {?>
                        <div class='w3-row-padding w3-stretch w3-border'>
                            <div class='w3-col m3'>
                                <p>
                                    <?=$val?>
                                    <input type=hidden name=row[<?=$count?>][games] value='<?=$key?>'>
                                    <span class="error"> <?=$data['formerrors'][$count]['games'] ?? ''?></span>
                                </p>
                            </div>
                            <div class='w3-col m6'>
                                <p>
                                    <input type="radio" id="<?=$key?>_green" name=row[<?=$count?>][mark] value='check,46px,green' <?=(isset($data['formdata'][$count]['mark']) && $data['formdata'][$count]['mark'] =='check,46px,green' ) ? "checked" : ''?> required>
                                    <label for="<?=$key?>_green">Green</label>
            
                                    <input type="radio" id="<?=$key?>_yellow" name=row[<?=$count?>][mark] value='check,46px,yellow' <?=(isset($data['formdata'][$count]['mark']) && $data['formdata'][$count]['mark'] =='check,46px,yellow' ) ? "checked" : ''?> required>
                                    <label for="<?=$key?>_yellow">Yellow</label>
            
                                    <input type="radio" id="<?=$key?>_minus" name=row[<?=$count?>][mark] value='minus,46px,yellow' <?=(isset($data['formdata'][$count]['mark']) && $data['formdata'][$count]['mark'] =='minus,46px,yellow' ) ? "checked" : ''?> required>
                                    <label for="<?=$key?>_minus">Minus</label>
            
                                    <input type="radio" id="<?=$key?>_question" name=row[<?=$count?>][mark] value='question,46px,yellow' <?=(isset($data['formdata'][$count]['mark']) && $data['formdata'][$count]['mark'] =='question,46px,yellow' ) ? "checked" : ''?> required>
                                    <label for="<?=$key?>_question">Question</label>
            
                                    <input type="radio" id="<?=$key?>_red" name=row[<?=$count?>][mark] value='times,46px,red' <?=(isset($data['formdata'][$count]['mark']) && $data['formdata'][$count]['mark'] =='times,46px,red' ) ? "checked" : ''?> required>
                                    <label for="<?=$key?>_red">Red</label>
                                    <span class="error"><br> <?=$data['formerrors'][$count]['mark'] ?? ''?></span>
                                </p>
                            </div>
                            <div class='w3-col m3'>
                                <p><?=$data['percent'][$key]?>%</p>
                            </div>
                        </div><?php
                        $count++;
                    }?>
                    <input class=w3-right type="submit" name="submit" value="Submit">
                </form><?php
                if($data['showvipform']===true) {?>
                    <br><hr style='border:0.5px solid green'><br>
                    <h2 class='w3-center'>Update Best VIP</h2>
                    <form action="<?=htmlspecialchars(URI)?>" method="post" class=w3-container><?php
                        echo "<span class=success>".$data['vipsuccess']."</span>";?>
                        <div class='w3-row-padding w3-stretch'><?php
                        foreach($data['vipformfields'] as $key=>$val) {?>
                            <div class='w3-col m3 w3-center'>
                                <?=$val?>
                                <span class="error"><br> <?=$data['viperrors'][$key] ?? ''?></span>
                            </div><?php
                        }?>
                        </div>
                    </form><?php
                }
            } elseif($this->page=='view_viprecords') {?>
                <form action="<?=htmlspecialchars(URI)?>" method="post">
                    <div class='w3-row-padding w3-stretch'><?php
                    foreach($data['formfields'] as $key=>$val) {?>
                        <div class='w3-col m4'><?=($key != 'submit' ? $key : '').'<br>'.$val?></div><?php
                    }?>
                    </div>
                </form><?php
                foreach($data['marks'] as $ind=>$val) {?>
                    <div class='w3-row-padding w3-stretch'><?php
                    foreach($val as $subkey=>$subval) {?>
                        <div class=w3-half>
                            <h3 style='color:white; background-color: #003300; padding: 16px; border-radius: 10px;'>For <?=$data['games'][$subkey]?></h3>
                            <div class='w3-panel w3-center w3-card'><?=implode($subval)?></div>
                        </div><?php
                    }?>
                    </div><?php
                }
            }?>
        </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var tawkTo = false;
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>