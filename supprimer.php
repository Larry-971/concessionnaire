<?php
//Sécurisation du fichier
require_once("authentification/verif.php");

//Connexion à la base de donnée
require_once("connect.php");

if(isset($_GET['code'])){
    //Sécurisation des données
    $code = htmlspecialchars(trim($_GET["code"]));

    //Requete de suppression
    $sql = "DELETE FROM voiture WHERE Id = ?";

    //Préparation de la requete 
    $res = mysqli_prepare($connect, $sql);

    //Liaison de du parametre 
    mysqli_stmt_bind_param($res, "i", $code);

    //Exécution de la requete 
    $ok = mysqli_stmt_execute($res);

    if($ok){
        header("Location:listes.php");
    }else{
        echo "Erreur lors de la suppression...";
    }

}

?>