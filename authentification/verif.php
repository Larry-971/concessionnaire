<!-- Vérifie si la donnée existe afin de pouvoir récupérer listes.php -->
<?php
    session_start();
    //Si la session n'existe pas on redirige vers le formulaire de connexion
    if(!isset($_SESSION["auth"])){
        header('Location:index.php');
    }
?>