<?php 

require_once("connect.php");

if(isset($_POST["connexion"])){
    if(isset($_POST) && !empty($_POST["pseudo"]) && !empty($_POST["pwd"])){
        //Récupération des données
        $pseudo = htmlspecialchars(trim(addslashes($_POST["pseudo"])));
        $pass = MD5(htmlspecialchars(trim(addslashes($_POST["pwd"]))));
    }
    //Requete
    $sql = "SELECT * FROM admin WHERE pseudo = ? AND pass = ?";
    $res = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($res, "ss", $pseudo, $pass);
    mysqli_stmt_execute($res);

    //Traitement du résultat (énumérer toutes les colonnes de la tables admin)
    mysqli_stmt_bind_result($res, $id, $pseudo, $email, $pass);
    if(mysqli_stmt_fetch($res)){
        //Utilisation de la session
        session_start();
        //Si la personne existe dans la base, on stock c'est donné dans la session
        $_SESSION["auth"]["pseudo"] = $pseudo; 
        $_SESSION["auth"]["pass"] = $pass;

        header("Location:listes.php");
    }else{
        echo "Le pseudo ou le mot de passe sont incorrect";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>
<style>
    form {
  vertical-align: middle;
}
</style>
<body>

<div class="container">
    <div class="row col-md-6 offset-md-3">
        <h2>Formulaire de connexion</h2>
        <form action="" method="POST" autocomplete="off"> <!--Permet de ne pas enregistrer les pseudo-->
            <div class="form-group">
                <label for="pseudo">*Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Entrer votre pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="pwd">*Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Entrer votre password" name="pwd" required>
            </div>
            <!--
            <div class="form-group form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember"> Remember me
            </label>
            </div>-->
            <button type="submit" class="btn btn-primary btn-block" name="connexion">Connecter</button>
        </form>
    </div>
</div>

</body>
</html>
