<?php
    // Sécurisation du fichier listes.php (si la session n'existe pas on y a pas accès)
    require_once("authentification/verif.php");

    //On se conecte à la base de donnée
    require_once("connect.php");
    $title = "Liste de voitures";

?>

<!-- En tête -->
<?php require_once('partial/header.php'); ?>

<!-- Corps de la page  -->
<a href="ajout.php" class="btn btn-warning text-white"><i class="fa fa-plus-circle"></i> Nouvelle voiture</a>
<h2>Liste des voitures</h2>
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>   
        <th>Id</th>
        <th>MARQUE</th>
        <th>MODELE</th>
        <th>PAYS</th>
        <th>PRIX</th>
        <th>PHOTO</th>
        <th>DESCRIPTION</th>
        <th>DATE ARRIVEE</th>
        <th>ACTION</th>
    </tr>
    </thead>
    <tbody>
        <?php 
            //Préparation de la requete
            $sql = "SELECT * FROM voiture";

            $res = mysqli_prepare($connect, $sql);
            //Exécution de la requete
            mysqli_stmt_execute($res);
            mysqli_stmt_bind_result($res, $id, $marque, $modele, $pays, $prix, $photo, $description, $da);

            //Parcourir ma base de donnée
            while(mysqli_stmt_fetch($res)){    
        ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $marque; ?></td>
            <td><?php echo $modele; ?></td>
            <td><?php echo $pays; ?></td>
            <td><?php echo $prix; ?> €</td>
            <td><img src="images/<?php echo $photo ?>" alt="photo" width="100" heigth="100"></td>
            <td><?php echo substr($description, 0, 20); ?></td>
            <td><?php echo $da; ?></td>
            <td>
                <a  href="editer.php?code=<?php echo $id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                <!-- Ajouter un paramètre au bouton pour pouvoir supprimer la donnée (id) -->
                <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer la voiture : <?php echo $marque .' ' . $modele ?> ?')" href="supprimer.php?code=<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Footer -->
<?php require_once('partial/footer.php'); ?>
    
