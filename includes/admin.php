<?php

/********************Partie pour gérer la vision de l'administrateur*************/

include 'create_card.php';

$liste_produit = json_decode(file_get_contents('data/card.json'), true);


foreach ($liste_produit as $id => $value) {
    if ($value['active']) { ?>
        <tr>
            <td class="text-center"><p class="pt-5"><?= $value['nom'] ?></p></td>
            <td class="text-center"><img src="assets/<?= $value['image'] ?>" style="max-height:80px"></td>
            <td class="text-center">
                <form action="pages/formulaire_modification.php" method="POST">
                    <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                    <input class="btn" type="submit" name="modifier" value="Modifier">
                </form>
                <form action="includes/modification.php" method="POST">
                    <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                    <input type="submit" class="btn" name="desactivate" id="desactivate" value="Désactiver">
                </form>
            </td>
        </tr>

<?php }
}

?>