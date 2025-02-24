<div class=cartbg>
    <div class='cart container'>
        <h1>Your Items</h1>
        <div class='cartitemssection left'><?php
            if(isset($data['fooddata']) && is_array($data['fooddata'])) {
                foreach($data['fooddata'] as $val) {
                    cart_items($val);
                }
            }?>
            <div id=cartimg style='display:none; width:300px; height:300px; opacity: 0.7'>
                <img src='./images/empty_cart.png' alt='empty cart'>
            </div>
        </div>
        <div class='cartcalc right '>
            <h2>PRICE DETAILS</h2>
            <hr>
            <div class='container cartsubtotal cartmargin'>
                <span class=left>Subtotal</span>
                <span class=right id=subtotal>&#8358;30000</span>
            </div>
            <div class='container cartcharge cartmargin'>
                <div class=left>
                    <p>Delivery Charge</p>
                    <select id="location" onchange='getLocationCharge()'>
                        <option value="">Select Location</option><<?php
                        foreach ($data['locationdata'] as $val) {
                            $location = $val['name'];
                            echo "<option value='$location'>$location</option>";
                        }?>
                    </select>
                </div>
                <div class=right><br><p>&#8358;<span id=locationcharge>0</span></p></div>
            </div>
            <hr>
            <div class='container carttotal cartmargin'>
                <span class=left><b>Total</b></span>
                <span class=right><b>&#8358;<span id=total>0</span></b></span>
            </div>
            <button onclick="checkLoggedIn()">Checkout</button>
        </div>
    </div>
</div>
<script src='./js/gen.js'></script>
<script>
    var xhttp;
    var cardid;
    var allcards = document.getElementsByClassName('cartitemscard');
    var allcardslen = allcards.length;
    var amtid;
    var inputid;
    var qtytotalid;
    var allqtytotal = document.getElementsByClassName('qtytotal');
    // console.log(allqtytotal);
    var subtotalid = document.getElementById('subtotal');
    var calcsubtotal;
    var totalid = document.getElementById('total');
    var allqtyinput = document.getElementsByClassName('qty');
    var locations = <?=json_encode($data['locationdata'])?>;
    var locationchargeid = document.getElementById('locationcharge');
    var locationval;
    var locationcharge = 0;
    var cartimgid = document.getElementById('cartimg');
    var loggedin = <?=isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] == true ? true : 0?>;
    // for(i=0; i<allqtyinput.length; i++) {
    //     allqtyinput[i].value = 1;
    // }
    subtotal();
    console.log(document.getElementById('qty2'));
    if(window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        console.log('back button');
    } else {
        console.log('normal levels');
    }
    if(allcardslen < 1) {
        cartimgid.style.display = 'block';
    }
    function getInput(id) {
        inputid = document.getElementById('qty'+id);
        amtid = document.getElementById('amt'+id);
    }
    function increase(id) {
        getInput(id);
        inputid.value = Number(inputid.value) + 1;
        multiply(id);
    }
    function decrease(id) {
        getInput(id);
        if(inputid.value > 1) {
            inputid.value = Number(inputid.value) - 1;
        } else {
            inputid.value = 1;
        }
        multiply(id);
    }
    function multiply(id) {
        getInput(id);
        qtytotalid = document.getElementById('qtytotal'+id);
        qtytotalid.innerText = inputid.value * amtid.value;
        subtotal();
    }
    function subtotal() {
        calcsubtotal = 0;
        for(i=0; i<allqtytotal.length; i++) {
            if(allcards[i].style.display != 'none') {
                calcsubtotal += Number(allqtytotal[i].innerText);
            }
        }
        // subtotalid.innerText = calcsubtotal;
        total();
    }
    function getLocationCharge() {
        locationval = document.getElementById('location').value;
        if(locationval.trim().length > 0) {
            var res = locations.find(item=>item.name===locationval);
            locationcharge = res.deliverycharge;
        } else {
            locationcharge = 0;
        }
        locationchargeid.innerText = locationcharge;
        total();
    }
    function total() {
        subtotalid.innerText = calcsubtotal;
        totalid.innerText = Number(calcsubtotal) + Number(locationcharge);
    }
    function remove(id) {
        cardid = document.getElementById('card'+id);
        cardid.style.display = 'none';
        var cardqtytotal = document.getElementById('qtytotal'+id).innerText;
        calcsubtotal -= Number(cardqtytotal);
        // total();
        allcardslen -= 1;
        if(allcardslen < 1) {
            locationval = document.getElementById('location');
            locationval.value = '';
            cartimgid.style.display = 'block';
        }
        getLocationCharge();
        xhttp = new XMLHttpRequest;
        xhttp.open('GET', './requests/cart.php?action=remove&productid='+id);
        xhttp.send();
    }
    function checkLoggedIn() {
        if(loggedin==true) {
            var cartform = document.createElement('form');
            cartform.setAttribute('method', 'POST');
            cartform.setAttribute('action', 'order.php');
            for(i=0; i<allqtyinput.length; i++) {
                var forminput = document.createElement('input');
                forminput.setAttribute('name', allqtyinput[i].name);
                forminput.setAttribute('value', allqtyinput[i].value);
                cartform.appendChild(forminput);
                // console.log(allqtyinput[i].name);
            }
            var forminput = document.createElement('input');
            if(locationval == undefined) {
                getLocationCharge();
            }
            if(locationval.trim().length < 1) {
                alert('Please select Location');
                return;
            }
            if(allcardslen < 1) {
                alert('Please add items to your cart.');
                return;
            }
            forminput.setAttribute('name', 'location');
            forminput.setAttribute('value', locationval);
            cartform.appendChild(forminput);
            var formsubmit = document.createElement('input');
            formsubmit.setAttribute('type', 'submit');
            cartform.appendChild(formsubmit);
            document.body.append(cartform);
            cartform.submit();
            // console.log(cartform);
        } else {
            loadModal('loginmodal');
        }
    }
</script>