<h2>Für kostenlose Spiele</h2>
<p>Du kannst kostenlose Spiele von der <a href='<?=HOME?>'>Startseite</a> unserer Website, unserer <a href='<?=free_games_link()?>'>Seite mit kostenlosen Wochenendvorhersagen</a>, unserem <a href='<?=TELEGRAM_CHANNEL_LINK?>'>Telegrammkanal</a> und unserer <a href='<?=XLINK?>' target='_blank'>Twitter-Seite</a>.</p>

<h2>Für VIP-Spiele</h2>
<p>Bevor Sie bezahlen können, müssen Sie sich registrieren. <a href='<?=account_links('register')?>'>Klicken Sie hier, um sich zu registrieren</a></p>
<p>Nachdem Sie sich registriert und Ihr Konto aktiviert haben,</p>
<ul>
<li>Nigerianer können die vollständigen Details der Pläne und ihre Preise in Naira auf der <a href='<?=support_links('prices')?>'>Seite mit den Preisen</a> einsehen.</li>
<li>Für Nicht-Nigerianer können Sie <a href='<?=pay_links(currencies(USER_COUNTRY)['link'])?>'>hier klicken</a> um die Preise in Ihrer Währung zu sehen. Wenn sich die Seite öffnet, klicken Sie auf MENÜ, um die Zahlungsoptionen zu öffnen, die für Ihr Land verfügbar sind.</li>
</ul>
<p><b>NB</b>: Sie müssen registriert sein, um die Preise in anderen Währungen einsehen zu können.</p>
<p class='w3-xlarge w3-margin-top'>Nach der Zahlung:</p>
<ul>
<li>Wenn Sie direkt übertragen haben, senden Sie eine Nachricht an +2348157437268 auf Whatsapp / Telegram, um Ihr Konto zu aktivieren. Sie können uns auch <a href='<?=support_links('mailus')?>'>eine E-Mail schicken</a>.</li>
<li>Wenn Sie online bezahlt haben, wird Ihr Konto automatisch aktiviert.</li>
</ul>
<p class='w3-xlarge w3-margin-top'>Sobald Ihr Konto aktiviert wurde, müssen Sie nur</p>
<ul>
<li>Klicken Sie auf <a href='<?=tips_links()?>'>VIP</a></li>
<li>Wenn sich die Seite öffnet, klicken Sie auf MENÜ</li>
<li>Klicken Sie auf den Plan, für den Sie bezahlt haben</li>
</ul>

<p class='w3-xlarge'>Verfügbare Zahlungsarten</p>
<p>Für Bankzahlungen, senden Sie an:</p>
<p>KONTONAME: <?=ACCTNAME?><br><br>
KONTONUMMER: <?=ACCTNUMBER?><br><br>
BANK: ACCESS <?=BANK?><br><br>
BIC / SWIFT-Code: <?=SWIFTCODE?></p>

<p>Andere Zahlungsmöglichkeiten sind:</p>
<ul class='w3-ul w3-border-bottom'><li><?=implode('</li><li>', array_diff_key(all_payment_methods(), [0=>'remove']))?></li></ul>

<h2>Support</h2>
<p>Um uns aus irgendeinem Grund zu kontaktieren, Anfragen, Anzeigen, Jobs usw., können Sie <a href='<?=support_links('mailus')?>'>uns eine E-Mail schicken</a> ODER Sie können <a href='index.php'>hier klicken</a> um andere Möglichkeiten zu prüfen, über die Sie uns kontaktieren können.</p>

<p>Folgen Sie uns auf Twitter <a href="<?=XLINK?>" target="_blank">@<?=X?></a></p>
<p>Folgen Sie uns auf Instagram <a href="<?=IGLINK?>" target="_blank">@<?=IG?></a></p>

<h2>Warnung</h2>
<p>Wenn Sportwetten in Ihrem Land illegal sind ODER Sie unter 18 Jahre alt sind, verlassen Sie bitte diese Seite jetzt.</p><br><br>