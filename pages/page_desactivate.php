<?php session_start() ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <title>Panneau des cartes désactivées</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light  ">
        
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
                        <a class="nav-link" href="formulaire_ajout.php">Ajouter un produit </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page_desactivate.php">Activer un produit <span class="sr-only">(current)</span></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <header class="container-fluid  text-white d-flex">
        <h1 class="justify-self-center w-100 text-center my-auto">Enchère(s) désactivée(s)</h1>
    </header>

    <section class="container-fluid" id="ecran_card">
        <div class="container mt-5 mb-5 ">
        <table class="table w-100">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Nom</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <?php include '../includes/desactivate.php' ?>
                </table>
        </div>
    </section>
</body>