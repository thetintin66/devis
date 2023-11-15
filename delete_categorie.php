<?php

require 'database.php';
$bouton = $_POST['bouton'];

if ($bouton == supprimer_la_categorie ) {
        
    $categorie = $_POST['categorie'];
         
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "DELETE FROM categorie WHERE id_categorie = ? ";
    $q = $pdo->prepare($sql);
    $q->execute(array($categorie));


      
}
if ($bouton == supprimer_la_sous_categorie ) {

    $sous_categorie = $_POST['sous_categorie'];
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM sous_categorie WHERE id_sous_categorie = ? ";
    $q = $pdo->prepare($sql);
    $q->execute(array($sous_categorie));


}
if ($bouton == supprimer_la_zone ) {

    $zone = $_POST['zone'];
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM zone WHERE id_zone = ? ";
    $q = $pdo->prepare($sql);
    $q->execute(array($zone));

      
}

Database::disconnect();
header("Location: supression.php");
    
?>
 