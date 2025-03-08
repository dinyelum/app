<h1>Opciones de pago </h1>
<p>Haga clic en su opción de pago preferida en el MENÚ o <a href="<?=support_links('mailus')?>">envíenos un correo electrónico</a>.</p>

<p>La opción de pago que puede ver son las opciones disponibles para el país que eligió durante el registro. Para cambiar esto, por favor <a href="<?=support_links('mailus')?>">envíenos un correo electrónico</a>.</p>

<h3>TODOS LOS PAGOS DEBEN HACERSE A:</h3>
NOMBRE DE LA CUENTA: <?=ACCTNAME?><br><br>
NÚMERO DE CUENTA: <?=ACCTNUMBER?><br><br>
BANCO: <?=BANK?><br><br>
For International Transfers, BIC / SWIFT Code: <?=SWIFTCODE?><br><br>

<h3>DESPUÉS DE REALIZAR EL PAGO, POR FAVOR ENVÍENOS:</h3>
(1) Su nombre completo (2) Su dirección de correo electrónico (3) Cantidad pagada (4) Plan de suscripción<br><br>

Ejemplo: Diego Alejandro. diegoalejandro@ejemplo.com. 32,4 USD. 3 meses Platino.<br><br>

AL <?=PHONE?> o <a href="<?=support_links('mailus')?>">envíenos un correo electrónico</a>.<br><br>

<h3>Métodos de pago disponibles</h3>
Revise la lista a continuación para ver las diferentes opciones de pago disponibles:

<ul><li><?=implode('</li><li>', all_payment_methods())?></li></ul>
<p>Haga clic en MENÚ para ver las diferentes opciones disponibles para su país.</p>

<h3>DESCARGO DE RESPONSABILIDAD:</h3>
<p>La información transmitida está destinada únicamente a las personas o entidades mayores de 18 años. BETAGamers no reembolsa el dinero pagado por la suscripción y no es responsable de ningún dinero ganado o perdido. Los países donde las apuestas deportivas son ilegales no deben suscribirse a ninguno de nuestros planes. Puede leer nuestros <a href="<?=support_links('terms')?>" target="_blank">Términos y condiciones</a> para obtener más información.</p>