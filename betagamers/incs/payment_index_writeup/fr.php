<h1 style='color:green'>Options de paiement</h1>
<p>Veuillez cliquer sur votre option de paiement préférée dans le MENU ou <a href="/mailus.php" style='color:green'>Envoyez-nous un e-mail</a>.</p>

<p>Les options de paiement que vous pouvez voir sont les options disponibles pour le pays que vous avez choisi lors de votre inscription. Pour changer cela, veuillez <a href="/mailus.php" style='color:green'>nous envoyer un e-mail</a>.</p>

<h3 style='color:green'>TOUS LES PAIEMENTS SONT EFFECTUÉS À:</h3>
NOM DU COMPTE: <?=ACCTNAME?><br><br>
NUMÉRO DE COMPTE: <?=ACCTNUMBER?><br><br>
BANQUE: <?=BANK?><br><br>
BIC / SWIFT: <?=SWIFTCODE?><br><br>

<h3 style='color:green'>APRÈS AVOIR EFFECTUÉ LE PAIEMENT, ENVOYEZ-NOUS:</h3>
(1) TON NOM COMPLET (2) VOTRE ADRESSE EMAIL (3) Le montant payé (4) Plan d'abonnement<br><br>
Exemple: Charles Louis. louislucas@exemple.com. N12000. 3 mois Platine.<br><br>
AU <?=PHONE?> (via sms ou Whatsapp) ou <a href="<?=support_links('mailus')?>" style='color:green'>Envoyez-nous un e-mail</a>.<br><br>
<h3 style='color:green'>Méthodes de paiement disponibles</h3>
Parcourez la liste ci-dessous pour voir les différentes options de paiement disponibles:
<ul><li><?=implode('</li><li>', all_payment_methods())?></li></ul>

<p>Cliquez sur MENU pour voir les différentes options disponibles pour votre pays.</p>
<h3 style='color:green'>Attention:</h3>
<p>Les informations transmises sont destinées uniquement aux personnes de plus de 18 ans. BETAGamers ne rembourse pas l'argent payé pour l'abonnement et n'est pas responsable de l'argent gagné ou perdu. Les pays où les paris sportifs sont illégaux ne devraient souscrire à aucun de nos plans. Vous pouvez lire nos <a href="<?=support_links('terms')?>" target="_blank" style='color:green'>conditions générales</a> pour plus d'informations.</p>