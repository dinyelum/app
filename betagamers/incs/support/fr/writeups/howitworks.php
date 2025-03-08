<h2>Pour pronos gratuits</h2>
<p>Vous pouvez obtenir des pronos gratuits sur le <a href='<?=HOME?>'>page d'accueil</a> de notre site Web, notre <a href='<?=free_games_link()?>'>page de prévisions de week-end gratuite</a>, notre <a href='<?=TELEGRAM_CHANNEL_LINK?>'>canal de télégramme</a> et notre <a href='<?=XLINK?>' target='_blank'>page de twitter</a>.</p>

<h2>Pour pronos vip</h2>
<p>Tout d'abord, vous devez vous inscrire avant de payer. <a href='<?=account_links('register')?>'>Cliquez ici pour vous inscrire.</a></p>
<p>Après l'enregistrement et l'activation de votre compte,</p>
<ul>
<li>Les Nigérians peuvent vérifier tous les détails des plans et leurs prix en Naira en consultant <a href='<?=support_links('prices')?>'>la page de tarification</a>.</li>
<li>Pour les non Nigérians, vous pouvez <a href='<?=pay_links(currencies(USER_COUNTRY)['link'])?>'>cliquer ici</a> pour voir les prix dans votre devise. Lorsque la page s'ouvre, cliquez sur MENU pour ouvrir les options de paiement disponibles pour votre pays.</li>
</ul>
<p><b>NB</b>: Vous devez être enregistré avant de pouvoir consulter les prix dans des devises autres que le naira.</p>
<p class='w3-xlarge w3-margin-top'>Après le paiement:</p>
<ul>
<li>Si vous avez effectué un transfert direct, envoyez un message au <?=PHONE?> sur Whatsapp ou Telegram pour activer votre compte. Vous pouvez également <a href='<?=support_links('mailus')?>'>nous envoyer un e-mail</a>.</li>
<li>Si vous avez payé en ligne, votre compte est automatiquement activé.</li>
</ul>
<p class='w3-xlarge w3-margin-top'>Lorsque votre compte est activé, juste</p>
<ul>
<li>Cliquez sur <a href='<?=tips_links()?>'>Pronos VIP</a></li>
<li>Lorsque la page s'ouvre, cliquez sur MENU</li>
<li>Cliquez sur le plan pour lequel vous avez payé.</li>
</ul>

<p class='w3-xlarge'>Modes de paiement disponibles</p>
<p>Pour les paiements bancaires, payez à:</p>
<p>NOM DU COMPTE: <?=ACCTNAME?><br><br>
NUMÉRO DE COMPTE: <?=ACCTNUMBER?><br><br>
BANQUE: <?=BANK?><br><br>
Code BIC / SWIFT: <?=SWIFTCODE?></p>

<p>Les autres options de paiement disponibles sont:</p>
<ul class='w3-ul w3-border-bottom'><li><?=implode('</li><li>', array_diff_key(all_payment_methods(), [0=>'remove']))?></li></ul>

<h2>Pour le soutien</h2>
<p>Pour nous contacter pour quelque raison que ce soit, demandes de renseignements, annonces, emplois, etc., vous pouvez <a href='<?=support_links('mailus')?>'>nous envoyer un e-mail</a> OU vous pouvez <a href='<?=support_links()?>'>cliquer ici</a> pour voir les autres moyens de nous contacter.</p>

<p>Suivez-nous sur Twitter <a href="<?=XLINK?>" target="_blank">@<?=X?></a></p>
<p>Suivez-nous sur Instagram <a href="<?=IGLINK?>" target="_blank">@<?=IG?></a></p>

<h2>Avertissement</h2>
<p>Si les paris sportifs sont illégaux dans votre pays OU si vous avez moins de 18 ans, veuillez quitter ce site maintenant.</p><br><br>