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
<?php include INCS.'/footer.php';?>
<script src="<?=HOME?>/assets/js/gen.js"></script>
<script>
    var phoneid = document.getElementById('fullphone');
    var sectionid = document.getElementById('section');
    var parameterid = document.getElementById('parameter');
    var parameterlist, paramindex, placeholderobj, key;
    var parameterlistdefault = '<?=$data['defaultparam']?>';
    parameterlistdefault = parameterlistdefault.trim()=='' ? null : parameterlistdefault;
    var newvalueid = document.getElementById('newvalue');

    sectionid.addEventListener('change', adjustParameters);
    parameterid.addEventListener('change', newvalueType);
    parameterid.addEventListener('change', togglePlaceholder);
    parameterid.addEventListener('change', function() {
        if(sectionid.value=='bookies' && parameterid.value=='Countries') {
            newvalueid.value = <?=isset($data['bookiescountries']) ? json_encode($data['bookiescountries']) : ''?>;
        } else {
            newvalueid.value = '';
        }
    });

    adjustParameters();
    function adjustParameters() {
        if(sectionid.value) {
            if(sectionid.value=='users') {
                parameterlist = <?=json_encode($data['generalparams'])?>;
                phoneid.name = 'fullphone';
            } else if(sectionid.value=='bookies') {
                parameterlist = <?=json_encode($data['bookiesparams'])?>;
            }  else {
                phoneid.name = 'phone';
                if(sectionid.value=='agent') {
                    parameterlist = <?=json_encode($data['agentparams'])?>;
                } else {
                    parameterlist = <?=json_encode($data['vipparams'])?>;
                }
            }
            parameterid.options.length = 0;
            paramindex = parameterlist.indexOf(parameterlistdefault);
            parameterid.add(new Option(paramindex>-1 ? parameterlistdefault : 'Select Parameter', paramindex>-1 ? parameterlistdefault : ''));
            for (let i = 0; i < parameterlist.length; i++) {
                parameterid.add(new Option(parameterlist[i]));
            }
        }
    }

    togglePlaceholder();
    function togglePlaceholder() {
        key = parameterid.value.toLowerCase();
        placeholderobj = {phone: '0706123459', country: 'NG', countries:'NG, CM, GH', network:'Airtel Uganda, MTN Kenya', intl:'+234 or +2340', level:'agent, misc, thief'}
        if(key in placeholderobj) {
            newvalueid.placeholder = 'Eg: '+placeholderobj[key];
        } else {
            newvalueid.placeholder = 'New Value';
        }
    }

    newvalueType();
    function newvalueType() {
        if(parameterid.value=='Reg Date' || parameterid.value=='Exp Date') {
            newvalueid.type = 'date';
        } else {
            newvalueid.type = 'text';
        }
    }
</script>