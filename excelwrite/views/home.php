<?php include "../app/excelwrite/incs/header.php"?>
<div id=hero class='herocontainer'>
    <img src="<?=HOME?>/assets/images/excelwritehero.png" alt="">
    <div id=sequence>
    </div>
</div>
<section>
    <div class='container intro' style='display:flex'>
        <div class='dynleft justify'>
            <div class='section'>  
                <h2>Can an Expert Do My Assignment?</h2>
                <p style='margin-bottom:5%'>At Excelwrite, we link students with credible academic researchers with a range of specialisations. You'll enjoy all kinds of assignment writing help from top tier academic professionals including a discount for assignments with longer deadlines.</p>
                <p class='center getaquote'><button onclick="loadModal('ordermodal')">Get a Quote</button></p>
            </div>
            <div class='section' style='margin-top:4%'>
                <h2>Who we are?</h2>
                <p>We are a committed group of experts who are fired up about providing excellent writing services. You will get the best support for your academic needs because of our dedication to excellence.</p>
            </div>
        </div>
        <div class='dynright hidesmall'>
            <img src="<?=HOME?>/assets/images/we.svg" alt="" width=100% style=''>
        </div>
    </div>
    
    <div class='benefits section'>
        <h2 class=center>The Benefits You Enjoy</h2>
        <div class='container'>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-norobot.svg" alt="">
                    <p>Quality Writing, No AI</p>
                </div>
                <p>Our content is crafted by humans, not automated algorithms. You can always count on us for well-researched, original work tailored to your requirements.</p>
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p> -->
            </div>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-lamp.svg" alt="">
                    <p>Unlimited Revisions</p>
                </div>
                <p>Your satisfaction matters to us. We offer unlimited revisions to fine-tune and make your assignment the best it can be.</p>
            </div>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-calendar.svg" alt="">
                    <p>24/7 Availability</p>
                </div>
                <p>Need help at any hour? Our team here works round the clock to assist you with deadline bound assignments.</p>
            </div>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-clock-dollar.svg" alt="">
                    <p>Timely Submissions</p>
                </div>
                <p>We recognize the importance of deadlines. Count on us for punctual delivery.</p>
            </div>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-wallet.svg" alt="">
                    <p>Pocket-Friendly Services</p>
                </div>
                <p>Our affordable and dynamic pricing technique ensures that quality assistance won't strain your budget.</p>
            </div>
            <div class=left>
                <div class=benefitslist>
                    <img src="<?=HOME?>/assets/images/reshot-icon-confidential.svg" alt="">
                    <p>Confidentiality guarantee</p>
                </div>
                <p>Your privacy is our priority. Rest assured that your information is safe with us.</p>
            </div>
        </div>
    </div>
    
    <div class='section pojectssection'>
        <div class=projects>
            <h2>Projects Services We Offer</h2><?php
            $half = count($data['subjects']) / 2;?>
            <div class=listsection><?php
                foreach ($data['subjects'] as $ind=>$val) {
                    if($ind >= $half) {
                        break;
                        echo $ind;
                    }?>
                    <ul class='<?="list list$ind"?>'><?php
                        foreach($val as $subval) {?>
                            <li><?=$subval?></li><?php
                        }?>
                    </ul><?php
                }?>
                <ul></ul>
            </div>
            <div class=listsection><?php
                $i=0;
                foreach ($data['subjects'] as $ind=>$val) {
                    if($ind < $half) {
                        continue;
                    }?>
                    <ul class='<?="list list$i"?>'><?php
                        foreach($val as $subval) {?>
                            <li><?=$subval?></li><?php
                        }?>
                    </ul><?php
                    $i++;
                }?>
                <ul></ul>
            </div>
        </div>
        <!-- <p id=readmore style='padding:1%; border: 1px solid #000b58' class='clickable center'>Read More</p> -->
    </div>
    
    <!-- <div class=section>
        <h2>View Pricing</h2>
    </div> -->
    
    <div class='homepagecontactus section center'>
        <p>Looking for assignment writing services and confused about where to start from?</p>
        <p><a href='<?=HOME?>/support'><button>Contact Us</button></a></p>
    </div>

    <div class='section howitworks' id=howtoorder>
        <h2 class=center>How it Works</h2>
        <ol>
            <li>
                <div>
                    <h3>Fill Out The Order Form.</h3>
                    <p>Specify the number of pages, assignment deadline and upload the file containing the assignment you wish for us to help you complete.</p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Expert Contact.</h3>
                    <p>Expect a prompt response from one of our experts with the order details. You in turn, provide him / her with any additional instructions you'll like them to take into consideration.</p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Pay For Your Assignment.</h3>
                    <p>Choose from the various available payment methods and submit the required amount.</p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Stay In Touch With Your Expert.</h3>
                    <p>You can write to your expert to remind them about something essential or to track progress.</p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Download The Finished Work.</h3>
                    <p>Receive the first draft via email or WhatsApp. You can either approve it or request an edit.</p>
                </div>
            </li>
        </ol>
    </div><?php
    if(count($data['reviews']) > 0) {?>
        <div class='reviews section'>
            <h2 class=center style='color:#BC2D5C'>What our students say</h2>
            <!-- assigment, home work, essay, thesis, project etc -->
            <div class="slideshow-container">
                <div class=hidesmall><?php
                foreach($data['reviews'] as $ind=>$val) {
                    echo "<div class='mySlides1 fade reviewsgrid'>";
                    foreach($val as $subind=>$subval) {?>
                        <div class="reviewscontainer">
                            <p class=container><span class=left>User <?=bin2hex($subval['id'])?>XXX</span><span class=right><?=$subval['date']?></span></p>
                                <p><?=fa_fa_stars($subval['rating'])?></p>
                                <p><b><?=$subval['subject']?></b></p>
                                <p style='font-size: 15px; font-weight: lighter'><?=$subval['type'] ? $subval['type'] : 'Assignment'?>: <?=$subval['pages'].($subval['pages']==1 ? ' page':' pages')?>. Deadline: <?=$subval['deadline']?></p>
                                <p><?=$subval['review']?></p>
                        </div><?php
                        $dots = isset($dots) ? $dots + 1 : 1;
                    }
                    echo '</div><br>';
                }?>
                </div>
                <div class=hidebig><?php
                $flatarr = array_merge([], ...$data['reviews']);
                foreach($flatarr as $ind=>$val) {?>
                    <div class='mySlides2 fade reviewsgrid'>
                        <div class="reviewscontainer">
                            <p class=container><span class=left>User <?=bin2hex($val['id'])?>XXX</span><span class=right><?=$val['date']?></span></p>
                            <p><?=fa_fa_stars($val['rating'])?></p>
                            <p><b><?=$val['subject']?></b></p>
                            <p style='font-size: 15px; font-weight: lighter'><?=$val['type'] ? $val['type'] : 'Assignment'?>: <?=$val['pages'].($val['pages']==1 ? ' page':' pages')?>. Deadline: <?=$val['deadline']?></p>
                            <p><?=$val['review']?></p>
                        </div>
                    </div><?php
                }?>
                </div>
            </div>
            <div style='text-align:center'>
                <div class='dotsmobile'>
                    <?=str_repeat("<span class='dot'></span>", $dots)?>
                </div><br>
                <div class=dotsfull>
                    <?=str_repeat("<span class='dot'></span>", count($data['reviews']))?>
                </div>
            </div>
        </div><?php
    }?>
    <div class='writeup section'>
        <h2>The Best Assignment Writing Service</h2>
        <p>Every now and then, students of various institutions, universities, colleges, high schools, etc are burdened with several assignments which they must try to complete in order to get good grades. Some of these assignments are easy, some are a little bit more complex. On the part of the students, some may find these assignments easy, some may not, some maybe very busy, struggling with time managemment and may find it difficult to complete their assignments before the stipulated deadline, while some may outrightly find the assignments impossible; that is where ExcelWrite comes in. ExcelWrite is the best assignment writing service. We take pride in offering a wide array of academic writing services. Beyond essays and research papers, we assist with case studies, literature reviews, lab reports, presentations, and more. Our team of subject-matter experts covers various disciplines, ensuring that students receive specialized support tailored to their specific needs.</p>
        <p>Our commitment to quality is unwavering and our dedication to personalized assistance sets us apart. We meticulously review each assignment to ensure it meets academic standards. Our expert writers hold advanced degrees and have extensive experience in their respective fields. They conduct thorough research, cite credible sources, and adhere to formatting guidelines. Whether you’re an undergraduate or pursuing a postgraduate degree, our writers' deliveries are top-notch. When you choose Excelwrite, you’re not just getting a generic service. We engage with you to understand your requirements, preferences, and any specific instructions from your professors. Our communication channels remain open throughout the process, allowing you to ask questions, provide feedback, and collaborate with our team.</p>
        <h3>How Our Expert Assignments Transform Learning</h3>
        <p>Our assignments serve as powerful learning tools to help you:</p>
        <ul>
            <li>Understand formatting and structure by analyzing our well-written papers</li>
            <li>Explore research techniques through cited sources</li>
            <li>Discover new writing approaches by observing different styles.</li>
        </ul>
        <p>Our team of professionals is dedicated to producing exceptional content. We understand that a lot of students often operate on tight budgets. Excelwrite offers competitive pricing without compromising on quality. Our pricing structure ensures that you know what to expect upfront. Additionally, we provide discounts for first-time users and loyalty rewards for returning clients. We also offer discounted prices for assignments with longer deadlines. Affordable rates combined with exceptional service make us a trusted choice for students. We also understand the importance of deadlines. Excelwrite prioritizes timely delivery, allowing students to submit their assignments without stress. Our efficient workflow ensures that you receive your completed work well before the due date.</p>
        <p>So whether you’re searching for help with assignment or in need of cheap and affordabble homework help in the US or the UK, ExcelWrite Services is your best bet.</p>
    </div>
</section>

<script src='<?=HOME?>/assets/js/gen.js'></script>
<script>
let slideIndex=[1,1];let slideId=["mySlides1","mySlides2"];for(let i=0;i<slideId.length;i++){showSlides(0,i)}let dotsf=document.querySelectorAll(".dotsfull .dot");let dotsm=document.querySelectorAll(".dotsmobile .dot");let dots=[dotsf,dotsm];dots.forEach(function(item,ind){for(let i=0;i<item.length;i++){item[i].addEventListener('click',function(e){showSlides(slideIndex[ind]=i,ind)})}});function showSlides(n,no){let i;let x=document.getElementsByClassName(slideId[no]);if(n>=x.length){slideIndex[no]=0}if(n<1){slideIndex[no]=0}for(i=0;i<x.length;i++){x[i].style.display="none"}x[slideIndex[no]].style.display="grid"}showLettersOf(['ExcelWrite.com','Helping you do the hardwork'],document.querySelector('#sequence'));function showLettersOf(arrayOfStrings,el){var stringIndex=0,letterIndex=0,str="";return setInterval(function(){str+=arrayOfStrings[stringIndex].charAt(letterIndex++);el.innerHTML=str;if(letterIndex>=arrayOfStrings[stringIndex].length){letterIndex=0;str="";if(++stringIndex>=arrayOfStrings.length)stringIndex=0}},250)}
</script>
<?php include "../app/excelwrite/incs/footer.php"?>