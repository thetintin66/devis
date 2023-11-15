<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
	<link   href="style.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
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


$max1 = (int) $max1;
$min1 = (int) $min1; 

$max = (int) $max;
$min_int = (int) $min;

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
                		echo '<td>'.$row['type'] .'<td>';
               			echo '<td>'.$row['prix'] .'€ ht<td>';
                		echo '<input type=button onclick=window.location.href="delete.php?id='.$row['id_ajout'].'"; value=suppression class="btn btn-default" />';
						echo '<input type=button onclick=window.location.href="update.php?id='.$row['id_ajout'].'"; value=update class="btn btn-default"/>';
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
                echo '<td>'.$row['type'] .'<td>';
                echo '<td>'.$row['prix'] .'€ ht<td>';
                echo '<input type=button onclick=window.location.href="delete.php?id='.$row['id_ajout'].'"; value=suppression class="btn btn-default" />';
				echo '<input type=button onclick=window.location.href="update.php?id='.$row['id_ajout'].'"; value=update class="btn btn-default"/>';
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

<form action="delete_categorie.php" method="post">
<div class="col-md-2 col-md-offset-1">
		<select name="categorie"  class="form-control">
			<?php
				
				$pdo = Database::connect();

				$sql = 'SELECT * FROM `categorie` ORDER BY `id_categorie` DESC';
				foreach ($pdo->query($sql) as $row) {
    				echo '<option value="' . $row['id_categorie'] . '">' . $row['categorie'] . '</option>';
				}

				$pdo = Database::disconnect();

			?>
  		</select>
  	</div>
  		<div class="col-md-2">
  		<input type="submit" name="bouton" value="supprimer_la_categorie" class="btn btn-default">
	</div>
</form>
<form action="delete_categorie.php" method="post">
	<div class="col-md-2 col-md-offset-1">
		<select name="sous_categorie" class="form-control" >
			<?php
				$pdo = Database::connect();

				$sql1 = 'SELECT * FROM `sous_categorie` ORDER BY `id_sous_categorie` DESC';
				foreach ($pdo->query($sql1) as $row) {
    				echo '<option value="' . $row['id_sous_categorie'] . '">' . $row['sous_categorie'] . '</option>';
				}

				$pdo = Database::disconnect();

			?>
  		</select>
  	</div>
  		 <div class="col-md-2">
  		<input type="submit" name="bouton" value="supprimer_la_sous_categorie" class="btn btn-default">
	</div>
</form>
<form action="delete_categorie.php" method="post">
	<div class="col-md-2 col-md-offset-1">
		<select name="zone" class="form-control" >
			<?php
				$pdo = Database::connect();

				$sql2 = 'SELECT * FROM `zone` ORDER BY `zone` DESC';
				foreach ($pdo->query($sql2) as $row) {
    				echo '<option value="' . $row['id_zone'] . '">' . $row['zone'] . '</option>';
				}

				$pdo = Database::disconnect();

			?>
  		</select>
  	</div>
  		 <div class="col-md-2">
  		<input type="submit" name="bouton" value="supprimer_la_zone" class="btn btn-default">
	</div>
</form>

	<div class="col-md-2 col-md-offset-5">
<input type=button onclick=window.location.href='ajout.php'; value=ajout class="btn btn-default"/>
</div>
</div>
</body>
</html>

 
