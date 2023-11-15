<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
	<link   href="style.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
	<div class="row">
	<div class="col-md-8 col-md-offset-4">
	<h2>Ajout d'une prestation</h2>
	</div>
		<form action="ajout_sql.php" method="post" >
		<div class="col-md-2 col-md-offset-4">
			<select name="categorie"  class="form-control">
				<?php

					include 'database.php';
					$pdo = Database::connect();

					$sql = 'SELECT * FROM `categorie` ORDER BY `id_categorie` DESC';
					foreach ($pdo->query($sql) as $row) {
    					echo '<option value="' . $row['id_categorie'] . '">' . $row['categorie'] . '</option>';
					}

				?>
  			</select>
		</div>
		<div class="col-md-2 ">
			<select name="sous_categorie" class="form-control">
				<?php

					$pdo = Database::connect();

					$sql = 'SELECT * FROM `sous_categorie` ORDER BY `id_sous_categorie` DESC';
					foreach ($pdo->query($sql) as $row) {
    					echo '<option value="' . $row['id_sous_categorie'] . '">' . $row['sous_categorie'] . '</option>';
					}
					
				?>
			</select>
		</div>
		<div class="col-md-8 col-md-offset-4">
		<div class="form-group">
			<h4>type</h4>
   			<input type="text" name="type" required>
   		</div>
   		</div>
		<div class="col-md-2 col-md-offset-4">
			<select name="zone" class="form-control">
				<?php
					
					$pdo = Database::connect();

					echo '<option value="null" selected="yes">aucune zone </option>';
					$sql = 'SELECT * FROM `zone` ORDER BY `zone` ASC';
					foreach ($pdo->query($sql) as $row) {
    					echo '<option value="' . $row['id_zone'] . '">' . $row['zone'] . '</option>';
					}
					
				?>
			</select>
		</div>
   		<div class="col-md-8 col-md-offset-4">
		<div class="form-group">
   			<h4>prix</h4>
			<input type="number" name="prix" step="any" required>
			<span class="validity"></span>
		</div>
		</div>
   		<div class="col-md-8 col-md-offset-4">
		<div class="form-group">
   			<h4>tva</h4>
			<input type="number" name="tva" required>
		</div>
		</div>
   		<div class="col-md-8 col-md-offset-4">
   			<input type="submit" name="test" value= "Ajouter le service ou l'article" class="btn btn-default">
   		</div>
		</form>
		</div>
		<div class="col-md-8 col-md-offset-4">
		<h2> Ajout d'une categorie ou sous categorie</h2>
		</div>
		<div>
		<form action="ajout_sql.php" method="post">
			
		<div class="col-md-2 col-md-offset-4">
			<select name="ajout_categorie" class="form-control">
  				<option value="categorie" selected="yes" >Categorie</option>
  				<option value="sous_categorie" >Sous categorie</option>
  			</select>
		</div>

		<div class="col-md-8 col-md-offset-4">
		<div class="form-group">
			<h4>type</h4>
   			<input type="text" name="type1" required>
   		</div>
   		</div>
   		<div class="col-md-8 col-md-offset-4">
   		<input type="submit" name="test" value="Ajouter la categorie ou la sous_categorie" class="btn btn-default">
   		</div>
		</form>
		</div>
		<div class="col-md-8 col-md-offset-4">
		<h2>ajout d'une zone</h2>
		</div>
		<div>
		<form action="ajout_sql.php" method="post">
		<div class="col-md-8 col-md-offset-4">
			<h4>type</h4>
   			<input type="text" name="typez" required>
   		</div>
   		<div class="col-md-8 col-md-offset-4">
			<h4>prix</h4>
   			<input type="text" name="prixz" required>
   		</div>
   		<div class="col-md-8 col-md-offset-4">
   			<input type="submit" name="test" value="Ajouter la zone" class="btn btn-default">
   		</div>
		</form>
	</div>
	<div class="col-md-8 col-md-offset-4">
	<input type=button onclick=window.location.href='supression.php'; value=suppression class="btn btn-default"/>
	</div>
</body>