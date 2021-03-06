<?php
session_start();
include('../log/pdo.php');

    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $lattitude = htmlspecialchars($_POST['lattitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    $auteur_id = htmlspecialchars($_POST['auteur_id']);
    $choix = htmlspecialchars($_POST['choix']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $nb = rand(100,100000);

    try {
        $req = $bdd->prepare('INSERT INTO articles(titre,description,auteur_id,dateA,lattitude,photo,longitude,categorie) VALUES (:titre,:description,:auteur_id,:dateN,:lattitude,:photo,:longitude, :choix)');
        $req->execute(array("titre" => $titre, "description" => $description, "auteur_id" => $auteur_id, "lattitude" => $lattitude,"dateN"=>"2018-05-05", "photo" => basename($_FILES['photo']['name']).$nb, "longitude" => $longitude, "choix"=>$choix));

        $req1 =$bdd->prepare('UPDATE users set niveau=niveau+1 WHERE user_id=:user_id');
        $req1->execute(array('niveau'=>$niveau));

    }catch(Exception $e){
        die('Erreur : '.$e->getMessage()); // on arrête tous les processus et on affiche le message d'erreur
    }

if (isset($_FILES['photo']) and $_FILES['photo']['error'] == 0)
{
        $infos_fichier = pathinfo($_FILES['photo']['name']);
        $extension_upload = $infos_fichier['extension'];
        $extensions_autorisees= array('jpg','jpeg','png');

        if (in_array($extension_upload, $extensions_autorisees))
        {
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/articles/' . basename($_FILES['photo']['name']).$nb);
        }
}

header("Location: ../acceuil.php");
exit();