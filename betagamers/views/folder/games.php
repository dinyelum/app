<?php include ROOT."/app/betagamers/incs/header.php"?>
<style>
    @media screen and (max-width:400px) {
        .inputcontainer {
            border: 1px solid black;
            padding: 1%;
            margin: 1% 0;
        }
    }
    .inputcontainer input[type=text] {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
            <h1><?=$data['h1']?></h1>
            <div class="w3-row w3-stretch">
                <div class="w3-half ">
                    <form name="myForm" onsubmit="event.preventDefault(); addinput()">
                        <div class="w3-half">
                            <input type='text' name='number'>
                        </div>
                        <div class="w3-half">
                            <input type='submit' value='Add Fields'>
                        </div>
                    </form>
                </div>
                <div class="w3-half">
                    <button class='updatebutton w3-button w3-padding-16 w3-green w3-right' onclick="updateinput()">Update Games</button>
                </div>
            </div>
            <div class="w3-row w3-stretch">
                <form name="myInputForm" method="post" onsubmit="event.preventDefault(); handlegames('input')">
                    <div>
                        <input type='date' name='date' style='width: 40%' class=inputextra>
                        <!-- add little select to toggle select options for different sports --> 
                        <select name='<?=$this->page=='vipgames' ? 'games' : 'league'?>' style='width: 40%; float: right' class=inputextra>
                            <option value="">Select Game</option><?php
                            foreach($data['games'] as $key=>$val) {?>
                                <option value='<?=$key?>'><?=$val?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='w3-row-padding w3-stretch'><?php
                    foreach($data['inputheader'] as $key=>$val) {
                        echo "<div class='w3-col $val w3-center'>$key</div>";
                    }?>
                    </div>
                    <div id='input'></div>

                    <div class='w3-row-padding w3-stretch'>
                        <input type="submit" name="submit" value="Submit" style='float: left'>  
                        <a href='copy<?=$this->page=='freegames' ? '?type=free' : ''?>' target='_blank'><span  class='w3-button w3-padding-16 w3-green w3-right' style='float: right'>Copy Games</span></a>
                    </div>
        
                </form>
            </div>

            <div>
                <h2 class=w3-center>Update Games</h2>
                <form method="post" onsubmit="event.preventDefault(); handlegames('update')">
                    <div class='w3-row-padding w3-stretch w3-center'><?php
                    foreach($data['updateheader'] as $key=>$val) {
                        echo "<div class='w3-col $val w3-center'>$key</div>";
                    }?>
                    </div>
                    <div id='update'></div>

                    <input type="submit" name="update" value="Update">  
                </form>
            </div><?php
            if($this->page=='vipgames') {?>
                <div>
                    <h2 class=w3-center>Update Odds</h2>
                    <form method="post" name=updateoddsform onsubmit="event.preventDefault(); updategameodds()">
                        <div id='updateoddsresp'></div>
                        <div class='w3-row-padding w3-stretch'>
                            <div class='w3-col m4'>
                                <input type='date' name='date' value="<?=isset($_POST['date']) ? $_POST['date'] : '' ?>">
                            </div>
                            <div class='w3-col m3'>
                                <select name='games'>
                                    <option value="">Select Game</option><?php
                                    foreach($data['games'] as $key=>$val) {?>
                                        <option value='<?=$key?>'><?=$val?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class='w3-col m3'>
                                <input type=number step=any name='totalodds' placeholder='Total Odds' value="<?=isset($_POST['totalodds']) ? $_POST['totalodds'] : ''?>">
                            </div>
                            <div class='w3-col m2'>
                                <input type="submit" name="updateodds" value="Submit">  
                            </div>
                        </div>
                    </form>
                </div><?php
            }?>
        </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var z = '<?=str_replace('games', '', $this->page)?>';
    function addinput() {
        let x = document.forms["myForm"]["number"].value;
        let y = document.getElementById("input");

        if (x == "") {
            document.getElementById("input").innerHTML = "";
            return;
        }
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            const node = document.createElement('div');
            node.innerHTML = this.responseText;
            y.appendChild(node);
        }
        xhttp.open("GET", "<?=HOME?>/requests/addfields?add="+x+"&gametype="+z);
        xhttp.send();
    }

    function updateinput() {
        let sec = "<?=$this->page=='vipgames' ? 'games' : 'league'?>";
        let x = document.forms["myInputForm"]["date"].value;
        let y = document.forms["myInputForm"][sec].value;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("update").innerHTML = this.responseText;
        }
        xhttp.open("GET", "<?=HOME?>/requests/addupdatefields?date="+x+"&"+sec+"="+y+"&gametype="+z);
        xhttp.send();
    }

    function handlegames(section) {
        var elements = document.querySelectorAll("#"+section+" input", "#"+section+" select");
        var form = new FormData();
        for(var i = 0; i < elements.length; i++) {
            form.append(elements[i].name, elements[i].value)
        }
        if(section=='input') {
            var extra = document.querySelectorAll(".inputextra");
            for(var i = 0; i < extra.length; i++) {
                form.append(extra[i].name, extra[i].value)
            }
        }
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById(section).innerHTML = this.responseText;
        }
        xhttp.open('POST', '<?=HOME?>/requests/gamehandler?action='+section+'&gametype='+z);
        xhttp.send(form);
    }

    function updategameodds() {
        var elements = document.forms["updateoddsform"];
        var form = new FormData(elements);
        var xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById('updateoddsresp').innerHTML = this.responseText;
        }
        xhttp.open('POST', '<?=HOME?>/requests/updateodds');
        xhttp.send(form);
    }
    var tawkTo = false;
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>