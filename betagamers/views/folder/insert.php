<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
    <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
        <h1><?=$data['h1']?></h1>
        <form method="post" action="<?=htmlspecialchars(URI)?>"><?php
            echo "<span class=success>".$data['formsuccess']."</span>";
            echo "<span class=error>".$data['formerrors']['gen']."</span>";
            
            foreach($data['formfields'] as $key=>$val) {?>
                <div class='w3-margin'><?php
                if(is_array($val)) {
                    echo implode("<span style='margin-right: 10px'></span>", $val)."<span class=error>".$data['formerrors'][$key]."</span>";
                } else {
                    echo "$val<span class=error>".$data['formerrors'][$key]."</span>";
                }
                    ?>
                </div><?php
            }?>
        </form>
    </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script src="<?=HOME?>/assets/js/gen.js"></script>
<script>
    var modegroup = document.querySelectorAll("input[name='mode']");
    var reasonid = document.getElementById('purpose');
    var curid = document.getElementById('currency');
    var amtid = document.getElementsByClassName('amount');
    var planid = document.getElementById('plan');
    var xhttp = new XMLHttpRequest;
    
    for(let i=0; i<modegroup.length; i++) {
        modegroup[i].addEventListener('change', changeRadio);
        if(modegroup[i].value=='deactivate' && modegroup[i].checked) {
            reasonid.classList.remove('w3-hide');
            reasonid.disabled = false;
        }
    }

    curid.addEventListener('change', fetchAmount);
    planid.addEventListener('change', fetchAmount);

    
    function changeRadio() {
        reasonid.classList.toggle('w3-hide');
        reasonid.toggleAttribute('disabled');
    }

    function fetchAmount() {    
        if(curid.value.trim().length == '' || planid.value.trim().length == '') {
            return;
        } else {
            xhttp.onload = function() {
                const resp = this.responseText;
                console.log(resp);
                for(i=0; i<amtid.length; i++) {
                    amtid[i].value = resp;
                }
            }
            xhttp.open('GET', 'insertfetchamt?cur='+curid.value.toLowerCase()+'&plan='+planid.value);
            xhttp.send();
        }
    }
</script>