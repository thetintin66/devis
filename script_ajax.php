
<?php

include 'database.php';
$pdo = Database::connect();

$var = $_POST['ma_variable'];

$tab = explode( ',', $var ) ;
$taille =count($tab);


for($i = 0 ; $i < $taille ; $i++){
    $sqlNULL = 'SELECT * FROM prestation WHERE id_ajout = "'.$tab[$i].'"';
    foreach ($pdo->query($sqlNULL) as  $row) {
    $zone = $row['zone'];    
     }

    $prixbdd = 'SELECT prix FROM prestation WHERE id_ajout = "'.$tab[$i].'"';
    foreach ($pdo->query($prixbdd) as  $row) {
        $prix = $row['prix'];
        $prix_final += $prix;
    }
    if(empty($prix)){
        $prix_final = 0;
    }
}
?>
<?=$prix_final?>
        
     
