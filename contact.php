<?php
include ('affichage/header.php');
session_start();
session_cache_limiter('private_no_expire, must-revalidate');

?>
    <!doctype html>
    <html lang="fr">

    <head>
        <meta charset="utf-8" />
        <title>Web-Trotter</title>
        <link rel="stylesheet" href="add.css" />
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    </head>

    <body>
    <!-- COMMENTAIRE : ici, je place le corps de mon site -->
    <div class="container">
        <nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
                <li><a href="acceuil.php"><img src="images/logo.png" alt="web-trotter" class="logo"></a></li>
            </ul>
        </nav>
        <script src="bootstrap/js/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

    <h2>Nous contacter</h2>
    <div class="row">
        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-lg-5 col-md-5 col-sm-5">
            <table class="table">
                <tr class="warning"><td>Veillez remplir les champs ci-dessous : </td></tr>
                <form class="well" method="post" action="traitement/insertContact.php" enctype="multipart/form-data">
                    <tr><td>Nom <input type="text" name="nom" class="form-control" required/></td></tr>
                    <tr><td>Prénom <input type="text" name="prenom" class="form-control"/></td></tr>
                    <tr><td>Adresse mail <input type="email" name="email" class="form-control"/></td></tr>
                    <tr><td>Sujet <input type="text" name="sujet" class="form-control"/></td></tr>
                    <tr><td>Message  <textarea name="message" rows="15" cols="80"></textarea></td></tr>
                    <tr><td><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-send"></span> Envoyer</button></td></tr>
                </form>
            </table>
        </div>
    </div>

<?php
include ('affichage/footer.php');
?>