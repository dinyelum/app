<div class=herocontainer>
    <img class=hidesmall src="<?=HOME?>/assets/images/chef.png" alt="Chef Image">
    <img class=hidebig src="<?=HOME?>/assets/images/chef2.png" alt="Chef Image">
    <div class='herosearch'>
        <form action="<?=htmlspecialchars(HOME.'/search')?>" >
            <div class='searchbox left'>
                <input type=search name=term value='' placeholder='Search...'>
            </div>
            <div class='searchbtn left'>
                <input type=submit name='' value=Search>
            </div>
        </form>
    </div>
</div>
<div class=topsection>
    <h2>TOP SALES</h2>
    <div class=container><?php
        foreach($data['fooddata'] as $ind=>$val) {
            if($ind > 8) {
                break;
            }
            if(isset($val['discount'])) {
                $discount = true;
            }
            if($val['salescount']>0) {
                $_SESSION['catfooter'][$ind] = $val;
                sales_card($val);
            }
        }?>
    </div>
</div><?php
if(isset($discount)) {?>
    <div class='container discsection'>
        <h2>SPECIAL PRICES</h2><?php
        foreach ($data['fooddata'] as $val) {
            if(isset($val['discount'])) {
                food_card($val);
            }
        }?>
    </div><?php
}?>
<div>
    <h2 class=center style='margin: 30px 0 5px'>CATEGORIES</h2>
    <div class=catsectioncolor>
        <div class='catsection container'><?php
            foreach($data['catdata'] as $val) {
                cat_card($val);
            }?>
        </div>
    </div>
</div>
<div>
    <h2 style='margin: 30px 0 5px'>The Best Food Website in Nigeria</h2>
    <div class='container eventsection'>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
            labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
            labore et dolore magna aliqua.</p>
        <div class='dynright'  id=slideshow>
            <div class="slideshow-container" style='width:400px;height:300px; background:#dfe3e6; overflow:hidden'><?php
                $number = 1;
                $total = count($data['slide_images']);
                foreach($data['slide_images'] as $key=>$val) {?>
                    <div class="mySlides fade">
                    <div class="numbertext"><?=$number.' / '.$total?></div>
                    <?=images($val, false)?>
                    <div class="text"><a href="#<?=$val['text']?>" style="text-decoration:none; color: white;"><?=$val['text']?></a></div>
                    </div><?php
                    $number++;
                }?>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div><br>
                    <div class='center'><?php
                    for($number = 1; $number <= $total; $number++){?>
                    <span class="dot" onclick="currentSlide(<?=$number?>)"></span><?php
                }?>
            </div>
        </div>
        <p class='accordion clickable'>Accordion 1</p>
        <p class=panel>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
            commodo consequat.</p> 
        <p class='accordion clickable'>Accordion 2</p>
        <p class=panel>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
            mollit anim id est laborum.</p>
        <p class='accordion clickable'>Accordion 3</p>
        <p class=panel>Volutpat ac tincidunt vitae semper quis lectus nulla. Pretium fusce id velit ut 
            tortor. Enim eu turpis egestas pretium. Tellus rutrum tellus pellentesque eu tincidunt 
            tortor aliquam nulla. Nisi quis eleifend quam adipiscing vitae proin sagittis. Sodales 
            ut eu sem integer.</p>
        <p class='accordion clickable'>Accordion 4</p>
        <p class=panel>Volutpat ac tincidunt vitae semper quis lectus nulla. Pretium fusce id velit ut 
            tortor. Enim eu turpis egestas pretium. Tellus rutrum tellus pellentesque eu tincidunt 
            tortor aliquam nulla. Nisi quis eleifend quam adipiscing vitae proin sagittis. Sodales 
            ut eu sem integer.</p>
        <p class='accordion clickable'>Accordion 5</p>
        <p class=panel>A erat nam at lectus urna duis convallis convallis tellus. Risus at 
            ultrices mi tempus. Ullamcorper eget nulla facilisi etiam dignissim diam quis enim 
            lobortis. Ut enim blandit volutpat maecenas volutpat. Eu sem integer vitae justo eget 
            magna fermentum iaculis eu. Dolor sit amet consectetur adipiscing elit duis tristique 
            sollicitudin nibh. Donec adipiscing tristique risus nec feugiat. Volutpat consequat 
            mauris nunc congue nisi vitae suscipit tellus. Dolor sit amet consectetur adipiscing elit duis tristique 
            sollicitudin nibh. Donec adipiscing tristique risus nec feugiat. Volutpat consequat 
            mauris nunc congue nisi vitae suscipit tellus Dolor sit amet consectetur adipiscing elit duis tristique 
            sollicitudin nibh. Donec adipiscing tristique risus nec feugiat. Volutpat consequat 
            mauris nunc congue nisi vitae suscipit tellus.</p>
    </div>
</div>

<script src='./assets/js/gen.js'></script>
<script>
    var heroclass = document.getElementsByClassName('foodcard');
    console.log('VH: '+document.body.clientHeight);
    console.log(heroclass[0].getBoundingClientRect());
    var slideIndex = 0;
    showSlides();
    j=0;
    var slides,dots,acc,rect;
    var panel = document.getElementsByClassName('panel');

    function showSlides() {
        var i;
        slides = document.getElementsByClassName("mySlides");
        dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex> slides.length) {slideIndex = 1}    
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 3000); // Change image every 8 seconds
    }

    function plusSlides(position) {
        slideIndex +=position;
        if (slideIndex> slides.length) {slideIndex = 1}
        else if(slideIndex<1){slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
    }

    function currentSlide(index) {
        if (index> slides.length) {index = 1}
        else if(index<1){index = slides.length}
        for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[index-1].style.display = "block";  
        dots[index-1].className += " active";
    }
    accordion();
    function accordion() {
        acc = document.getElementsByClassName('accordion');
        for(let i=0; i<acc.length; i++) {
            acc[i].addEventListener('click', function() {
                this.classList.toggle('active');
                var panel = this.nextElementSibling;
                if(panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                }
                adjustAccordion();
            });
        }
    }

    function adjustAccordion() {
        var slideshowid = document.getElementById("slideshow");
        var slideshowrect = slideshowid.getBoundingClientRect();
        for(let j=0; j<panel.length; j++) {
            panel[j].addEventListener('transitionend', function (event) {
                for(let k=0; k<acc.length; k++) {
                    rect = acc[k].getBoundingClientRect();
                    if(rect.top>slideshowrect.bottom) {
                        acc[k].style.width = '97%';
                    } else {
                        acc[k].style.width = '65%';
                        //console.log('not yet. Recttop'+k+' is: '+rect.top+'; Slideshowottom is: '+slideshowrect.bottom);
                    }
                }
            });
        }
    }
</script>