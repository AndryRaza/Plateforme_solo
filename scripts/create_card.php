<?php



/************ Permet l'affichage des cartes fraichement ajouté ******************/

require 'classes/card.class.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['add'])) {
    if (isset($_FILES['image_modifie']['name'])) {
        $validExt = array('.jpg', '.jpeg', '.gif', '.png');
        $name_file = $_FILES['image_produit']['name']; //Nom de l'image

        $fileExt = strtolower(substr(strrchr($name_file, '.'), 1)); //On met en miniscule le nom de l'image

        if (in_array("." . $fileExt, $validExt)) {
            $content_dir = "assets/"; //Chemin du dossier pour enregistrer nos images
            $tmp_file = $_FILES['image_produit']['tmp_name']; //Fichier temporaire stocké sur l'ordi qui sera supprimé avec move

            move_uploaded_file($tmp_file, $content_dir . $name_file); //On place l'image dans le dossier
        }
    } else {
        $name_file = 'no-image.png';
    }
    $new_card = new Card(   //On crée un nouvel instance Card
        $_POST['nom_produit'],
        $_POST['description_produit'],
        $name_file,
        $_POST['prix_produit'],
        $_POST['heure_produit'],
        $_POST['minute_produit'],
        $_POST['seconde_produit'],
        $_POST['aug_prix'],
        $_POST['aug_duree'],
        true
    );


    $contenu_produit = json_decode(file_get_contents('data/card.json'), true); //On ouvre notre fichier et on stock le tableau contenant les cartes

    $tab_provi = array( //On stock notre nouveau produit dans la liste des produits déjà crées
        'nom' => $new_card->getName(), 'description' => $new_card->getDescription(), 'image' => $new_card->getImage(),
        'price' => $new_card->getPrice(), 'timer' => $secondes = mktime(    //timer contiendra l'heure de fin de notre enchère
            date("H") + $new_card->getHour(),
            date("i") + $new_card->getMinute(),
            date("s") + $new_card->getSeconde(),
            date("m"),
            date("d"),
            date("Y")
        ),
        'price_up' => $new_card->getPriceUp(), 'time_up' => $new_card->getTimeUp(), 'active' => $new_card->getActive()
    );

    array_push($contenu_produit, $tab_provi);

    //Et pour finir, on enregistre le tout
    file_put_contents('data/card.json', json_encode($contenu_produit));
    $_SESSION['card_cree'] = true; //Variable pour savoir si l'ajout a bien été faite, là l'ajout est réussi
}

//On ouvre notre fichier contenant les produits pour pouvoir la parcourir et afficher chacune des cartes
$liste_produit = json_decode(file_get_contents('data/card.json'), true);



if (!empty($liste_produit)) { //Si la liste n'est pas vide, on va afficher chacune des cartes 
    $list_provi = array_reverse($liste_produit, true);
    foreach ($list_provi as $id => $value) {
        if ($value['active']) { ?>
            <div class="card col mr-md-3 mb-2" style="width: 18rem;" id="card_<?= $id ?>">
                <h2 class="card-title text-center" style="font-size:35px;"><?= $value['nom'] ?></h2>
                <h5 class="card-title text-center" style="color:red; font-size:30px"><?= $value['price'] ?>€</h5>
                <img height="300px" src="assets/<?= $value['image'] ?>" class="card-img-top mb-3" alt="...">
                <div class="barre"></div>
                <div class="card-body">
                    <h5 class="card-title text-center" id="duree_<?= $id ?>"> <?php include 'timer.php'; ?> </h5>


                    <p class="card-text text-center"><?= $value['description'] ?></p>
                    <?php if (!$_SESSION['admin']) { ?>
                        <form action="scripts/acheter.php" method="POST">
                            <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                            <input class="btn w-100" name="acheter" type="submit" value="Acheter">
                        </form>
                    <?php

                    } else { ?>
                        <form action="pages/formulaire_modification.php" method="POST">
                            <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                            <input class="btn w-100" type="submit" name="modifier" value="Modifier">
                        </form>
                    <?php } ?>
                </div>
            </div>
<?php }
    }
} else { //Sinon on affiche le message comme quoi il n'y a aucun produit disponible
    echo '<h3 class="text-center w-100 m-auto">';
    echo 'Rien pour le moment';
    echo '</h3>';
}
?>