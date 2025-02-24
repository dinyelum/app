<div class="w3-container w3-hide-small" style='width:100%; height:auto'>
   <div class="w3-row w3-stretch" style="background:#f5f8fb;">
      <h3 class="w3-center"><a href="<?=HOME?>" class="w3-hover-none" style="text-decoration:none; color:green;">BETAGamers.Net</a></h3>
   </div>
   <div class="w3-row w3-stretch">
      <div class="w3-bar w3-padding-8 topnav">
         <div class="w3-dropdown-hover">
            <button class="topbtn">
               <picture>
                  <source srcset="/images/<?=strtolower($data['header']['langs'][LANG]['text'])?>.webp" type="image/webp" width='28' height='28'>
                  <img src="/images/<?=strtolower($data['header']['langs'][LANG]['text'])?>.png" alt="<?=$data['header']['langs'][LANG]['text']?>" width='28' height='28'>
               </picture>
               <?=$data['header']['langs'][LANG]['text']?><i class="fa fa-caret-down" style="font-size:20px; padding-left: 5px"></i>
            </button>
            <div class="w3-dropdown-content w3-bar-block w3-border" style="left:0;"><?php
               foreach($data['header']['langs'] as $key=>$val) {
                  if($key==LANG) continue?>
                  <a href="https://<?=$key!='en' ? "$key." : ''?>betagamers.net" class="w3-bar-item w3-button">
                     <picture>
                        <source srcset="/images/<?=strtolower($val['text'])?>.webp" type="image/webp" width='28' height='28'>
                        <img src="/images/<?=strtolower($val['text'])?>.png" alt="<?=$val['text']?>" width='28' height='28'>
                     </picture>
                     <?=$val['locale']?>
                  </a><?php
               }?>
            </div>
         </div>
         <div class="w3-dropdown-hover w3-right">
            <button class="topbtn"><?=$data['header']['navlinks']['sports']['text']?> <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-border" style="right:0;"><?php
               foreach($data['header']['navlinks']['sports'] as $mixed=>$val) {
                  if($mixed=='text') continue?>
                  <a href="<?=$val['link']?>" class="w3-bar-item w3-button"><?=$val['text']?><i class='<?=$val['icon']?> w3-right'></i></a><?php
               }?>
            </div>
         </div><?php
         foreach($data['header']['navlinks'] as $key=>$val) {
            if($key=='sports') continue?>
            <a href="<?=$val['link']?>" class="w3-bar-item w3-right <?=isset($this->activepage) && $this->activepage==$key ? 'w3-active' : ''?>"><?=$val['text']?></a><?php
         }?>
      </div>
   </div>
</div>

<div class="w3-container topnav w3-hide-medium w3-hide-large">
   <div class="w3-bar w3-padding-16">
      <div class="w3-col s8 smallest">
         <h3 class="w3-bar-item w3-right"><a href="/" class="nohover" style="text-decoration:none">BETAGamers.Net</a></h3></div>
         <div class="w3-col s4 smallest">
            <div class="w3-border-left w3-dropdown-hover w3-right">
               <button class="topbtn">
                  <picture>
                     <source srcset="/images/english1.webp" type="image/webp" width='28' height='28'>
                     <img src="/images/english1.png" alt="English" width='28' height='28'>
                  </picture>
                  <?=strtoupper(key($data['header']['langs']))?><i class="fa fa-caret-down" style="font-size:20px; padding-left: 5px"></i>
               </button>
               <div class="w3-dropdown-content w3-bar-block w3-border" style="right:0;"><?php
                  foreach($data['header']['langs'] as $key=>$val) {
                     if($key==LANG) continue?>
                     <a href="https://<?=$key!='en' ? "$key." : ''?>betagamers.net" class="w3-bar-item w3-button">
                        <picture>
                           <source srcset="/images/<?=strtolower($val['text'])?>.webp" type="image/webp" width='28' height='28'>
                           <img src="/images/<?=strtolower($val['text'])?>.png" alt="<?=$val['text']?>" width='28' height='28'>
                        </picture>
                        <?=$val['locale']?>
                     </a><?php
                  }?>
               </div>
            </div>
         </div>
   </div>
   <div class="w3-center w3-mobile">
      <div class="w3-bar w3-padding-16"><?php
         foreach(array_reverse($data['header']['navlinks']) as $key=>$val) {
            if($key=='sports') continue?>
            <a href="<?=$val['link']?>" class="w3-bar-item <?=$this->activepage==$key ? 'w3-active' : ''?> smallest"><?=$val['text']?></a><?php
         }?>
         <div class="w3-dropdown-hover smallest">
            <button class="topbtn"><?=$data['header']['navlinks']['sports']['text']?> <i class="fa fa-caret-down"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-border" style="right:0;"><?php
               foreach($data['header']['navlinks']['sports'] as $mixed=>$val) {
                  if($mixed=='text') continue?>
                  <a href="<?=$val['link']?>" class="w3-bar-item w3-button"><?=$val['text']?><i class='<?=$val['icon']?> w3-right'></i></a><?php
               }?>
            </div>
         </div>
      </div>
   </div>
</div>