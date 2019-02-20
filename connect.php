<?php 

const LOCAL = "127.0.0.1";
const UTILISATEUR = "";
const PASS = "";
const BDD = "concessionnaire";

$connect = mysqli_connect(LOCAL,UTILISATEUR,PASS,BDD);
//Force les donnée en utf-8 dans la base de donnée
mysqli_set_charset($connect, "utf-8");

if($connect){
    echo"Connexion réussie...";
}
