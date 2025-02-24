<?php
session_start();
// session_destroy();
include '../core/init.php';
include '../core/checklogin.php';
// show($_SESSION);
$orderclass = new Orders;
$addressclass = new Address;
$locationclass = new Location;
$rowcount = $orderclass->select('count(*) as ordercount')->where('clientid='.$_SESSION['user']['id']);
$limitperpage = 5;
$pagecount = ceil($rowcount[0]['ordercount'] / $limitperpage);
$orderdata = $orderclass->select('id, name, status')->where('clientid='.$_SESSION['user']['id']." limit $limitperpage");
$addressdata = $addressclass->select('address.address, location.name')->join('inner join', 'location', 'address.locationid=location.id')->all();
$locationdata = $locationclass->select('id, name')->all('order by name asc');
$listlocations = true;
include '../modals/loginmodal.php';
include '../modals/addaddress.php';
include '../modals/message.php';
?>
<!DOCTYPE html>
<html lang=en dir=ltr>
    <head>
        <meta name=robots content="index, follow">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="">
        <title>My Profile | Tilas Eats</title>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body><?php
include '../includes/header.php'?>
<div class=profpage>
    <table>
        <tr>
            <th>Name</th>
            <td><?=$_SESSION['user']['lastname'].' '.$_SESSION['user']['firstname']?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td class=container style="overflow: hidden">
                <?=$_SESSION['user']['email']?><?php
                if(!isset($_SESSION['user']['emailactive']) || $_SESSION['user']['emailactive'] !== 1) {?>
                    <div class='right clickable primary' onclick="sendMail(); " id=verify style='font-style:italic'>Verify</div><?php
                }?>
            </td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td><?=$_SESSION['user']['phone']?></td>
        </tr>
    </table>
</div>
<div class=profpage>
    <h2>Addresses</h2>
    <ul id=addresslist><?php
        foreach ($addressdata as $val) {?>
            <li><?=$val['name'].', '.$val['address']?></li><?php
        }?>

    </ul>
    <p onclick="loadModal('addaddress')" style='margin-bottom:15px' class=clickable>Add Address <i class='fa fa-plus-circle primary' style='color:#30336b'></i></p>
</div>
<div class=profpage>
    <h2>Orders</h2>
    <table id=ordertable>
        <tr>
            <th>Order Id</th>
            <th>Status</th>
            <th>Action</th>
        </tr><?php
        foreach ($orderdata as $key=>$val) {?>
            <tr>
                <td><?=$val['name']?></td>
                <td><?=$val['status']?></td>
                <td><a href="../order.php?orderid=<?=$val['id']?>">View Order</a></td>
            </tr><?php
        }?>
    </table>
    <p onclick='viewMore()' id=viewbtn class=clickable>View More...</p>
</div>
<script src='../js/gen.js'></script>
<script>
    var offset, limit, pagecount;
    offset = limit = <?=$limitperpage?>;
    pagecount = <?=$pagecount?>;
    var xhttp = new XMLHttpRequest;
    var ordertableid = document.getElementById('ordertable');
    var viewbtnid = document.getElementById('viewbtn');
    var email = '<?=$_SESSION['user']['email']?>';
    var verifyid = document.getElementById('verify');
    //document.getElementById('table1').rows[0].cells.length //count table columns
    function viewMore() {
        xhttp.onload = function () {
            const resp = JSON.parse(xhttp.responseText);
            if(resp.response == 'success') {
                // console.log(resp.response);
                for (let i=0; i<resp.data.length; i++) {
                    var newtr = ordertableid.insertRow(-1);
                    var td0 = newtr.insertCell(0);
                    var td1 = newtr.insertCell(1);
                    var td2 = newtr.insertCell(2);
                    
                    td0.innerText = resp.data[i].name;
                    td1.innerText = resp.data[i].status;
                    td2.innerHTML = "<a href='../order.php?orderid="+resp.data[i].id+"'>View Order</a>";
                }
                offset += limit;
                pagecount -= 1;
                if(pagecount<=1) {
                    viewbtnid.style.display = 'none';
                }
            }
        }
        xhttp.open('GET', '../requests/loadmore.php?section=orders&offset='+offset+'&limit='+limit);
        xhttp.send();
    }
    function sendMail(emailstring='') {
        email = email ?? emailstring;
        verifyid.innerText = '';
        verifyid.className += ' loader';
        xhttp.onload = function () {
            // const resp = JSON.parse(xhttp.responseText);

            const resp = JSON.parse(xhttp.responseText);
            console.log(resp);
            if(resp.success !== undefined) {
                verifyid.style.display = 'none';
            } else {
                verifyid.innerText = 'Verify';
                verifyid.className = 'right clickable primary';
                loadModal('message');
                document.getElementById('modalmessage').innerText = resp.email ?? resp.hash ?? resp.gen;
            }
        }
        xhttp.open('GET', '../requests/sendmail.php?email='+email);
        xhttp.send();
    }
</script>