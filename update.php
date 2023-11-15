<?php
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
  
    if ( null==$id ) {
        header("Location: supression.php");
    }
     
    if ( !empty($_POST)) {

        // keep track post values
        $categorie = $_POST['categorie'];
        $sous_categorie = $_POST['sous_categorie'];
        $type = $_POST['type'];
        $zone = $_POST['zone'];
        $prix = $_POST['prix'];
        $pdo = Database::connect();

        if($zone == 'null'){
            $zone = null;
        }

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

        // validate input
        $valid = true;
        if (empty($type)) {
            $valid = false;
        }
         
        if (empty($prix)) {
      
            $valid = false;
         }

        // update data
        if ($valid) {

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE prestation SET categorie = ? , sous_categorie = ? , type = ? , zone = ? , prix = ? WHERE id_ajout = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($categorie,$sous_categorie,$type,$zone,$prix,$id)); 

            Database::disconnect();
            header("Location: supression.php");
        }
    } else {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "SELECT * FROM prestation where id_ajout = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        $prix = $data['prix'];
        $type = $data['type'];
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
        
    </head>
 
    <body>

        <div class="container">
            <form action="update.php?id=<?php echo $id?>" method="post">
                <div class="jumbotron">
                    <h1>update</h1>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-4">
                        <select name="categorie"  class="form-control">
                            <?php
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
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">type</label>
                            <div class="col-md-3">
                                <input name="type" type="text"  placeholder="type" value="<?php echo !empty($type)?$type:'';?>">
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
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">prix</label>
                            <div class="col-md-3">
                                <input name="prix" type="text" placeholder="prix" value="<?php echo !empty($prix)?$prix:'';?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a class="btn btn-info" href="index.php">Back</a>
                        </div>
                    </div><!-- /col -->
                </div>
            </form>
        </div> <!-- /row -->        
    </body>
</html>


