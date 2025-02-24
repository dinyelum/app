<?php include "../app/excelwrite/incs/header.php"?>
<div class=container style="background-color: #F7EBFF">
    <div class=textareacontainer>
        <h1>Word Counter</h1>
        <textarea name="textinput" id="textinput"></textarea>
        <div class=displaycount>
            <p>Word Count: <span id=wordcount></span></p>
            <p>Character Count: <span id=charactercount></span></p>
            <p>Sentence Count: <span id=sentencecount></span></p>
        </div>
    </div>
</div>
<script src='<?=HOME?>/assets/js/gen.js'></script>
<script>
var pressedkey,textinputid=document.getElementById("textinput"),wordcountid=document.getElementById("wordcount"),charactercountid=document.getElementById("charactercount"),sentencecountid=document.getElementById("sentencecount");function numberOfWords(e,t){let n=0,d=!1,i;i="sentences"==t?[".","?","!"]:[",","."," ","/","\\","(",")","[","]","{","}","+","=","&","`","?","!"];for(let u=0;u<e.length;u++)i.includes(e[u])||d||" "==e[u]?i.includes(e[u])&&(d=!1):(n++,d=!0);return n}textinputid.addEventListener("keyup",function(e){charactercountid.innerText=textinputid.value.length??0,wordcountid.innerText=numberOfWords(textinputid.value,"words")??0,sentencecountid.innerText=numberOfWords(textinputid.value,"sentences")??0}),window.addEventListener("load",function(e){charactercountid.innerText=textinputid.value.length??0,wordcountid.innerText=numberOfWords(textinputid.value,"words")??0,sentencecountid.innerText=numberOfWords(textinputid.value,"sentences")??0});

</script>
<?php include "../app/excelwrite/incs/footer.php"?>