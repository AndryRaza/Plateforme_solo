<?php

/********************Partie pour gérer la vision du visiteur*************/

include 'create_card.php';
//On ouvre notre fichier contenant les produits pour pouvoir la parcourir et afficher chacune des cartes
$liste_produit = json_decode(file_get_contents('data/card.json'), true);



if (!empty($liste_produit)) { //Si la liste n'est pas vide, on va afficher chacune des cartes 
    $list_provi = array_reverse($liste_produit, true);
    foreach ($list_provi as $id => $value) {
        if ($value['active']) { ?>
            <div class="card col mr-md-3 mb-2" style="width: 18rem;" id="card_<?= $id ?>">
                <h2 class="card-title text-center" style="font-size:20px;"><?= $value['nom'] ?></h2>
                <h5 class="card-title text-center" style="color:red; font-size:30px"><?= $value['price'] ?>€</h5>
                <img  src="assets/<?= $value['image'] ?>" class="card-img-top mb-3" alt="..." style="max-height:200px">
                <div class="barre"></div>
                <div class="card-body">
                    <h5 class="card-title text-center" id="duree_<?= $id ?>"> <?php include 'timer.php'; ?> </h5>


                    <p class="card-text text-center"style="height:80px;overflow:hidden;"><?= $value['description'] ?></p>

                    <form action="includes/acheter.php" method="POST">
                        <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                        <input class="btn w-100" name="acheter" type="submit" value="Acheter">
                    </form>

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