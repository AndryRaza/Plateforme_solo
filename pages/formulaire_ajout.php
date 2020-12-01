<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- jQuery and JS bundle w Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <title>Page d'administration</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <?php if (!($_SESSION['admin'])) { ?>
            <form class="co pt-3" action="scripts/connexion.php" method="POST">
                <div class="form-group d-flex">
                    <input type="text" class="form-control mr-2" name="user" id="user" placeholder="Nom d'utilisateur" required pattern="[a-zA-Z]+">
                    <input type="password" class="form-control mr-2" name="pass" id="pass" placeholder="Mot de passe" required pattern="[a-zA-Z]+">
                    <input type="submit" class="btn  h-50" name="connexion" id="connexion" value="Se connecter">
                </div>
            </form>
        <?php } else { ?>
            <form class="co" action="scripts/connexion.php" method="POST">
                Mode ADMIN
                <input type="submit" class="btn  mr-2" name="deconnexion" id="deconnexion" value="Se deconnecter">
            </form>
        <?php }
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mb-4 justify-content-end " id="navbarNav">
            <ul class="navbar-nav">
                <?php if (($_SESSION['admin'])) { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ajouter un produit <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page_desactivate.php">Activer un produit</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <header class="container-fluid  text-white d-flex align-items-center justify-content-center">
        <h1>Formulaire d'ajout</h1>
    </header>

    <section class="container-fluid">
        <div class="container mt-5">
            <form enctype="multipart/form-data" action="../index.php" method="POST">
                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3 " for="nom_produit">Nom du produit :</label>
                    <input type="text" class="form-control col-md-9" name="nom_produit" id="nom_produit" placeholder="Ex: Iphone 6" required pattern="[a-zA-Z0-9 é è à ^ ' ]+">
                </div>

                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3 " for="description_produit">Description du produit :</label>
                    <input type="text" class="form-control col-md-9" name="description_produit" id="description_produit" value="Ce produit est très bien" required pattern="[a-zA-Z é è à ^ ' ]+">
                </div>

                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3" for="image_produit">Image du produit :</label>
                    <input type="file" class="form-control col-md-9" name="image_produit" id="image_produit" required>
                </div>

                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3" for="prix_produit">Prix initial du produit :</label>
                    <input type="number" class="form-control col-md-9" name="prix_produit" id="prix_produit" placeholder="Ex: 30€" required min=1 step="0.01">
                </div>

                <div class="form-group row row-cols-md-4 row-cols-1">
                    <label class="col" for="duree_produit">Durée de l'enchère :</label>
                    <input type="number" class="form-control col" name="heure_produit" id="heure_produit" placeholder="Ex: 1h" required min=0>
                    <input type="number" class="form-control col" name="minute_produit" id="minute_produit" placeholder="Ex: 1mn" required min=0>
                    <input type="number" class="form-control col" name="seconde_produit" id="seconde_produit" placeholder="Ex: 1sec" required min=1>

                </div>

                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3" for="aug_prix">Augmenter l'enchère de (en cts) :</label>
                    <input type="number" class="form-control col-md-9" name="aug_prix" id="aug_prix" placeholder="Ex: 2cts" required min=1 step="0.01">
                </div>

                <div class="form-group row row-cols-md-2 row-cols-1">
                    <label class="col-md-3" for="aug_duree">Augmenter le temps de (en mn) :</label>
                    <input type="number" class="form-control col-md-9" name="aug_duree" id="aug_duree" placeholder="Ex: 1mn" required min=1 step="0.01">
                </div>

                <div class="form-group d-flex justify-content-end">
                    <input type="submit" class="btn  " name="add" id="add" value="Valider">
                </div>
            </form>
        </div>
    </section>
</body>