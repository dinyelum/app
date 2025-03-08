<h2>Para Jogos Grátis</h2>
<p>Você pode obter jogos grátis na <a href='<?=HOME?>'>página inicial</a> do nosso site, nossa <a href='<?=free_games_link()?>'>página de previsões de fim de semana</a>, nosso <a href='<?=TELEGRAM_CHANNEL_LINK?>'>canal de telegram</a> e nossa  <a href='<?=XLINK?>' target='_blank'>página no twitter</a>.</p>

<h2>Para Jogos VIP</h2>
<p>Primeiro, você precisa se registrar antes de pagar. <a href='<?=account_links('register')?>'>Clique aqui para se registrar</a></p>
<p>Depois de se registrar e ativar sua conta,</p>
<ul>
<li>Os nigerianos podem conferir todos os detalhes dos planos e seus preços em Naira consultando a <a href='<?=support_links('prices')?>'>página de preços</a>.</li>
<li>Para não nigerianos, você pode <a href='<?=pay_links(currencies(USER_COUNTRY)['link'])?>'>clicar aqui</a> para ver os preços em sua moeda. Quando a página abrir, clique em MENU para abrir as Opções de Pagamento que estão disponíveis para o seu país.</li>
</ul>
<p><b>NB</b>: Você deve estar registrado antes de poder ver os preços em outras moedas.</p>
<p class='w3-xlarge w3-margin-top'>Após Pagamento:</p>
<ul>
<li>Se fez transferência direta, envie uma mensagem para <?=PHONE?> no Whatsapp/Telegram para ativar a sua conta. Você também pode  <a href='<?=support_links('mailus')?>'>email us</a> too.</li>
<li>Se você pagou online, sua conta é ativada automaticamente.</li>
</ul>
<p class='w3-xlarge w3-margin-top'>Assim que sua conta estiver ativada, Basta</p>
<ul>
<li>Clicar em <a href='<?=tips_links()?>'>DICA VIP</a></li>
<li>Quando a página abrir, Vá para o MENU</li>
<li>Clique no plano pelo qual você pagou</li>
</ul>

<p class='w3-xlarge'>Formas de Pagamento Disponíveis</p>
<p>Para Pagamentos Bancários, envie para:</p>
<p>NOME DA CONTA: <?=ACCTNAME?><br><br>
NÚMERO DA CONTA: <?=ACCTNUMBER?><br><br>
BANCO: <?=BANK?><br><br>
Código BIC / SWIFT: <?=SWIFTCODE?></p>

<p>Outras opções de pagamento são:</p>
<ul class='w3-ul w3-border-bottom'><li><?=implode('</li><li>', array_diff_key(all_payment_methods(), [0=>'remove']))?></li></ul>

<h2>Para Suporte</h2>
<p>Para entrar em contato conosco por qualquer motivo, consultas, anúncios, empregos etc, você pode <a href='<?=support_links('mailus')?>'>nos enviar um e-mail</a> OU você pode <a href='<?=support_links()?>'>clicar aqui</a> para verificar outros meios através dos quais você pode entrar em contato conosco.</p>

<p>Siga-nos no Twitter <a href="<?=XLINK?>" target="_blank">@<?=X?></a></p>
<p>Siga-nos no Instagram <a href="<?=IGLINK?>" target="_blank">@<?=IG?></a></p>

<h2>Aviso</h2>
<p>Por favor, saia deste site agora se as apostas desportivas forem proibidas no seu país ou se tiver menos de 18 anos.</p><br><br>
