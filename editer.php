<?php 
    //Sécurisation du fichier
    require_once("authentification/verif.php");
    require_once("connect.php");
    $title = "Mise à jour d'une voiture";

    //Afficher d'abord les données dans le formulaire

    //Condition de restriction
    if(isset($_GET["code"])){
        $code = $_GET["code"];

        //On affiche avant de modifier
        $sql = "SELECT * FROM voiture WHERE Id = ?";

        $res = mysqli_prepare($connect, $sql);

        mysqli_stmt_bind_param($res, "i", $code);

        $ok = mysqli_stmt_execute($res);

        //Résultat de la requete
        mysqli_stmt_bind_result($res, $id, $marque, $modele, $pays, $prix, $photo, $description, $da);

        //Affichage de donnée -> pas de boucle car on récupère une seule ligne
        mysqli_stmt_fetch($res);
    }

    // //Traitement pour la soumission
    if(isset($_POST["mise_a_jour"])){
        //var_dump($_POST);
        //var_dump($_FILES);
        //die();
        //Prendre un champs pour faire valider du coté serveur --> la photo
        if(isset($_POST) || isset($_FILES["photo"])){

            //Traitement de la photo 
            $file_name = $_FILES["photo"]["name"]; // --> recupère le nom de la photo
            $tmp_name = $_FILES["photo"]["tmp_name"]; // --> recupère le chemin de stockage temporaire
            $destination = "images/$file_name"; // --> nouveau chemin de stockage de l'image

            //on va déplacer l'image de l'emplacement temporaire à notre dossier image
            move_uploaded_file($file_name, $destination); //(nom de l'emplacement temporaire, la destination)

            $id = (int)htmlspecialchars(trim(addslashes($_POST["id"])));
            $marque = htmlspecialchars(trim(addslashes($_POST["marque"])));
            $modele = htmlspecialchars(trim(addslashes($_POST["modele"])));
            $pays = htmlspecialchars(trim(addslashes($_POST["pays"])));
            //Transtypage du prix en (double) comme dans la base de donnée
            $prix = (double)htmlspecialchars(trim(addslashes($_POST["prix"])));
            $description = trim(addslashes($_POST["description"]));
            $oldphoto = trim(addslashes($_POST["oldphoto"]));
            
            // Traitement pour image par défaut
            $photo = "";

            if($file_name){
                $photo = $file_name;
            }else{
                $photo = $oldphoto;
            }
        }
            
        //requete avec les paramètres -> "?"
        $sql = "UPDATE voiture SET marque = ?, modele = ?, pays = ?, prix = ?, photo = ?, description = ? WHERE Id = ? ";

        //préparation de la requête
        $res = mysqli_prepare($connect, $sql);

        //Liaison des paramètres (?) au données ($marque, etc...)
        mysqli_stmt_bind_param($res, "sssdssi", $marque, $modele, $pays, $prix, $photo, $description, $id);

        //Exécution de la requête
        $ok = mysqli_stmt_execute($res);

        //Vérification et notification de l'insertion
        if($ok){
            header("Location:listes.php");
        }else{
            echo"Erreur lors de la mise à jour...";
        }
    }
    require_once("partial/header.php");

?>
<h2>Mise à jour de la voiture : <?php echo $marque . " " . $modele ?></h2>
<br>
<!-- Ecrire le nombre de caractère attendu identique au nombre rentré dans la base de donnée -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="id"><b><span>*</span>Id</b></label>
            <input type="text" class="form-control" value="<?php echo $id?>" readonly name="id">
        </div>
        <div class="form-group col-md-6">
            <label for="marque"><b><span>*</span>Marque</b></label>
            <input type="text" id="marque" name="marque" class="form-control" placeholder="Entrez votre marque" value="<?php echo $marque ?>" maxlength="20">
        </div>
        <div class="form-group col-md-6">
            <label for="modele"><b><span>*</span>Modele</b></label>
            <input type="text" id="modele" name="modele" class="form-control" placeholder="Entrez votre modele" maxlength="20" value="<?php echo $modele; ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="pays"><b><span>*</span>Pays</b></label>
            <input type="text" id="pays" name="pays" class="form-control" placeholder="Entrez votre pays" maxlength="20" value="<?php echo $pays; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="prix"><b><span>*</span>Prix</b></label>
            <input type="number" id="prix" name="prix" class="form-control" placeholder="Entrez le prix" value="<?php echo $prix; ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="photo"><b><span>*</span>Photo</b></label>
            <img src="images/<?php echo $photo; ?>" alt="photo" srcset="" width="100" heigth="100">
            <input type="file" class="form-control-file" id="photo" name="photo"> 
             <!--Champs hidden afin de récupérer l'image par défaut   -->
             <input type="hidden" value="<?php echo $photo; ?>" name="oldphoto">
        </div>
        <div class="form-group col-md-12">
            <label for="description"><b><span>*</span>Description</b></label>
            <textarea class="form-control" id="description" rows="3" name="description" placeholder="Entrez votre description"> <?php echo $description;?></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-warning btn-lg btn-block" name="mise_a_jour">Mise à jour</button>
</form>

<?php 
    require_once("partial/footer.php");
?>
