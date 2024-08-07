<?php include "../app/excelwrite/incs/header.php"?>
<style>
    #reviewform .fa {
        margin: 2% 1%;
    }
</style>
<div id=ordermodal class=modal>
    <div class='formcard modal-content'>
        <span class=close id=close onclick = "closeModal()">&times;</span>
        <h1 class=center>Place Order</h1>
        <span class=success id=success></span>
        <span class=error id=gen></span>
        <form  id=orderform onsubmit="event.preventDefault(); submitAssignment()" action="" method="post" enctype='multipart/form-data'>
            <input type="hidden" name=name value="<?=bin2hex(random_bytes(4))?>">
            <div class='container'>
                <div class=forminput>
                    <input type=text name=clientname value="<?=$_SESSION['user']['fullname'] ?? ''?>" placeholder='Name' style='width:100%'>
                    <span class=error id=clientname style='width:100%'></span>
                </div>
                <div class=forminput>
                    <input type=text name=clientemail value="<?=$_SESSION['user']['email'] ?? ''?>" placeholder='Email' style='width:100%'>
                    <span class=error id=clientemail></span>
                </div>
            </div>
            <div class='container'>
                <div class=forminput>
                    <input type=text name=clientphone value="<?=$_SESSION['user']['phone'] ?? ''?>" placeholder='Phone Number (+123 format)' style='width:100%'>
                    <span class=error id=clientphone></span>
                </div>
                <div class=forminput>
                    <input type=text name=subject value="" placeholder='Subject' style='width:100%'>
                    <span class=error id=subject></span>
                </div>
            </div>
            <div class='container'>
                <div class=forminput>
                    <select name="mode" id="" style='width:100%'>
                        <option value="">--- Select Mode ---</option>
                        <option value="writing">Writing</option>
                        <option value="rewriting">Rewriting</option>
                        <option value="editing">Editing</option>
                    </select>
                    <span class=error id=mode></span>
                </div>
                <div class=forminput>
                    <input type=number name=pages style='width:100%' placeholder='Pages'>
                    <span class=error id=pages></span>
                </div>
            </div>
            <div class='container'>
                <div class=forminput>
                    <input type=text name=expdate style='width:100%' placeholder='Deadline' onfocus="(this.type='date')">
                    <span class=error id=expdate></span>
                </div>
                <div class=forminput>
                    <input type=file name=file style='width:100%'>
                    <span class=error id=file></span>
                </div>
            </div>
            <div class=forminputsubmit style='margin-top: 10px'>
                <input type="submit" name=submit value='Get a Quote' style='width:100%; margin-top: 10px' id=submitbtn>
            </div>
        </form>
    </div>
</div>
<div id=viewordermodal class=modal>
    <div class='formcard modal-content'>
        <h1>Order Details</h1>
        <table>
            <tr>
                <th style='width:50%'>Order Id</th>
                <td id=ordername></td>
            </tr>
            <tr>
                <th>Project Type</th>
                <td id=ordermode></td>
            </tr>
            <tr>
                <th>Subject</th>
                <td id=ordersubject></td>
            </tr>
            <tr>
                <th>Pages</th>
                <td id=orderpages></td>
            </tr>
            <tr>
                <th>Deadline</th>
                <td id=orderexpdate></td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td id=ordersubstatus></td>
            </tr>
            <tr>
                <th>Additional Message</th>
                <td id=orderadditionalnote></td>
            </tr>
            <tr>
                <th>Currency</th>
                <td id=ordercurrency></td>
            </tr>
            <tr>
                <th>Amount</th>
                <td id=orderamount></td>
            </tr>
            <tr>
                <th>Rating</th>
                <td id=orderrating></td>
            </tr>
            <tr>
                <th>Review</th>
                <td id=orderreview></td>
            </tr>
            <tr style='display:none'>
                <th>Client Email</th>
                <td id=orderclientemail></td>
            </tr>
        </table>
        <div class='container center' style='margin:5% 0' id=reviewformcontainer>
            <h3>Rate the quality of the assignment</h3>
            <p id=gen class=error></p>
            <p id=rating class=error></p>
            <p id=review class=error></p>
            <form  id=reviewform onsubmit="event.preventDefault(); submitReview()" action="" method="post" style='color:green'>
                <p style='font-size:30px'><?=fa_fa_stars(0)?></p>
                <input type="hidden" name="rating" id=ratingval>
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="name" id="name">
                <textarea name="review" style='width:100%' rows=5></textarea>
                <button type="submit" name='submit' value='update' class=right id=reviewformbtn>Submit Review</button>
            </form>
        </div>
    </div>
</div>

<div class='clients ordercontainer container'>
    <h2>My Orders</h2>
    <div class=orderheader>
        <ul>
            <li class='tablinks clickable'>All Orders</li>
            <li class='tablinks clickable'>Open</li>
            <li class='tablinks clickable'>FInished</li>
        </ul>
    </div>
    <div class=orderbody><?php
        if(is_array($data['order_details']) && count($data['order_details'])) {?>
        <table id=ordertable>
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody class='tabcontainer fadein' id=allorders><?php
                    foreach($data['order_details'] as $ind=>$val) {?>
                        <tr>
                            <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                            <td><?=$val['subject']?></td>
                            <td><?=$val['substatus']?></td>
                            <td><?=$val['expdate']?></td>
                        </tr><?php
                    }?>
                </tbody>
                <tbody class='tabcontainer fadein' id=openorders style='display:none'><?php
                    foreach($data['filtered_order_details'] as $ind=>$val) {
                        if(strtolower($val['status']) == 'open') {?>
                            <tr>
                                <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                                <td><?=$val['subject']?></td>
                                <td><?=$val['substatus']?></td>
                                <td><?=$val['expdate']?></td>
                            </tr><?php
                        } else {
                            // echo 'nothing here yet';
                        }
                    }?>
                </tbody>
                <tbody class='tabcontainer fadein' id=finorders style='display:none'><?php
                    foreach($data['filtered_order_details'] as $ind=>$val) {
                        if(strtolower($val['status']) == 'finished') {?>
                            <tr>
                                <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                                <td><?=$val['subject']?></td>
                                <td><?=$val['substatus']?></td>
                                <td><?=$val['expdate']?></td>
                            </tr><?php
                        } else {
                            // echo 'nothing here yet';
                        }
                    }?>
                </tbody>
        </table>
        <button onclick="viewMore('allbtn', clientbtns)" id=allbtn class='viewmorebtn clickable'>View More...</button>
        <button onclick="viewMore('openbtn', clientbtns)" id=openbtn class='viewmorebtn clickable none'>View More...</button>
        <button onclick="viewMore('finbtn', clientbtns)" id=finbtn class='viewmorebtn clickable none'>View More...</button><?php
                
            } else {?>
                <div class=center>
                    <div class=full>
                        <img src="../assets/images/undraw_no_data.svg" alt="Empty Order" width=324 height=316 style='opacity:0.5'>
                    </div><br><br>
                    <button onclick="loadModal('ordermodal')" style='background:#04004d'>Place New Order</button>
                </div>
                <?php
            }?>
    </div>
</div><?php
if (isset($_SESSION['user']['writer']) && $_SESSION['user']['writer']==1) {?>
    <div class='writers ordercontainer container'>
        <h2>As a Writer</h2>
        <div class=orderheader>
            <ul>
                <li class='tablinks clickable'>All Orders</li>
                <li class='tablinks clickable'>Open</li>
                <li class='tablinks clickable'>FInished</li>
            </ul>
        </div>
        <div class=orderbody><?php
            if(is_array($data['writer']['order_details']) && count($data['writer']['order_details'])) {?>
            <table id=ordertable>
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody class='tabcontainer fadein' id=allorders><?php
                        foreach($data['writer']['order_details'] as $ind=>$val) {?>
                            <tr>
                                <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                                <td><?=$val['subject']?></td>
                                <td><?=$val['substatus']?></td>
                                <td><?=$val['expdate']?></td>
                            </tr><?php
                        }?>
                    </tbody>
                    <tbody class='tabcontainer fadein' id=openorders style='display:none'><?php
                        foreach($data['writer']['filtered_order_details'] as $ind=>$val) {
                            if(strtolower($val['status']) == 'open') {?>
                                <tr>
                                    <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                                    <td><?=$val['subject']?></td>
                                    <td><?=$val['substatus']?></td>
                                    <td><?=$val['expdate']?></td>
                                </tr><?php
                            } else {
                                // echo 'nothing here yet';
                            }
                        }?>
                    </tbody>
                    <tbody class='tabcontainer fadein' id=finorders style='display:none'><?php
                        foreach($data['writer']['filtered_order_details'] as $ind=>$val) {
                            if(strtolower($val['status']) == 'finished') {?>
                                <tr>
                                    <td><span class=clickable onclick="loadModal('viewordermodal'); fetchOrderDetails('orders', <?=$val['id']?>);"><?=$val['name']?></span></td>
                                    <td><?=$val['subject']?></td>
                                    <td><?=$val['substatus']?></td>
                                    <td><?=$val['expdate']?></td>
                                </tr><?php
                            } else {
                                // echo 'nothing here yet';
                            }
                        }?>
                    </tbody>
            </table>
            <button onclick="viewMore('allbtn', writerbtns)" id=allbtn class='viewmorebtn clickable'>View More...</button>
            <button onclick="viewMore('openbtn', writerbtns)" id=openbtn class='viewmorebtn clickable none'>View More...</button>
            <button onclick="viewMore('finbtn', writerbtns)" id=finbtn class='viewmorebtn clickable none'>View More...</button><?php
                    
                } else {?>
                    <div class=center>
                        <div class=full>
                            <img src="../assets/images/undraw_empty_street.svg" alt="Empty Order" width=645 height=236 style='opacity:0.5'>
                        </div>
                    </div>
                    <?php
                }?>
        </div>
    </div><?php
}?>
<script src='<?=HOME?>/assets/js/gen.js'></script>
<script>
var offset,tempoffset,limit,status,statustxt,sectionid,viewbtnid,orderid,datamode,alloffset,allpagecount,openoffset,openpagecount,finoffset,finpagecount,w_alloffset,w_allpagecount,w_openoffset,w_openpagecount,w_finoffset,w_finpagecount;offset = alloffset = openoffset = finoffset= limit = <?=$data['limitperpage'] ?? 0?>;w_alloffset = w_openoffset = w_finoffset=  <?=$data['writer']['limitperpage'] ?? 0?>;
    allpagecount = <?=$data['allpagecount'] ?? 0?>;
    openpagecount = <?=$data['openpagecount'] ?? 0?>;
    finpagecount = <?=$data['completedpagecount'] ?? 0?>;
    w_allpagecount = <?=$data['writer']['allpagecount'] ?? 0?>;
    w_openpagecount = <?=$data['writer']['openpagecount'] ?? 0?>;
    w_finpagecount = <?=$data['writer']['completedpagecount'] ?? 0?>;
    var clientemail = '<?=$_SESSION['user']['email']?>';
    var datahash = '<?=base64_encode('name_mode_substatus_status_additionalnote_currency_amount_subject_pages_expdate_rating_review_clientemail')?>';
    var tdata=["name","mode","substatus","additionalnote","currency","amount","subject","pages","expdate","rating","review","clientemail"];function showViewBtn(e,t=clientbtns){for(let n in t)t[n].btnname==e&&(viewbtnid=document.querySelector(t[n].selector),t[n].pagecount<=1&&(viewbtnid.style.display="none"))}showViewBtn("allbtn"),showViewBtn("allbtn",writerbtns);var clientbtns=[{btnname:"allbtn",btnid:"allbtn",selector:".clients #allbtn",offset:alloffset,pagecount:allpagecount,tabid:"allorders",tabselector:".clients #allorders",status:null},{btnname:"openbtn",btnid:"openbtn",selector:".clients #openbtn",offset:openoffset,pagecount:openpagecount,tabid:"openorders",tabselector:".clients #openorders",status:"open"},{btnname:"finbtn",btnid:"finbtn",selector:".clients #finbtn",offset:finoffset,pagecount:finpagecount,tabid:"finorders",tabselector:".clients #finorders",status:"finished"}],writerbtns=[{btnname:"allbtn",btnid:"allbtn",selector:".writers #allbtn",offset:w_alloffset,pagecount:w_allpagecount,tabid:"allorders",tabselector:".writers #allorders",status:null},{btnname:"openbtn",btnid:"openbtn",selector:".writers #openbtn",offset:w_openoffset,pagecount:w_openpagecount,tabid:"openorders",tabselector:".writers #openorders",status:"open"},{btnname:"finbtn",btnid:"finbtn",selector:".writers #finbtn",offset:w_finoffset,pagecount:w_finpagecount,tabid:"finorders",tabselector:".writers #finorders",status:"finished"}];function viewMore(e,t=clientbtns){for(let n in console.log("status is: "+status),statustxt="&status="+status,datamode=t==writerbtns?"writer":"",t)t[n].btnname==e&&(sectionid=document.querySelector(t[n].tabselector),viewbtnid=document.querySelector(t[n].selector));for(let s in xhttp.onload=function(){let n=JSON.parse(xhttp.responseText);if(console.log(n),"success"==n.response){console.log(n.response);for(let s=0;s<n.data.length;s++){var r=sectionid.insertRow(-1);r.className="fadein";var a=r.insertCell(0),l=r.insertCell(1),o=r.insertCell(2),c=r.insertCell(3);a.innerText=n.data[s].name,a.innerHTML="<span class=clickable onclick=\"loadModal('viewordermodal'); fetchOrderDetails('orders', "+n.data[s].id+');">'+n.data[s].name+"</span>",l.innerText=n.data[s].subject,o.innerText=n.data[s].substatus,c.innerText=n.data[s].expdate}for(let d in t)t[d].btnname==e&&(t[d].offset+=limit,t[d].pagecount-=1,console.log("offset is now: "+t[d].offset+" and page is now "+t[d].pagecount),showViewBtn(e,t))}},t)t[s].btnname==e&&(offset=t[s].offset);console.log("offset before is: "+offset),xhttp.open("GET","<?=HOME?>/requests/loadmore.php?section=orders&offset="+offset+"&limit="+limit+statustxt+"&datamode="+datamode),xhttp.send()}var clienttablinks=document.querySelectorAll(".clients .tablinks"),cviewmorebtns=document.querySelectorAll(".clients .viewmorebtn"),writertablinks=document.querySelectorAll(".writers .tablinks"),wviewmorebtns=document.querySelectorAll(".writers .viewmorebtn"),sectionnames=["allorders","openorders","finorders"],classsections=[".clients",".writers"],allbtns=[clientbtns,writerbtns],allviewmorebtns=[cviewmorebtns,wviewmorebtns];function fetchOrderDetails(e,t){orderidval.value=t,xhttp.onload=function(){let e=JSON.parse(xhttp.responseText);ordernameval.value=e[0].name??"",console.log(e[0]),tdata.forEach(function(t,n,s){t in e[0]&&(console.log(t),"rating"==t&&e[0][t]?document.getElementById("order"+t).innerHTML=e[0][t]+' <i class="fa fa-star primary" aria-hidden="true"></i>':document.getElementById("order"+t).innerText=e[0][t])}),displayReview()},xhttp.open("GET","<?=HOME?>/requests/fetchfromdb.php?section="+e+"&datahash="+datahash+"&id="+t),xhttp.send()}[clienttablinks,writertablinks].forEach(function(e,t,n){for(let s=0;s<e.length;s++)e[s].addEventListener("click",function(){for(let e in clientbtns)if(allbtns[t][e].tabid==sectionnames[s]){for(toggleTab(classsections[t]+" .tablinks",classsections[t]+" .tabcontainer",allbtns[t][e].tabselector),this.className+=" active",sectionid=document.querySelector(allbtns[t][e].tabselector),j=0;j<allviewmorebtns[t].length;j++)allviewmorebtns[t][j].style.display="none";allviewmorebtns[t][s].style.display="block",status=allbtns[t][e].status,showViewBtn(allbtns[t][e].btnname,allbtns[t])}console.dir(this)})}),clienttablinks[0].click(),writertablinks[0].click();var fastars=document.querySelectorAll("#reviewform .fa"),ratingvalel=document.getElementById("ratingval"),ordernameval=document.getElementById("name"),orderidval=document.getElementById("id"),reviewformcontainerel=document.getElementById("reviewformcontainer");for(let i=0;i<fastars.length;i++)fastars[i].addEventListener("mouseover",function(e){for(let t=0;t<=i;t++)fastars[t].classList.remove("fa-star-o"),fastars[t].classList.add("fa-star");for(let n=fastars.length-1;n>i;n--)fastars[n].classList.remove("fa-star"),fastars[n].classList.add("fa-star-o");ratingvalel.value=i+1});function displayReview(){var e=document.getElementById("ordersubstatus").innerText,t=document.getElementById("orderrating").innerText,n=document.getElementById("orderclientemail").innerText;"Order Completed"==e&&""==t&&n==clientemail?reviewformcontainerel.style.display="":reviewformcontainerel.style.display="none"}function submitReview(){var e=document.getElementById("reviewform"),t=document.getElementById("reviewformbtn"),n=new FormData(e,t),s=["rating","review","gen"];xhttp.onload=function(){let t=JSON.parse(xhttp.responseText);s.forEach(function(e,n,s){document.getElementById(e).innerText="",e in t&&(console.log(e),document.getElementById(e).innerText=t[e])}),void 0!=t.success&&(e.innerText=t.success),console.log(t)},xhttp.open("POST","<?=HOME?>/requests/orders.php"),xhttp.send(n)}
</script>
<?php include "../app/excelwrite/incs/footer.php"?>