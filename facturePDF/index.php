<?php
require('facturePDF.php');

include 'database.php';
$pdo = Database::connect();

$test =  $_POST['test'];

$taille =count($test);



$nom = $_POST['nom'];
$adress = $_POST['adress'];
$mail = $_POST['mail'];



$adresse = "BURRO-NET\n2 bis rue Sébastien Bonay\n66400 Céret\n\nCONTACT@BURRO-NET.COM\n(+33) 4 68 82 73 20 (+49) 30 982 891 65";


$adresseClient = "".$nom."\n".$adress."\n".$mail."";

$pdf = new facturePDF($adresse, $adresseClient, "2 bis rue Sébastien Bonay - 66400 Céret - CONTACT@BURRO-NET.COM - (+33) 4 68 82 73 20 (+49) 30 982 891 65");

$pdf->setLogo('o-logo52-96.jpeg');
// entete des produits
$pdf->productHeaderAddRow('Type du Produit', 85, 'L');
$pdf->productHeaderAddRow('zone', 45, 'C');
$pdf->productHeaderAddRow('Prix HT', 35, 'C');

// entete des totaux
$pdf->totalHeaderAddRow(40, 'L');
$pdf->totalHeaderAddRow(30, 'R');
// element personnalisé
$pdf->elementAdd('', 'traitEnteteProduit', 'content');
$pdf->elementAdd('', 'traitBas', 'footer');




// #2 Créer une facture
//
// numéro de facture, date, texte avant le numéro de page
$pdf->initFacture("Facture n° ".mt_rand(1, 99999)."-".mt_rand(1, 99999), "Céret le ".date("d.m.y")."");
for($i = 0 ; $i < $taille ; $i++){

	$sqlz = 'SELECT DISTINCT zone.zone , zone.id_zone FROM `zone` JOIN prestation ON zone.id_zone = prestation.zone WHERE id_ajout = "'.$test[$i].'"'; 		
	foreach ($pdo->query($sqlz) as $row) {
		$zonez = $row['zone'];
		$id_zone = $row['id_zone'];

		$sql2 = 'SELECT * FROM prestation WHERE id_ajout = "'.$test[$i].'"';
			foreach ($pdo->query($sql2) as $row) {
          		$type = $row['type'];            
          		$prixpa = $row['prix'];
          		$prix_finalpa = $row['prixttc'];
          		$prix += $prixpa;
          		$prix_final += $prix_finalpa;
          		if(empty($prix)){
        			$prix_final = 0;
    			}
				$pdf->productAdd(array($type , $zonez , $prixpa));
			}
	}
}

$pdf->totalAdd(array($prix.' euro', 'prix HT'));
$pdf->totalAdd(array($prix_final. ' euro', 'prix TTC'));

require('gabarit'.intval($_GET['id']).'.php');

$pdf->buildPDF();

$pdf->Output('Facture.pdf', $_GET['download'] ? 'D':'I');

?>

