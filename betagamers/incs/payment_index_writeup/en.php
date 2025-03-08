<h1 style='color:green'>Payment Options</h1>
<p>Please click on your preferred payment option in the MENU or <a href="<?=support_links('mailus')?>" style='color:green'>send us an email</a>.</p>

<p>The payment option you can see are the options available for the country you chose during registration. To change this, please <a href="<?=support_links('mailus')?>" style='color:green'>send us an email</a>.</p>

<h3 style='color:green'>ALL PAYMENTS SHOULD BE MADE TO:</h3>
ACCOUNT NAME: <?=ACCTNAME?><br><br>
ACCOUNT NUMBER: <?=ACCTNUMBER?><br><br>
BANK: <?=BANK?><br><br>
BIC / SWIFT Code: <?=SWIFTCODE?><br><br>

<h3 style='color:green'>AFTER MAKING PAYMENT, KINDLY SEND US:</h3>
(1) Your Full Name (2) Your Email Address (3) Amount Paid (4) Subscription Plan <br><br>
Example: Samuel Alison. samjoe@example.com. N12000. 3months Platinum.<br><br>
TO <?=PHONE?> (<?=PHONE_LOCALE?>) or <a href="<?=support_links('mailus')?>" style='color:green'>send us an email</a>.<br><br>
<h3 style='color:green'>Available Payment Methods</h3>
Go through the list below to see the differnt available payment options:
<ul><li><?=implode('</li><li>', all_payment_methods())?></li></ul>

<p>Click on MENU to see the different options available for your country.</p>
<h3 style='color:green'>DISCLAIMER:</h3>
<p>The information transmitted is intended only for the persons or entities above the age of 18. BETAGamers do not refund cash paid for subscription except on a few occasions(listed on our terms) and is not liable to any money gained or lost. Countries where sports betting is illegal should not subscribe to any of our plans. You can read through our <a href="<?=support_links('terms')?>" target="_blank" style='color:green'>Terms and conditions</a> for more information.</p>