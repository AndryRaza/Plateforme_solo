<?php

/************ Permet l'affichage des cartes désactivées ******************/

//On enregistre puis on stock notre tableau des cartes désactivées 
$liste_produit = json_decode(file_get_contents('../data/card.json'), true);

foreach ($liste_produit as $id => $value) { //Pour chaque carte, on affichera sa carte
    if (!$value['active']) {
?>

        <tr>
            <td class="text-center "><?= $value['nom'] ?></td>
            <td class="text-center "><img src="../assets/<?= $value['image'] ?>" width=150px></td>
            <td class="text-center ">
                <form action="../includes/modification.php" class="text-center" method="post">
                    <input type="hidden" name="id_desac" id="id_desac" value="<?= $id ?>">
                    <input class="btn " name="activate" type="submit" value="Activer">
                </form>
            </td>
        </tr>
<?php }
}

?>