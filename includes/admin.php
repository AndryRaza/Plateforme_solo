<?php

/********************Partie pour gérer la vision de l'administrateur*************/

include 'create_card.php';

$liste_produit = json_decode(file_get_contents('data/card.json'), true);


foreach ($liste_produit as $id => $value) {
     if ($value['active']) { ?>
    <tr>
        <td class="text-center"><?= $value['nom'] ?></td>
        <td class="text-center"><img src="assets/<?= $value['image'] ?>" width=150px></td>
        <td class="text-center">
            <form action="pages/formulaire_modification.php" method="POST">
                <input type="hidden" name="id_produit" id="id_produit" value="<?= $id ?>">
                <input class="btn w-100" type="submit" name="modifier" value="Modifier">
            </form>
        </td>
    </tr>

<?php } }

?>