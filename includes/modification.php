<?php

/************ Permet la modification/suppression des cartes ******************/

/***************************Partie pour modifier une carte ***************************/
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['maj'])) {



    //Si l'utilisateur souhaite modifier l'image de son enchère, sinon on garde la même image qu'à l'ajout
    if (isset($_FILES['image_modifie']['name'])) {

        $produit = json_decode(file_get_contents('../data/card.json'), true); //On ouvre le fichier json et on stock le tableau qu'il renvoie 
        $dossier = 'D:\Formation\Plateforme_solo\assets\\';
        $fichier = basename($_FILES['image_modifie']['name']);
        $taille_maxi = 1000000;
        $taille = filesize($_FILES['image_modifie']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image_modifie']['name'], '.');
        if (!in_array($extension, $extensions)) {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
        }

        if ($taille > $taille_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }

        if (!isset($erreur)) {
            $fichier = strtr(
                $fichier,
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
            );
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if (move_uploaded_file($_FILES['image_produit']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                echo '';
            } else //Sinon (la fonction renvoie FALSE).
            {
                echo $erreur;
                $fichier = 'no-image.png';
            }
        } else {
            echo $erreur;
            $fichier = 'no-image.png';
        }
    } else {
        $fichier = 'no-image.png';
    }

    $produit[$j]['image'] = $fichier; //On modifie le nom de l'image du produit dans notre fichier json

    $j =  $_POST['id_produit_modif']; //On récupère la place du produit dans notre fichier json pour pouvoir ensuite modifier ses caractéristiques

    $produit[$j]['nom'] = htmlspecialchars($_POST['nom_modifie']); //On modifie le nom
    $produit[$j]['description'] = htmlspecialchars($_POST['description_modifie']); //On modifie la description
    $produit[$j]['price'] = $_POST['prix_modifie']; //On modifie son prix s'il le souhaite
    $produit[$j]['price_up'] = $_POST['aug_prix_modifie']; //On modifie de combien le prix de l'enchère sera augmenté
    $produit[$j]['time_up'] = $_POST['aug_duree_modifie']; //On modifie de combien le temps de l'enchère sera augmenté
    $produit[$j]['prix_clic'] = $_POST['prix_clic_modifie']; //On modifie le prix du clic
    file_put_contents('../data/card.json', json_encode($produit)); //On "traduit" la nouvelle liste en json puis on l'enregistre dans le fichier json
    header('Location: ../index.php#card_' . $j); //On redirige l'utilisateur sur l'enchère modifiée
}

/***************************Partie pour désactiver une carte ***************************/
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['desactivate'])) {

    $j = $_POST['id_produit']; //On récupère l'index du produit cliqué
    $produit = json_decode(file_get_contents('../data/card.json'), true);
    $produit[$j]['active'] = false;

    file_put_contents('../data/card.json', json_encode($produit));
    header('Location: ../index.php');
}

/***************************Partie pour activer une carte ***************************/
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['activate'])) {

    $j = $_POST['id_desac']; //On récupère l'index du produit cliqué
    $produit = json_decode(file_get_contents('../data/card.json'), true);
    $produit[$j]['active'] = true;

    file_put_contents('../data/card.json', json_encode($produit));
    header('Location: ../pages/page_desactivate.php');
}
