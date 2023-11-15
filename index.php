<!DOCTYPE html>
<html>
<head>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script> 

setInterval(recupValeurs, 750);


function recupValeurs() {

var cases = document.getElementsByName('test[]');
var resultat = [];
     for (var i = 0; i < cases.length; i++) {
        if (cases[i].checked) {    
           resultat += cases[i].value  + ",";
        }
    }

$.post("script_ajax.php", { ma_variable: resultat }, function(data) {
     $("#retour_ajax").html(" ");

      $("#retour_ajax").append("prix : " + data + " €");  
});


}



</script> 
</head>
<body>
<form action="/ajout/facturePDF/index.php" target="_blank" method="post">
<div class="form-group">
<?php

include 'database.php';
  $pdo = Database::connect();

$minimum = 'SELECT id_categorie FROM categorie WHERE id_categorie = (SELECT MIN(id_categorie) FROM categorie)';

$maximum ='SELECT id_categorie FROM categorie WHERE id_categorie = (SELECT MAX(id_categorie) FROM categorie)';

foreach ($pdo->query($maximum) as $row) {
    $max = $row['id_categorie'];
}

foreach ($pdo->query($minimum) as $row) {
    $min = $row['id_categorie'];
}

$maximum1 ='SELECT id_sous_categorie FROM sous_categorie WHERE id_sous_categorie = (SELECT MAX(id_sous_categorie) FROM sous_categorie)';

$minimum1 ='SELECT id_sous_categorie FROM sous_categorie WHERE id_sous_categorie = (SELECT MIN(id_sous_categorie) FROM sous_categorie)';

foreach ($pdo->query($minimum1) as $row) {
    $min1 = $row['id_sous_categorie'];
}

foreach ($pdo->query($maximum1) as $row) {
	$max1 = $row['id_sous_categorie'];
}


$max1 = $max1;
$min1 = $min1; 

$max = $max;
$min_int = $min;

for($min_int = $min_int; $min_int <= $max; $min_int++){

	$sql = 'SELECT * FROM `categorie` WHERE id_categorie = '.$min_int.' ';
    foreach ($pdo->query($sql) as $row) {
      	echo '<table  class="table table-bordered">';
      	echo '<thead>';
        echo '<tr>';
        echo '<th>'. $row['categorie'] . '</th>';
        echo '</tr>';
        echo '</thead>';
      	echo '<tr>';
      	echo '<td>';
      
          

      	$min_str = (string) $min_int;
      	$sql1 = 'SELECT DISTINCT prestation.sous_categorie,sous_categorie.sous_categorie,sous_categorie.id_sous_categorie  FROM `prestation`  
		JOIN sous_categorie ON prestation.sous_categorie = sous_categorie.id_sous_categorie
		WHERE categorie = '.$min_str.'';
            
      	foreach ($pdo->query($sql1) as $row) {
        	$sc = $row['id_sous_categorie'];
        	echo '<table class="table table-bordered">';
          	echo '<tr>';
          	echo '<td>'. $row['sous_categorie'] . '</td>';
          	echo'</tr>';
          	echo '<tr>';
                

            $sqlz = 'SELECT DISTINCT zone.zone , zone.id_zone FROM `zone` JOIN prestation ON zone.id_zone = prestation.zone WHERE categorie = '.$min_str.' AND sous_categorie = '.$sc.''; 
                
            foreach ($pdo->query($sqlz) as $row) {
                $zonez = $row['zone'];
                $id_zone = $row['id_zone'];
                if(!empty($zonez)){
                    echo '<tr>';
                    echo '<td>';
                    echo '<table class="table table-bordered">';
                    echo '<tr>';
                    echo '<th>'.$zonez.'</th>';
                    echo '</tr>';
                     $sql2 = 'SELECT * FROM prestation WHERE categorie = '.$min_str.' AND sous_categorie = '.$sc.' AND zone = '.$id_zone.' ';
                    foreach ($pdo->query($sql2) as $row) {
                        echo '<tr>';
                        echo '<td>';
                        echo '<input type="checkbox" name="test[]" class="'.$row['id_ajout'] .'" id="'. $row['id_ajout'] .'" value="'. $row['id_ajout'] . ' '. $zonez . '">';
                        echo'<label for="'.$row['id_ajout'] .'">'. $row['type'] . ' '. $row['prix'] . '€ ht </label>';
                        echo '</td>';
                        echo '</tr>';
                    }
                echo '</table>';
                echo'</td>';
                echo '</tr>';
                }   
            }

            $sql2 = 'SELECT * FROM prestation WHERE categorie = '.$min_str.' AND sous_categorie = '.$sc.' AND zone IS NULL ';
            foreach ($pdo->query($sql2) as $row) {
                echo '<tr>';
                echo '<td>';
                echo '<input type="checkbox" name="test[]" class="'.$row['id_ajout'] .'" id="'. $row['id_ajout'] .'" value="'. $row['id_ajout'] . ' '. $zonez . '">';
                echo'<label for="'.$row['id_ajout'] .'">'. $row['type'] . ' '. $row['prix'] . '€ ht </label>';
                echo '</td>';
                echo '</tr>';

            }
        echo '</tr>';
        echo '</td>';
        echo '</table>';
    	} 
    echo '</tr>';
    echo '</td>';
    echo '</table>';    
    }
echo '</tr>';
echo '</td>';
}
?>
</div>
<div class="row">

<div  class="col-md-1 col-md-offset-4 ">
    <h4 size="1" class="text-left" id="retour_ajax" name="ajax" ></h4>
</div> 


<form class="form-inline">
<div class="form-group">
<div class="col-md-4 ">
        <h4>nom / prenom</h4>
        <input type="text" name="nom" required>


        <h4>adresse + ville </h4>
        <input type="text" name="adress" required>


        <h4>pour vous joindre(mail,numero de telephone)</h4>
        <input type="text" name="mail" required>
</div>
<div class="col-md-4 col-md-offset-5">
        <input type=submit value=devis class="btn btn-default"/>

</div>
</div>
</form>
</body>
</html>