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

		$minimum1 = 'SELECT id_categorie FROM sous_categorie WHERE id_categorie = (SELECT MIN(id_categorie) FROM sous_categorie)';

		$maximum1 ='SELECT id_categorie FROM sous_categorie WHERE id_categorie = (SELECT MAX(id_categorie) FROM sous_categorie)';

		foreach ($pdo->query($maximum1) as $row) {
			$max1 = $row['id_categorie'];
		}

		foreach ($pdo->query($minimum1) as $row) {
			$min1 = $row['id_categorie'];
		}


		$max1 = (int) $max1;
		$min1 = (int) $min1;
		var_dump($min1);
		var_dump($max1);
		 

		$max = (int) $max;
		$min = (int) $min;
		var_dump($min);
		var_dump($max);
		 

			for($min = $min; $min <= $max; $min++){
				$sql = 'SELECT * FROM `categorie` WHERE id_categorie = '.$min.' ';
					foreach ($pdo->query($sql) as $row) {
						echo '<table>';
						echo '<tr>';
						echo '<td>'. $row['type'] . '</td>';
						echo '</tr>';
						echo '</table>';
						for($min1 = $min1; $min1 <= $max1; $min1++){
							$sql = 'SELECT * FROM `sous_categorie`
INNER JOIN prestation ON prestation.categorie = sous_categorie.id_categorie
WHERE prestation.categorie = '.$min.' ';
							foreach ($pdo->query($sql) as $row) {
								echo '<table>';
								echo '<tr>';
								echo '<td>'. $row['type'] . '</td>';
								echo '</tr>';
								echo '</table>';

							}
						}

					}
			}


?>