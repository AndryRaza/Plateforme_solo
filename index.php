<?php
session_start();

if (!isset($_SESSION['admin'])) {   //$_SESSION['admin'] servira à savoir si l'on est connecté en tant qu'admin ou pas
    $_SESSION['admin'] = false; //lors de l'arrivé sur la page, c'est normal qu'on ne soit pas connecté en tant qu'admin
}

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = '';
}

if (!isset($_SESSION['money'])) {
    $_SESSION['money'] = 0;
}

if (!isset($_SESSION['debite'])) {
    $_SESSION['debite'] = false;
}

if (!isset($_SESSION['debite_prix'])) {
    $_SESSION['debite_prix'] = 0;
}

if (!isset($_SESSION['enchere_impossible'])) {
    $_SESSION['enchere_impossible'] = false;
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

    <title>Plateforme d'enchères</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light">
        <?php if (!($_SESSION['admin']) and $_SESSION['user'] === '') //On regarde si on est connecté en tant qu'admin ,si non on affiche les inputs de connexion
        { ?>
            <form class="co pt-3" action="includes/connexion.php" method="POST">
                <div class="form-group d-flex">
                    <input type="text" class="form-control mr-2" name="user" id="user" placeholder="Nom d'utilisateur" required pattern="[a-zA-Z 0-9 ]+">
                    <input type="password" class="form-control mr-2" name="pass" id="pass" placeholder="Mot de passe" required pattern="[a-zA-Z 0-9 ]+">
                    <input type="submit" class="btn h-50" name="connexion" id="connexion" value="Se connecter">
                </div>
                <div>
                <a class="text-dark ml-1" href="pages/formulaire_inscription.html">S'inscrire</a>
                </div>
            </form>
        <?php }

        if ($_SESSION['admin'] and $_SESSION['user'] === '') //si oui on peut afficher un bouton de déconnexion et le menu pour l'admin 
        { ?>
            <form class="co" action="includes/connexion.php" method="POST">
                Mode ADMIN
                <input type="submit" class="btn mr-2" name="deconnexion" id="deconnexion" value="Se deconnecter">
            </form>
        <?php }
        ?>

        <?php if (($_SESSION['user']) != '' and !($_SESSION['admin'])) { //On regarde si on est connecté en tant qu'admin, si oui on affiche son menu
        ?>
            <form class="co mt-2" action="includes/connexion.php" method="POST">
                Bienvenue <?= $_SESSION['user']; ?>
                <input type="submit" class="btn mr-2 ml-3" name="deconnexion" id="deconnexion" value="Se deconnecter">
            </form>
        <?php } ?>


        <?php if (($_SESSION['admin']) and $_SESSION['user'] === '') { //On regarde si on est connecté en tant qu'admin, si oui on affiche son menu
        ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mb-4 justify-content-end " id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/formulaire_ajout.php">Ajouter un produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/page_desactivate.php">Activer un produit</a>
                    </li>

                </ul>
            </div>
        <?php } ?>

        <?php if (!($_SESSION['admin']) and $_SESSION['user'] != '') {
        ?>

            <p class="ml-md-auto">Votre solde est de : <?= $_SESSION['money']; ?>€</p>
        <?php } ?>




    </nav>

    <header class="container-fluid  text-white d-flex">

        <h1 class="justify-self-center w-100 text-center my-auto">Plateforme d'enchères</h1>
      
    </header>

    <section class="container-fluid" id="ecran_card">
        <div class="container mt-5 mb-5 ">
            <?php if (!$_SESSION['admin']) { ?>
                <?php if ($_SESSION['debite']) {
                        echo '<p class="text-center">Vous avez été débité de ' . $_SESSION['debite_prix'] . '€ </p>';
                        $_SESSION['debite'] = false;
                        $_SESSION['debite_prix'] = 0 ;
                    } ?>
                 <?php if ($_SESSION['enchere_impossible']) {
                        echo '<p class="text-center">Vous n\'avez pu de sous. </p>';
                        $_SESSION['enchere_impossible'] = false;
                    } ?>
                <div class="row row-cols-md-4 row-cols-1 d-flex justify-content-center">
                    <?php include 'includes/client.php'; ?>

                </div>
            <?php } else { ?>
                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Nom</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <?php include 'includes/admin.php';  ?>
                </table>

            <?php } ?>
        </div>
    </section>


    <?php
    //Cette partie sert à rafraichir les timers de chaque enchère
    $list_produit = json_decode(file_get_contents('data/card.json'), true);
    for ($x = 0; $x < count($list_produit); $x++) {     //On récupère la longueur du tableau contenant des produits, on rafraichit le temps de chaque enchère
    ?>
        <script>
            $(document).ready(function() {

                function myFunction() {
                    var myVar = setInterval(function() {
                        $('<?php echo '#duree_' . $x ?>').load('index.php <?php echo '#duree_' . $x ?>');
                    }, 1000);
                };

                myFunction();
            })
        </script>
    <?php } ?>

</body>