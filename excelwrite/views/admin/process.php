<?php include "../app/excelwrite/incs/header.php";
$action         = $data['misc']['action'] ?? '';
$section        = $data['misc']['section'] ?? '';
$id             = $data['misc']['id'] ?? '';
$success        = $data['formdata'][0]['success'] ?? '';
$subject        = $data['formdata'][0]['subject'] ?? '';
$channel        = $data['formdata'][0]['channel'] ?? '';
$value          = $data['formdata'][0]['value'] ?? '';
$link           = $data['formdata'][0]['link'] ?? '';
$active         = $data['formdata'][0]['active'] ?? 0;
$ordername      = $data['formdata'][0]['name'] ?? '';
$mode           = $data['formdata'][0]['mode'] ?? '';
$status         = $data['formdata'][0]['status'] ?? '';
$substatus      = $data['formdata'][0]['substatus'] ?? '';
$additionalnote = $data['formdata'][0]['additionalnote'] ?? '';
$currency       = $data['formdata'][0]['currency'] ?? '';
$amount         = $data['formdata'][0]['amount'] ?? '';
$subject        = $data['formdata'][0]['subject'] ?? '';
$type           = $data['formdata'][0]['type'] ?? '';
$file           = $data['formdata'][0]['file'] ?? '';
$finishedwork   = $data['formdata'][0]['finishedwork'] ?? '';
$pages          = $data['formdata'][0]['pages'] ?? '';
$regdate        = $data['formdata'][0]['regdate'] ?? '';
$expdate        = $data['formdata'][0]['expdate'] ?? '';
$writerid       = $data['formdata'][0]['writerid'] ?? '';
$writerfirstname= $data['formdata'][0]['writerfirstname'] ?? '';
$writerlastname = $data['formdata'][0]['writerlastname'] ?? '';
$writeremail    = $data['formdata'][0]['writeremail'] ?? '';
$writerphone    = $data['formdata'][0]['writerphone'] ?? '';
$clientname     = $data['formdata'][0]['clientname'] ?? '';
$clientemail    = $data['formdata'][0]['clientemail'] ?? '';
$clientphone    = $data['formdata'][0]['clientphone'] ?? '';
$subject1       = $data['formdata'][0]['subject1'] ?? '---';
$subject2       = $data['formdata'][0]['subject2'] ?? '---';
$subject3       = $data['formdata'][0]['subject3'] ?? '---';
$subject4       = $data['formdata'][0]['subject4'] ?? '---';
$subject5       = $data['formdata'][0]['subject5'] ?? '---';
$additionalnoteErr = $data['formdata'][1]['additionalnote'] ?? '';
$currencyErr    = $data['formdata'][1]['currency'] ?? '';
$amountErr      = $data['formdata'][1]['amount'] ?? '';
$subjectErr     = $data['formdata'][1]['subject'] ?? '';
$typeErr        = $data['formdata'][1]['type'] ?? '';
$finishedworkErr = $data['formdata'][1]['finishedwork'] ?? '';
$pagesErr       = $data['formdata'][1]['pages'] ?? '';
$regdateErr     = $data['formdata'][1]['regdate'] ?? '';
$expdateErr     = $data['formdata'][1]['expdate'] ?? '';
$writeridErr    = $data['formdata'][1]['writerid'] ?? '';
$modeErr        = $data['formdata'][1]['mode'] ?? '';
$statusErr      = $data['formdata'][1]['status'] ?? '';
$substatusErr   = $data['formdata'][1]['substatus'] ?? '';
$subjectErr     = $data['formdata'][1]['subject'] ?? '';
$channelErr     = $data['formdata'][1]['channel'] ?? '';
$valueErr       = $data['formdata'][1]['value'] ?? '';
$linkErr        = $data['formdata'][1]['link'] ?? '';
$activeErr      = $data['formdata'][1]['active'] ?? '';
$ordernameErr   = $data['formdata'][1]['name'] ?? '';
$genErr         = $data['formdata'][1]['gen'] ?? '';

$rating = $data['formdata'][0]['rating'] ?? 0;
$review = $data['formdata'][0]['review'] ?? '';

$regdate = $regdate ? date('Y-m-d', strtotime($regdate)) : '';
$expdate = $expdate ? date('Y-m-d', strtotime($expdate)) : '';
$display_file = $file ? "<a href='".HOME."/download?ref=assignment&filename=$file'>$file</a>" : '';
$display_finishedwork = $finishedwork ? "<a href='".HOME."/download?filename=$finishedwork'>$finishedwork</a>" : '';
?>
<div class=adminprocess>
    <h1><?=ucwords("$action $section")?></h1>
    <span class=success><?=$success?></span>
    <span class=error><?=$genErr?></span>
    <form action='<?=URI?>' method=post enctype='multipart/form-data'><?php
    if($section == 'subjects') {?>
        <div class='formrow container'>
            <div class=formtext>Subject</div>
            <div class=forminput>
                <input type=text name=subject value='<?=$subject?>'>
                <span class=error><?=$subjectErr?></span>
            </div>
        </div>
        <div class='formrow container'>
            <div class=formtext>Active</div>
            <div class=forminput style='padding: 1%'>
                <span class=formradio>
                    <input type=radio name=active value=1 id=activeyes <?=$active==1 ? 'checked' : ''?>>
                    <label for=activeyes>Yes</label>
                </span>
                <span class=formradio>
                    <input type=radio name=active value=0 id=activeno <?=$active==0 ? 'checked' : ''?>>
                    <label for=activeno>No</label>
                </span>
                <span class=error><?=$activeErr?></span>
            </div>
        </div><?php
    } elseif($section == 'contacts') {?>
        <div class='formrow container'>
            <div class=formtext>Channel</div>
            <div class=forminput>
                <input type=text name=channel value='<?=$channel?>'>
                <span class=error><?=$channelErr?></span>
            </div>
        </div>
        <div class='formrow container'>
            <div class=formtext>Value</div>
            <div class=forminput>
                <input type=text name=value value='<?=$value?>'>
                <span class=error><?=$valueErr?></span>
            </div>
        </div>
        <div class='formrow container'>
            <div class=formtext>Link</div>
            <div class=forminput>
                <input type=text name=link value='<?=$link?>'>
                <span class=error><?=$linkErr?></span>
            </div>
        </div>
        <div class='formrow container'>
            <div class=formtext>Active</div>
            <div class=forminput style='padding: 1%'>
                <span class=formradio>
                    <input type=radio name=active value=1 id=activeyes <?=$active==1 ? 'checked' : ''?>>
                    <label for=activeyes>Yes</label>
                </span>
                <span class=formradio>
                    <input type=radio name=active value=0 id=activeno <?=$active==0 ? 'checked' : ''?>>
                    <label for=activeno>No</label>
                </span>
                <span class=error><?=$activeErr?></span>
            </div>
        </div><?php
    } elseif($section == 'orders') {?>
        <div class='altformrow'>
            <div>Order Id</div>
            <div>
                <p><?=$ordername?></p>
                <input type=hidden name=name value='<?=$ordername?>'>
                <span class=error><?=$ordernameErr?></span>
            </div>
        
            <div>Mode</div>
            <div>
                <select name="mode">
                    <option value="<?=$mode?>"><?=$mode?></option><?php
                    foreach($this->mode as $val) {
                        echo "<option value='$val'>$val</option>";
                    }?>
                </select>
                <span class=error><?=$modeErr?></span>
            </div>
        
            <div>Substatus</div>
            <div>
                <select name="substatus" id=substatus>
                    <option value="<?=$substatus?>"><?=$substatus?></option><?php
                    foreach($this->substatus as $val) {
                        echo "<option value='$val'>$val</option>";
                    }?>
                </select>
                <span class=error><?=$substatusErr?></span>
            </div>
        
        <div>Status</div>
        <div id=status>
            <p><?=$status?></p>
            <input type=hidden name=status value='<?=$status?>'>
            <span class=error><?=$statusErr?></span>
        </div>
        
        <div>Additional Note</div>
        <div>
            <textarea name=additionalnote height='50px' placeholder='Cancelled by User, Cancelled because... (Optional)'><?=$additionalnote?></textarea>
            <span class=error><?=$additionalnoteErr?></span>
        </div>
        
        <div>Currency</div>
        <div>
            <input type=text name=currency value='<?=$currency?>'>
            <span class=error><?=$currencyErr?></span>
        </div>
        
        <div>Amount</div>
        <div>
            <input type=number name=amount value='<?=$amount?>'>
            <span class=error><?=$amountErr?></span>
        </div>
        
        <div>Subject</div>
        <div>
            <input type=text name=subject value='<?=$subject?>'>
            <span class=error><?=$subjectErr?></span>
        </div>
        
        <div>Type (Assignment, Thesis, Project etc)</div>
        <div>
            <input type=text name=type value='<?=$type?>'>
            <span class=error><?=$typeErr?></span>
        </div>
        
        <div>File</div>
        <div><?=$display_file?></div>
        
        <div>Finished Work</div>
        <div>
            <p><?=$display_finishedwork?></p>
            <input type=file name=finishedwork>
            <span class=error><?=$finishedworkErr?></span>
        </div>
        
        <div>Pages</div>
        <div>
            <input type=number name=pages value='<?=$pages?>'>
            <span class=error><?=$pagesErr?></span>
        </div>
        
        <div>Reg Date (dd/mm/yyyy)</div>
        <div>
            <input type=date name=regdate value='<?=$regdate?>'>
            <span class=error><?=$regdateErr?></span>
        </div>
        
        <div>Deadline (dd/mm/yyyy)</div>
        <div>
            <input type=date name=expdate value='<?=$expdate?>'>
            <span class=error><?=$expdateErr?></span>
        </div>
        
        <div>Client Name</div>
        <div><?=$clientname?></div>
        
        <div>Client Email</div>
        <div><?=$clientemail?></div>
        
        <div>Client Phone</div>
        <div><?=$clientphone?></div>
        
        <div>Writer</div>
        <div>
            <select name="writerid" id=writerselect>
                <option value="<?=$writerid?>"><?="$writerfirstname $writerlastname"?></option><?php
                foreach($this->writers as $val) {
                    echo '<option value='.$val['id'].'>'.$val['firstname'].' '.$val['lastname'].'</option>';
                }?>
            </select>
        </div>
        
        <div>Writer Email</div>
        <div id=writeremail><?=$writeremail?></div>
        
        <div>Writer Phone</div>
        <div id=writerphone><?=$writerphone?></div>
        
        <div>Rating</div>
        <div><?=fa_fa_stars($rating)?></div>
        
        <div>Review</div>
        <div><?=$review?></div>
        </div><?php
    } elseif($section == 'writer') {?>
        <div class='altformrow'>
            <div>Writer Name</div>
            <div><p><?="$writerfirstname $writerlastname"?></p></div>
        
            <div>Writer Email</div>
            <div><p><?=$writeremail?></p></div>
        
            <div>Writer Phone</div>
            <div><p><?=$writerphone?></p></div>
        
            <div>Subject 1</div>
            <div><p><?=$subject1?></p></div>
        
            <div>Subject 2</div>
            <div><p><?=$subject2?></p></div>
        
            <div>Subject 3</div>
            <div><p><?=$subject3?></p></div>
        
            <div>Subject 4</div>
            <div><p><?=$subject4?></p></div>
        
            <div>Subject 5</div>
            <div><p><?=$subject5?></p></div>
        
            <div>Active</div>
            <div>
                <span class=formradio>
                    <input type=radio name=active value=1 id=activeyes <?=$active==1 ? 'checked' : ''?>>
                    <label for=activeyes>Yes</label>
                </span>
                <span class=formradio>
                    <input type=radio name=active value=0 id=activeno <?=$active==0 ? 'checked' : ''?>>
                    <label for=activeno>No</label>
                </span>
                <span class=error><?=$activeErr?></span>
            </div>
        </div><?php
    } else {}?>
        
        <div class='formrow container'><?php
        if($action != 'add') {
            echo "<input type=number name='id' value=$id style='display:none'>";
        }?>
            <button type="submit" name=submit value=<?=$action?> style="background-color: #30336b; float: right; margin-top: 5%"><?=ucwords("$action $section")?></button>
        </div>
    </form>
</div>
<script src='<?=HOME?>/assets/js/gen.js'></script><?php
if($section == 'orders') {?>
    <script>
        var statustxt = document.querySelector('#status p');
        var statusinput = document.querySelector('#status input');
        var substatusval = document.getElementById('substatus');
        var writerselect = document.getElementById('writerselect');
        var writers = <?=json_encode($this->writers)?>;
        var writeremail = document.getElementById('writeremail');
        var writerphone = document.getElementById('writerphone');
        substatusChange();
        function substatusChange() {
            if(substatusval.value=='Cancelled' || substatus.value=='Order Completed') {
                statustxt.innerText = statusinput.value = 'Finished';
            } else {
                statustxt.innerText = statusinput.value = 'Open';
            }
        }
        substatusval.addEventListener('change', function(e) {
            substatusChange();
        });
        writerselect.addEventListener('change', function(e){
            for(let x in writers) {
                if(writers[x]['id'] == writerselect.value) {
                    writeremail.innerText = writers[x]['writeremail'];
                    writerphone.innerText = writers[x]['writerphone'];
                }
            }
        });
    </script><?php
}?>
<?php include "../app/excelwrite/incs/footer.php"?>