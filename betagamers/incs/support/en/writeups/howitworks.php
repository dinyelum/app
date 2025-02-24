<h2>For Free Games</h2>
<p>You can get free games from the <a href='<?=HOME?>'>homepage</a> of our website, our <a href='<?=free_games_link()?>'>free weekend forecasts page</a>, our <a href='<?=TELEGRAM_CHANNEL_LINK?>'>telegram channel</a> and our <a href='<?=XLINK?>' target='_blank'>twitter page</a>.</p>

<h2>For VIP Games</h2>
<p>First, you need to register before paying. <a href='<?=account_links('register')?>'>Click here to register</a></p>
<p>Then after registering and activating your account,</p>
<ul>
<li>Nigerians can check the full details of plans and their prices in Naira by checking the <a href='<?=support_links('prices')?>'>prices page</a>.</li>
<li>For Non Nigerians, you can <a href='<?=pay_links(currencies(USER_COUNTRY)['link'])?>'>click here</a> to view prices in your currency. When the page opens, click on MENU to open the Payment Options that are available for your country.</li>
</ul>
<p><b>NB</b>: You must be registered before you can view prices in other currencies.</p>
<p class='w3-xlarge w3-margin-top'>After Payment:</p>
<ul>
<li>If you made direct transfer, send a message to +2348157437268 on Whatsapp / Telegram to activate your account. You can also <a href='<?=support_links('mailus')?>'>email us</a> too.</li>
<li>If you paid online, your account is automatically activated.</li>
</ul>
<p class='w3-xlarge w3-margin-top'>Once your account has been activated, Just</p>
<ul>
<li>Click on <a href='<?=tips_link()?>'>VIP TIPs</a></li>
<li>When the page opens, Go to MENU</li>
<li>Click on the Plan you paid for the plan you paid for</li>
</ul>

<p class='w3-xlarge'>Available Payment Methods</p>
<p>For Bank Payments, send to:</p>
<p>ACCOUNT NAME: <?=ACCTNAME?><br><br>
ACCOUNT NUMBER: <?=ACCTNUMBER?><br><br>
BANK: <?=BANK?><br><br>
BIC / SWIFT Code: <?=SWIFTCODE?></p>

<p class='w3-xlarge'>Other payment options are:</p>
<ul class='w3-ul w3-border-bottom'><li><?=implode('</li><li>', array_diff_key(all_payment_methods(), [0=>'remove']))?></li></ul>

<h2>For Support</h2>
<p>To contact us for any reason, inquiries, adverts, jobs etc, you can <a href='<?=support_links('mailus')?>'>email us</a> OR you can <a href='<?=support_links()?>'>click here</a> to check other means through which you can contact us.</p>

<p>Follow us on Twitter <a href="<?=XLINK?>" target="_blank">@<?=X?></a></p>
<p>Follow us on Instagram <a href="<?=IGLINK?>" target="_blank">@<?=IG?></a></p>

<h2>Warning</h2>
<p>If sports betting is illegal in your country OR you are below 18 years old, please leave this site now.</p><br><br>