<h2>Para los juegos gratuitos</h2>
<p>Puedes conseguir juegos gratis en la <a href='<?=HOME?>'>página principal</a> de nuestro sitio web, en nuestra <a href='<?=free_games_link()?>'>página de pronósticos gratuitos de fin de semana</a>, en nuestro <a href='<?=TELEGRAM_CHANNEL_LINK?>'>canal de telegram</a> y en nuestro <a href='<?=XLINK?>' target='_blank'>página de twitter</a>.</p>

<h2>Para los juegos VIP</h2>
<p>En primer lugar, debes registrarse antes de pagar. <a href='<?=account_links('register')?>'>Haz clic aquí para registrarse</a></p>
<p>Después de registrarte y activar tu cuenta,</p>
<ul>
<li>Los nigerianos pueden consultar todos los detalles de los planes y sus precios en nairas en la <a href='<?=support_links('prices')?>'>página de precios</a>.</li>
<li>Para los no nigerianos, pueden <a href='<?=pay_links(currencies(USER_COUNTRY)['link'])?>'>hacer clic aquí</a> para ver los precios en su moneda. Cuando se abra la página, haz clic en el MENÚ para abrir las opciones de pago disponibles para tu país.</li>
</ul>
<p><b>Nota</b>: Debes estar registrado para poder ver los precios en otras monedas.</p>
<p class='w3-xlarge w3-margin-top'>Después del pago:</p>
<ul>
<li>Si has hecho una transferencia directa, envía un mensaje al <?=PHONE?> en Whatsapp / Telegram para activar tu cuenta. También puedes <a href='<?=support_links('mailus')?>'>enviarnos un correo electrónico</a>.</li>
<li>Si has pagado en línea, tu cuenta se activa automáticamente.</li>
</ul>
<p class='w3-xlarge w3-margin-top'>Una vez activada tu cuenta, sólo tienes que:</p>
<ul>
<li>Hacer clic en <a href='<?=tips_links()?>'>VIP</a></li>
<li>Cuando se abra la página, ve a MENÚ</li>
<li>Haz clic en el Plan que pagó</li>
</ul>

<p class='w3-xlarge'>Métodos de pago disponibles</p>
<p>Para los pagos bancarios, envía:</p>
<p>NOMBRE DE LA CUENTA: <?=ACCTNAME?><br><br>
NÚMERO DE CUENTA: <?=ACCTNUMBER?><br><br>
BANCO: <?=BANK?><br><br>
Código BIC / SWIFT: <?=SWIFTCODE?></p>

<p>Otras opciones de pago:</p>
<ul class='w3-ul w3-border-bottom'><li><?=implode('</li><li>', array_diff_key(all_payment_methods(), [0=>'remove']))?></li></ul>

<h2>Soporte</h2>
<p>Para ponerse en contacto con nosotros por cualquier motivo, consultas, anuncios, trabajos, etc., puedes <a href='<?=support_links('mailus')?>'>enviarnos un correo electrónico</a> o puedes <a href='<?=support_links()?>'>hacer clic aquí</a> para comprobar otros medios a través de los cuales puedes ponerte en contacto con nosotros.</p>

<p>Síguenos en Twitter <a href="<?=XLINK?>" target="_blank">@<?=X?></a></p>
<p>Síguenos en Instagram <a href="<?=IGLINK?>" target="_blank">@<?=IG?></a></p>

<h2>Advertencia</h2>
<p>Si las apuestas deportivas son ilegales en tu país o tienes menos de 18 años, abandona este sitio ahora.</p><br><br>