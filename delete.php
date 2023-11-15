<?php

require 'database.php';
$id = 0;
     
if ( !empty($_GET['id'])) {
  $id = $_REQUEST['id'];
}
     
if ( !empty($_POST)) {
  $id = $_POST['id'];
         
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM prestation WHERE id_ajout = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
              
  Database::disconnect();
  header("Location: supression.php");         
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
 
<body>
    <div class="container">
      <div >
        <div class="col-md-4">
          <h3>supprimer l'objet </h3>
        </div>
        <div class="col-md-4">     
          <form action="delete.php" method="post">
            <div class="form-group row">
              <input type="hidden" name="id" value="<?php echo $id;?>"/>
              <p>voulez vous supprimer ?</p>
            </div>
            <div class="form-group row">
              <button type="submit" class="btn btn-default">Yes</button>
                <input type=button onclick=window.location.href='supression.php'; value=No class="btn btn-default"/>
            </div>
          </form>
        </div>    
      </div>     
    </div> 
  </body>
</html>
