<?php include "../app/excelwrite/incs/header.php"?>
<div class=container style="background-color: #F7EBFF">
    <div class=textareacontainer>
        <h1>Letter Case Convert</h1>
        <textarea name="textinput" id="textinput"></textarea>
        <div class='displaycount conv'>
            <button id=upper>UPPER CASE</button>
            <button id=lower>lower case</button>
            <button id=sentence>Senctence case</button>
            <button id=title>Capitalized Case</button>
            <button id=removespace>Remove Double Spacing</button>
        </div>
    </div>
</div>

<script src='<?=HOME?>/assets/js/gen.js'></script>
<script>
var punctuations,ind,prev,misc,strarr,textinputid=document.getElementById("textinput"),buttons=document.getElementsByTagName("button"),counter=0,temptxt="";[...buttons].forEach(function(t){t.addEventListener("click",function(e){switch(t.id){case"upper":textinputid.value=textinputid.value.toUpperCase();break;case"lower":textinputid.value=textinputid.value.toLowerCase();break;case"sentence":punctuations=[".","!","?"],textinputid.value=textinputid.value.charAt(0).toUpperCase()+textinputid.value.slice(1),punctuations.forEach(function(t){for(ind=textinputid.value.indexOf(t);-1!==ind;){prev=textinputid.value.slice(0,ind+1),temptxt=misc="";for(let e=ind+1;e<=textinputid.value.length;e++){if(RegExp(/^\p{L}/,"u").test(textinputid.value.charAt(e))){temptxt=textinputid.value.charAt(e).toUpperCase()+textinputid.value.slice(e+1);break}misc+=textinputid.value.charAt(e)}textinputid.value=prev+misc+temptxt,ind=textinputid.value.indexOf(t,++ind)}});break;case"title":strarr=textinputid.value.toLowerCase().split(" ");for(var i=0;i<strarr.length;i++)strarr[i]=strarr[i].charAt(0).toUpperCase()+strarr[i].slice(1);textinputid.value=strarr.join(" ");break;case"removespace":textinputid.value=textinputid.value.replace(/ +/g," ")}})});
</script>
<?php include "../app/excelwrite/incs/footer.php"?>