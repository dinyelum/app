<div id=addaddress class=modal>
    <div class='formcard modal-content' style='width:40%; padding: 10px'>
        <span class=close id=close onclick = "closeModal()">&times;</span>
        <form onsubmit="event.preventDefault(); addAddress('<?=$listlocations ? 'profilepage' : ''?>');" method=post name=addressform>
            <h2 class=center>Add Address</h2>
            <p id=addressformmessage></p>
            <input type="text" name=address value=''>
            <input type="hidden" name=clientid value='<?=$_SESSION['user']['id']?>'><?php
            if(isset($listlocations) && $listlocations===true) {?>
                <select name="locationid" id="" class=right onchange="getSelectedText(this)"><?php
                foreach ($locationdata as $val) {?>
                    <option value="<?=$val['id']?>"><?=$val['name']?></option><?php
                }?>
                </select><?php
            } else {?>
                <input type="hidden" name=locationid value='<?=$locationdata[0]['id']?>'>
                <select name="states" id="" disabled class=right>
                    <option value="<?=$locationdata[0]['name']?>"><?=$locationdata[0]['name']?></option>
                </select><?php
            }?>
            <input type="submit" id=addaddressbtn name=submit value='Add Address'>
        </form>
    </div>
</div>