<?php
include '../app/tilaseats/modals/addaddress.php';
?>
<div class='ordercard'>
    <h1>Order Summary</h1>
    <table>
        <tr>
            <td>Order Id</td>
            <td><?=$data['order']['name']?></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td><?=$data['order']['totalamount']?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php
                if($data['adminmode']) {?>
                    <select name="statuslist" id="statuslist" onchange="updateStatus()">
                        <option value="<?=$data['order']['status']?>"><?=$data['order']['status']?></option><?php
                        foreach ($orderclass->status as $val) {
                            echo "<option value='$val'>$val</option>";
                        }?>
                    </select>
                    <span id=statusmessage></span><?php
                } else {
                    echo $data['order']['status'];
                }?>
            </td>
        </tr>
        <tr>
            <td>Order Created</td>
            <td><?=$data['order']['regdate'].' WAT'?></td>
        </tr>
    </table><?php
    if($data['order']['status'] == 'Not Started' || $data['order']['status'] == 'Awaiting Approval') {?>
        <div>
            <h2>Account Details</h2>
            <?=display_acct_details($data['acctsdata'])?>
        </div><?php
    }?>
    <div>
        <h2>Items Summary</h2><?php
        foreach ($data['fooddata'] as $key => $val) {?>
            <div class='container itemrow center'>
                <div class='left itemqty'><?=$val['qty']?></div>
                <div class='left itemnamedesc'>
                    <p><?=$val['name']?></p>
                    <p><?=$val['short_desc']?></p>
                </div>
                <div class='left itemamt' style='text-align: right'><?=($val['discount'] ?? $val['amount'])*$val['qty'].'(&#8358;)'?></div>
            </div><?php
        }?>
        
    </div>
    <div>
        <h2>Delivery Details</h2>
        <div class=centercard>
            <div class='container itemrow' style='margin-bottom:15px'>
                <p class=left>Location:</p>
                <p class=right><?=$data['locationdata']['name']?></p>
            </div><?php
            if($data['locationdata']['homedelivery'] == 1) {?>
                <div class='container itemrow'>
                    <p class=left>Address:</p>
                    <p class=right><?php
                        if($data['adminmode']) {
                            echo $orderdata[0]['address'];
                        } else {?>
                            <select name="address" id="addresslist" onchange="updateAddress()" style='padding: 3px'>
                                <option value="">Select Address</option><?php
                                foreach ($addressdata as $val) {?>
                                    <option value="<?=$val['id']?>"><?=$val['address']?></option><?php
                                }?>
                            </select>
                            <span id=addressmessage></span><?php
                        }?>
                    </p>
                </div><?php
                if(!$data['adminmode']) {?>
                    <p onclick="loadModal('addaddress')" class='right clickable' style='margin-bottom:15px'>Add Address <i class='fa fa-plus-circle'></i></p><?php
                }
            }?>
            <div class='container itemrow'>
                <p class=left>Charge:</p>
                <p class=right><?=$data['locationdata']['deliverycharge'].'(&#8358;)'?></p>
            </div>
        </div>
    </div>
    <div>
        <h2>Instructions</h2><?php
        if($data['adminmode']) {?>
            <div style='border: 1px solid black; padding: 10px'><?=$orderdata[0]['instructions'] ?? 'None'?></div><?php
        } else {?>
            <p><i>Tell us if you're allergic to anything or if you like a little more salt or a little more pepper</i></p>
            <form action="" method="post" onsubmit='event.preventDefault(); submitins()' name=orderins>
            <p id=insmessage></p>
                <textarea name="instructions" cols="30" rows="10" placeholder='Optional..'><?=$orderdata[0]['instructions'] ?? ''?></textarea>
                <input type="submit">
            </form><?php
        }?>
    </div>
    <div class=center>
        <h2 style='color: #4834d4'>Payment Proof</h2><?php
        if(isset($orderdata[0]['paymentproof'])) {
            echo "<i><a href='./images/".$orderdata[0]['paymentproof']."' target='_blank'>Preview Uploaded Image</a></i>";
        }?>
        <form action="./requests/orderpage.php" method="post" enctype="multipart/form-data" onsubmit='event.preventDefault(); submitproof()' name=orderproof>
            <p id=proofmessage></p>
            <input type="file" name=paymentproof>
            <input type="submit" value="Upload Image" name="submit img" style='background: #4834d4'>
        </form>
    </div>
</div>
<script src='./assets/js/gen.js'></script>
<script>
    var xhttp = new XMLHttpRequest;
    var form;
    var addresslistid = document.getElementById('addresslist');
    var statuslistid = document.getElementById('statuslist');
    var orderid = <?=$_GET['orderid']?>;
    var foodids = '<?=http_build_query(['foodids'=>$foodids])?>';
    function updateStatus() {
        var statusmessageid = document.getElementById('statusmessage');
        statusmessageid.innerText = ''
        xhttp.onload = function () {
            // const resp = xhttp.responseText;
            const resp = JSON.parse(xhttp.responseText);
            // console.log(resp);
            if(resp.success !== undefined) {
                statusmessageid.innerHTML = "<i class='fa fa-check' style='font-size:20px'></i>";
                statusmessageid.className += ' success';
            } else {
                statusmessageid.innerText = resp.orderstatus ?? resp.gen;
                statusmessageid.className += ' error';
            }
        }
        xhttp.open('GET', './requests/orderpage.php?id='+orderid+'&orderstatus='+statuslistid.value+'&'+foodids);
        xhttp.send()
    }
    function submitins() {
        var insmessageid = document.getElementById('insmessage');
        form = new FormData(orderins);
        xhttp.onload = function () {
            const resp = JSON.parse(xhttp.responseText);
            if(resp.success !== undefined) {
                insmessageid.innerText = resp.success;
                insmessageid.className += ' success';
            } else {
                insmessageid.innerText = resp.instructions ?? resp.gen;
                insmessageid.className += ' error';
            }
        }
        xhttp.open('POST', './requests/orderpage.php');
        xhttp.send(form);
    }
    function submitproof() {
        var proofmessageid = document.getElementById('proofmessage');
        form = new FormData(orderproof);
        xhttp.onload = function () {
            const resp = JSON.parse(xhttp.responseText);
            // console.log(resp);
            if(resp.success !== undefined) {
                proofmessageid.innerText = resp.success;
                proofmessageid.className += ' success';
            } else {
                if(resp.paymentproof == 'File already exists') {
                    resp.paymentproof = 'Payment proof already exists for this order';
                }
                proofmessageid.innerText = resp.paymentproof ?? resp.gen;
                proofmessageid.className += ' error';
            }
        }
        xhttp.open('POST', './requests/orderpage.php');
        xhttp.send(form);
    }
    function updateAddress() {
        var addressmessageid = document.getElementById('addressmessage');
        addressmessageid.innerText = '';
        if(addresslist.value.trim().length > 0) {
            xhttp.onload = function () {
                const resp = JSON.parse(xhttp.responseText);
                // console.log(resp);
                if(resp.success !== undefined) {
                    addressmessageid.innerHTML = "<i class='fa fa-check' style='font-size:20px'></i>";
                    addressmessageid.className += ' success';
                } else {
                    addressmessageid.innerText = resp.addressid ?? resp.gen;
                    addressmessageid.className += ' error';
                }
            }
            xhttp.open('GET', './requests/orderpage.php?addressid='+addresslistid.value);
            xhttp.send();
        }
    }
</script>