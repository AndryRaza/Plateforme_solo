<?php

/************ Permet l'affichage des cartes désactivées ******************/

//On enregistre puis on stock notre tableau des cartes désactivées 
$liste_produit = json_decode(file_get_contents('../data/card.json'), true);
if (!empty($liste_produit)) { //Si la liste n'est pas vide
    foreach ($liste_produit as $id => $value) { //Pour chaque carte, on affichera sa carte
        if (!$value['active']) {
?>

            <div class="card col mx-auto" style="width: 18rem;">
                <h2 class="card-title text-center"><?= $value['nom'] ?></h2>
                <h5 class="card-title text-center"><?= $value['price'] ?>€</h5>
                <img src="../assets/<?= $value['image'] ?>" class="card-img-top" alt="...">
                <div class="barre"></div>
                <div class="card-body">
                    <h5 class="card-title text-center">00:30:00</h5>
                    <p class="card-text"><?= $value['description'] ?></p>
                    <form action="../scripts/modification.php" class="text-center" method="post">
                        <input type="hidden" name="id_desac" id="id_desac" value="<?= $id ?>">
                        <input class="btn " name="activate" type="submit" value="Activer">
                    </form>
                </div>
            </div>
<?php }
    }
} else { //Sinon on affiche le message qu'il n'y a pas d'enchères désactivées
    echo '<h3 class="text-center w-100 m-auto">';
    echo 'Aucune enchère désactivée';
    echo '</h3>';
}

?>