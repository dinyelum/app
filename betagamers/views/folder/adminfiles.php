<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
            <h1><?=$data['h1']?></h1><?php
            // show(array_column($data['adminfiles'], 'id'));
            if($this->page=='update_adminfiles') {?>
                <div class='w3-row-padding w3-stretch'>
                    <form method="post" action="<?=htmlspecialchars(URI)?>" enctype="multipart/form-data"><?php
                        echo "<span class=success>".$data['formsuccess']."</span>";
                        echo "<span class=error>".($data['formdata'][1]['lang'] ?? $data['formdata'][1]['folder'] ?? $data['formerrors']['gen'])."</span>";
                        echo "<div id=inputs class='w3-row-padding w3-stretch'></div>";
                        foreach($data['formfields'] as $key=>$val) {?>
                            <div class='w3-col m4 w3-border w3-center'>
                                <?=$val?>
                                <span class="error"><br> <?=$data['formerrors'][$key] ?? ''?></span>
                            </div><?php
                        }?>
                        <div id=inputs></div>
                    </form>
                </div><?php
            } elseif($this->page=='view_adminfiles') {
                foreach($data['adminfiles'] as $key=>$val) {?>
                    <button class='w3-btn w3-block w3-left-align w3-green accobtn w3-section'><?=ucwords($key)?><i class='fa fa-plus w3-right'></i></button>
                    <div class='w3-hide accocontent'>
                        <table class=w3-section>
                            <tr><th><?=implode('</th><th>', array_filter(array_keys($val[0]), fn($th)=>!in_array($th, ['id', 'downloaded', 'folder'])))?></th></tr><?php
                            foreach($val as $subind=>$subval) {?>
                                <tr <?=$subval['downloaded']==0 ? "style='color:blue'" : ''?>  class=tdlink>
                                    <td><a href='download?fileid=<?=$subval['id']?>'><?=implode('</td><td>', array_filter($subval, fn($tdk)=>!in_array($tdk, ['id', 'downloaded', 'folder']), ARRAY_FILTER_USE_KEY))?></a></td>
                                </tr><?php
                            }?>
                        </table>
                    </div><?php
                }?>
                <!-- if session is set that there are updates -->
                <p><span id=notesid onclick=loadModal('w3-message') style='color:green; cursor:pointer'>*Notes</span></p>
                <?php $message=$data['modalmessage']; include(ROOT.'/app/modals/w3-message.php')?>
                <a href='download?<?=http_build_query(array('fileid' => $data['adminfileids']))?>' id=dbtn><button class='w3-button w3-green'>Download All</button></a><?php
            }?>
        </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script src="<?=HOME?>/assets/js/gen.js"></script>
<script><?php
    if($this->page=='update_adminfiles') {?>
        var f = document.getElementById('filegroup');
        var i = document.getElementById('inputs');
        f.addEventListener('change', toggleInputs); 
        toggleInputs();
        function toggleInputs() {
            if(f.value=='screenshots') {
                var date = '<?=$data['formdata'][0]['date'] ?? ''?>';
                var dateErr = '<?=$data['formdata'][1]['date'] ?? ''?>';
                var lang = '<?=$data['formdata'][0]['lang'] ?? ''?>';
                var langs = <?=json_encode(LANGUAGES)?>;
                var s = "<div class='w3-col m6'><input type=date name=date value="+date+"><span class=w3-error>"+dateErr+"</span></div>";
                var sEl = sElObj('lang', lang, 'Select Language', langs);
                i.innerHTML = s;
                var divEl = document.createElement('div');
                divEl.className += 'w3-col m6';
                divEl.appendChild(sEl);
                i.appendChild(divEl);
            } else if(f.value=='adminfiles') {
                var folder = '<?=$data['formdata'][0]['folder'] ?? ''?>';
                var folders = <?=json_encode($data['workfilefolders'])?>;
                var sEl = sElObj('folder', folder, 'Select Folder', folders);
                var divEl = document.createElement('div');
                divEl.className += 'w3-col m4';
                divEl.appendChild(sEl);
                i.appendChild(divEl);
                // i.innerHTML = divEl;
            } else {
                i.innerText = '';
            }
        }<?php
    } else {?>
        var d = document.querySelectorAll('.tdlink');
        var dbtn = document.getElementById('dbtn');
        dbtn.addEventListener('click', function(){
            d.forEach(function(item){
                item.style.color = 'black'; 
            });
        });
        d.forEach(function(item){
            item.addEventListener('click', function(){
                item.style.color = 'black'; 
            });
        });
        function loadModal(type){modal=type;modalid=document.getElementById(type);modalid.style.display='block'}
        function closeModal(){modalid.style.display='none'}
        window.onclick=function(event){if(event.target.id==modal){closeModal()}}<?php
    }?>




    var notefieldid = document.getElementById('notefield');
    function addNoteField() {
        if(modeid.value==='adminfiles') {
            notefieldid.style.display = 'block';
        } else {
            notefieldid.style.display = 'none';
        }
    }
</script>