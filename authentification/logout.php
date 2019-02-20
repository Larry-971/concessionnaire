 <!-- Se déconnecter -->
<?php
    session_start();

    // Nétoyer la session 
    session_unset();
    //Détruire la session
    session_destroy();
    //Redirection vers formulaire de connexion
    header('Location:../index.php');
?>