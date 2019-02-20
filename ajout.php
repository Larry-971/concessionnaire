<?php 
    //Sécurisation du fichier
    require_once("authentification/verif.php");
    require_once("connect.php");
    $title = "Ajout de voiture";

    //Traitement pour la soumission
    if(isset($_POST["enregistrer"])){
        //var_dump($_POST);

        //Prendre un champs pour faire valider du coté serveur --> la marque
        if(isset($_POST) && isset($_FILES["photo"]) && !empty($_POST["marque"])){

            /* Traitement de la photo */
            $file_name = $_FILES["photo"]["name"]; // --> recupère le nom de la photo
            $tmp_name = $_FILES["photo"]["tmp_name"]; // --> recupère le chemin de stockage temporaire
            $destination = "images/$file_name"; // --> nouveau chemin de stockage de l'image

            //on va déplacer l'image de l'emplacement temporaire à notre dossier image
            move_uploaded_file($file_name, $destination); //(nom de l'emplacement temporaire, la destination)

            $marque = htmlspecialchars(trim(addslashes($_POST["marque"])));
            $modele = htmlspecialchars(trim(addslashes($_POST["modele"])));
            $pays = htmlspecialchars(trim(addslashes($_POST["pays"])));
            //Transtypage du prix en (double) comme dans la base de donnée
            $prix = (double)htmlspecialchars(trim(addslashes($_POST["prix"])));
            $description = trim(addslashes($_POST["description"]));
        }
    }
    
    //requete avec les paramètres -> "?"
    $sql = "INSERT INTO voiture(marque, modele, pays, prix, photo, description) VALUES(?,?,?,?,?,?)";

    //préparation de la requête
    $res = mysqli_prepare($connect, $sql);

    //Liaison des paramètres (?) au données ($marque, etc...)
    mysqli_stmt_bind_param($res, "sssdss", $marque, $modele, $pays, $prix, $file_name, $description);

    //Exécution de la requête
    $ok = mysqli_stmt_execute($res);

    //Vérification et notification de l'insertion
    if($ok){
        header("Location:listes.php");
    }else{
        echo"Erreur d'insertion...";
    }

    /**/



    require_once("partial/header.php");
?>
<h2>Ajout d'une voiture</h2>
<br>
<!-- Ecrire le nombre de caractère attendu identique au nombre rentré dans la base de donnée -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="marque"><b><span>*</span>Marque</b></label>
            <input type="text" id="marque" name="marque" class="form-control" placeholder="Entrez votre marque" maxlength="20">
        </div>
        <div class="form-group col-md-6">
            <label for="modele"><b><span>*</span>Modele</b></label>
            <input type="text" id="modele" name="modele" class="form-control" placeholder="Entrez votre modele" maxlength="20">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="pays"><b><span>*</span>Pays</b></label>
            <input type="text" id="pays" name="pays" class="form-control" placeholder="Entrez votre pays" maxlength="20">
        </div>
        <div class="form-group col-md-6">
            <label for="prix"><b><span>*</span>Prix</b></label>
            <input type="number" id="prix" name="prix" class="form-control" placeholder="Entrez le prix">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="photo"><b><span>*</span>Photo</b></label>
            <input type="file" class="form-control-file" id="photo" name="photo">
        </div>
        <div class="form-group col-md-12">
            <label for="description"><b><span>*</span>Description</b></label>
            <textarea class="form-control" id="description" rows="3" name="description" placeholder="Entrez votre description"></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-lg btn-block" name="enregistrer">Enregistrer</button>
</form>

<?php 
    require_once("partial/footer.php");
?>
