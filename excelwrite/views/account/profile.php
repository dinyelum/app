<?php include "../app/excelwrite/incs/header.php"?>

<div class=myprofile>
    <h1>Contact Information</h1>
    <form action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>" method="post" id=profform>
        <div class=altformrow>
            <div></div>
            <div>
                <span class=success><?=$data['formdata'][1]['success'] ?? ''?></span>
                <span class=error><?=$data['formdata'][1]['gen'] ?? ''?></span>
            </div>

            <div>First Name</div>
            <div>
                <input type=text name=firstname value='<?=$data['formdata'][0]['firstname'] ?? $_SESSION['user']['firstname']?>'>
                <span class=error><?=$data['formdata'][1]['firstname'] ?? ''?></span>
            </div>
            
            <div>Last Name</div>
            <div>
                <input type=text name=lastname value='<?=$data['formdata'][0]['lastname'] ?? $_SESSION['user']['lastname']?>'>
                <span class=error><?=$data['formdata'][1]['lastname'] ?? ''?></span>
            </div>
            
            <div>Email</div>
            <div>
                <input type=email name=emaiil value='<?=$_SESSION['user']['email']?>' disabled>
            </div>
            
            <div>Phone (+123 format)</div>
            <div>
                <input type=text name=phone value='<?=$data['formdata'][0]['phone'] ?? $_SESSION['user']['phone']?>'>
                <span class=error><?=$data['formdata'][1]['phone'] ?? ''?></span>
            </div><?php
            if(!isset($_SESSION['user']['writer']) || $_SESSION['user']['writer']!=1) {?>
                <div></div>
                <div>
                    <button type="submit" name=submit value='update' id=updatebtn disabled class='disabled'>Update Profile</button>
                </div><?php
            }?>
            
        </div><?php
        if (isset($_SESSION['user']['writer']) && $_SESSION['user']['writer']==1) {?>
            <div class=writers>
                <h3 class='accordion clickable'>Select Subjects (not more than 5)</h3>
                <div class=' panel' id="allsubjects"><?php
                    foreach($data['writer']['allsubjects'] as $ind=>$val) {?>
                    <p>
                        <input type="checkbox" class=checkboxes name="" id="<?='subject'.($ind+1)?>" value="<?=$val['id']?>" >
                        
                        
                        <label for="<?='subject'.($ind+1)?>"><?=$val['subject']?></label>
                    </p><?php
                    }?>
                    
                </div>
                <div style='display:flex; justify-content: space-between'>
                    <div></div>
                    <button type="submit" name=submit value='update' id=updatebtn disabled class='right disabled'>Update Profile</button>
                </div>
            </div><?php
        }?>
    </form>
</div>

<script src='<?=HOME?>/assets/js/gen.js'></script>
<script>
var writersubjects = <?=json_encode(count($_POST) ? $_POST : ($data['writer'] ? $data['writer']['subjects'] : []))?>;
var updatebtnid=document.getElementById("updatebtn"),inputtags=document.getElementsByTagName("input"),allcheckboxes=document.getElementsByClassName("checkboxes"),count=0,subjectnamecount=1,profformid=document.getElementById("profform"),acc=document.getElementsByClassName("accordion");for(let i=0;i<acc.length;i++)acc[i].addEventListener("click",function(){this.classList.toggle("active");var e=this.nextElementSibling;e.style.maxHeight?e.style.maxHeight=null:e.style.maxHeight=e.scrollHeight+"px"});for(let j=0;j<allcheckboxes.length;j++){for(let e in writersubjects)if(writersubjects[e]==allcheckboxes[j].value){allcheckboxes[j].setAttribute("checked",""),allcheckboxes[j].name="subject"+subjectnamecount,subjectnamecount++;break}allcheckboxes[j].checked&&count++}function countChecked(){if(count>=5)for(let e=0;e<allcheckboxes.length;e++)allcheckboxes[e].checked||(allcheckboxes[e].name="",allcheckboxes[e].setAttribute("disabled",""));else for(let t=0;t<allcheckboxes.length;t++)allcheckboxes[t].removeAttribute("disabled")}countChecked();for(let i=0;i<inputtags.length;i++)inputtags[i].addEventListener("input",function(e){if(updatebtnid.removeAttribute("disabled"),updatebtnid.classList.remove("disabled"),"checkbox"==e.target.type){if(count<5&&e.target.checked)e.target.name="subject"+(count+1),count++;else{count=0;for(let t=0;t<allcheckboxes.length;t++)allcheckboxes[t].checked&&(allcheckboxes[t].name="subject"+(count+1),count++)}countChecked()}});
</script>
<?php include "../app/excelwrite/incs/footer.php"?>