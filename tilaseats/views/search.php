<h1>Search Results for '<?=$data['search']?>'</h1>
<div class=container id=container><?php
    if(is_array($data['fooddata']) && count($data['fooddata'])) {
        foreach ($data['fooddata'] as $key => $val) {
            food_card($val);
        }
    } else {
        exit('Search term not found');
    }?>
</div>
<div class='container searchnums center'><?php
    if($data['totalpages']>1) {
        for($i=1; $i<=$data['totalpages']; $i++) {
            echo "<span class='clickable pagebtn' onclick='viewPage($i)'>$i</span>";
        }
    }?>
</div>
<script src='./assets/js/gen.js'></script>
<script>
    var limit = <?=$data['perpage']?>;
    var search = '<?=$data['search']?>';
    var containerid = document.getElementById('container');
    var pagebtns = document.getElementsByClassName('pagebtn');
    pagebtns[0].onclick = null;
    pagebtns[0].className += ' disabled';
    function viewPage(offset) {
        var pagenum = event.target;
        offset = (offset-1)*limit;
        xhttp.onload = function() {
            // const resp = xhttp.responseText;
            const resp = JSON.parse(xhttp.responseText);
            // console.log(resp);
            if(resp.response=='success') {
                // console.log(resp.data);
                // console.log(food_card(resp.data[0]));
                for(let i=0; i<resp.data.length; i++) {
                    if(i==0) {
                        containerid.innerHTML = food_card(resp.data[0]);
                    } else {
                        containerid.innerHTML += food_card(resp.data[i]);
                    }
                }
                for(let i=0; i<pagebtns.length; i++) {
                    if(pagebtns[i].onclick==undefined) {
                        pagebtns[i].setAttribute('onclick', 'viewPage('+(i+1)+')');
                        pagebtns[i].classList.remove('disabled');
                    }
                }
                pagenum.onclick = null;
                pagenum.className += ' disabled';
            }
        }
        xhttp.open('GET', './requests/loadmore.php?section=food&offset='+offset+'&limit='+limit+'&search='+search);
        xhttp.send();
    }
    
    function food_card(values) {
        var amt = values.discount != null ? '<s>'+values.amount+'</s> '+values.discount : values.amount;
        var btn = values.session != undefined ? "<button class='right disabled'><i class='fa fa-shopping-cart'></i> <i class='fa fa-check'></i></button>" : "<button class=right onclick=addToCart("+values.id+")>Add to Cart</button>";
        return "<div class='foodcard left'>\
        <div class=foodcardimg>\
            <img src='./images/"+values.image+"' alt='"+values.imagealt+"'>\
        </div>\
        <div class=foodcardtxt>\
            <p>"+values.name+"</p>\
            <p>"+values.short_desc+"</p>\
            <p class=container>\
                <span class=left>&#8358;"+amt+"</b></span>\
                <span class=addcartbtn"+values.id+">"+btn+"\
                </span>\
            </p>\
        </div>\
    </div>";
}
</script>