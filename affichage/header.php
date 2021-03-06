<?php
    session_start();
    $connect=false;
session_cache_limiter('private_no_expire, must-revalidate');
if (!isset($_SESSION) || !isset($_SESSION["user_id"]))
{
    $connect=true;
    header("Location: index.php");
    exit();
}
require 'object/article.php';
require 'object/Profil.php';
require 'object/distCalculator.php';

$userId = $_SESSION["user_id"];
$profil = new Profil($userId);
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Web-Trotter</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="add.css" />
</head>

<body>
<div class="row">
    <div id="titreHead">
        <h1>Web-Trotter</h1>
    </div>
</div>
<!-- COMMENTAIRE : ici, je place le corps de mon site -->
<img src="images/back.png" alt="informatique" class="img-responsive">
        <nav class="navbar navbar-inverse" id="barreNav">
            <div class="pull-left">
                <a href="acceuil.php"><img src="images/logo.png" alt="web-trotter" class="logo"></a>
            </div>
            <ul class="nav navbar-nav">
                    <li> <a href="acceuil.php">Accueil</a> </li>
                    <li> <a href="newArticle.php">Ajouter un lieu</a> </li>
                    <li> <a href="contact.php">Contact</a> </li>
            </ul>
            <div class="pull-right">
                <?php if (isset($_SESSION['user'])) { ?>
                    <div class="btn btn-default disabled" style="cursor:default;"><span class="glyphicon glyphicon-check"></span> <?php echo $_SESSION['user']; ?>, <?php echo $profil->getGroupe(); ?> </div>
                <?php } ?>

                <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">Compte <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="profil.php"><span class="glyphicon glyphicon-user"></span> Mon profil</a></li>
                    <li><a href="contributions.php"><span class="glyphicon glyphicon-picture"></span> Mes Contributions</a></li>
                    <li><a href="messagerie.php"><span class="glyphicon glyphicon-envelope"></span> Messagerie</a></li>
                    <?php
                    if ($profil->getGroupe() == "moderateur" || $profil->getGroupe() == "admin" )
                    {
                        echo "<li class=\"divider\"></li>";
                        echo "<li> <a href=\"editarticle.php\"><span class=\"glyphicon glyphicon-wrench\"></span> Modération</a> </li>";
                    } ?>
                    <?php
                    if ($profil->getGroupe() == "admin")
                    {
                        echo "<li> <a href=\"admin.php\"><span class=\"glyphicon glyphicon-console\"></span> Panel Admin</a> </li>";
                    } ?>
                    <li class="divider"></li>
                    <li><a href="index.php?disconnect=true"><span class="glyphicon glyphicon-log-in"></span> Se Déconnecter</a></li>
                </ul>
            </div>
        </nav>
<div class="container">
    <script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>