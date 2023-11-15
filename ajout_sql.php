<?php
require "database.php";
	
$bouton = $_POST['test'];

if($bouton == "Ajouter le service ou l'article") {

    $type = $_POST['type'];
    $prix = $_POST['prix'];
    $tva = $_POST['tva'];
    $zone = $_POST['zone'];
	$sous_categorie = $_POST['sous_categorie'];
	$categorie = $_POST['categorie'];
	

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if($zone != 'null'){
    	$sqlz = 'SELECT prix FROM zone WHERE id_zone = '.$zone.'';
    	foreach ($pdo->query($sqlz) as $row) {
			$prixz = $row['prix'];
		}
	}
	if($zone == 'null'){
		$zone = null;
	}

	$prix += $prixz; 

	$prixfinal = $prix*$tva/100;
	$prixfinal = $prix + $prixfinal;


	$sql = 'INSERT INTO prestation (type,prix,zone,sous_categorie,categorie,prixttc) VALUES (?,?,?,?,?,?)';
	$q = $pdo->prepare($sql);
	$q->execute(array($type,$prix,$zone,$sous_categorie,$categorie,$prixfinal)) ;

	Database::disconnect();
	header("Location: ajout.php");
       
}

if($bouton == "Ajouter la categorie ou la sous_categorie") {
    $categorie1 = $_POST['ajout_categorie'];
	$type1 = $_POST['type1'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($categorie1 == "categorie"){
       	$sql = "INSERT INTO categorie (categorie) VALUES (?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($type1)) ;
	}
	elseif($categorie1 == "sous_categorie"){
        $sql = "INSERT INTO sous_categorie (sous_categorie) VALUES (?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($type1)) ;

		Database::disconnect();
	}
}

if($bouton == "Ajouter la zone") {
    $typez = $_POST['typez'];
	$prixz = $_POST['prixz'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       	$sql = "INSERT INTO zone (zone,prix) VALUES (?,?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($typez,$prixz)) ;
}
    	
header("Location: ajout.php");

?>