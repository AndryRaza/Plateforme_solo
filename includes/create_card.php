<?php



/************ Permet l'affichage des cartes fraichement ajouté ******************/

require 'classes/card.class.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['add'])) {

    $dossier = 'assets/';
    $fichier = basename($_FILES['image_produit']['name']);
    $taille_maxi = 1000000;
    $taille = filesize($_FILES['image_produit']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['image_produit']['name'], '.');

    if (!in_array($extension, $extensions)) {
        $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
    }

    if ($taille > $taille_maxi) {
        $erreur = 'Le fichier est trop gros...';
    }

    if ($_FILES['image_produit']['name'] === ' ') {
        $erreur = 'Nom de l\'image incorrect';
    }

    if (stristr($fichier, '<') != FALSE) {
        $erreur = 'Nom de l\'image incorrect';
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
            $fichier = 'no-image.png';
        }
    } else {
        echo $erreur;
        $fichier = 'no-image.png';
    }

    if (stripos(htmlspecialchars($_POST['nom_produit']), '<') === false 
    and stripos(htmlspecialchars($_POST['description_produit']), '<') === false 
    and isset($_POST['nom_produit']) 
    and isset($_POST['description_produit']) 
    and isset($_POST['prix_produit']) 
    and isset($_POST['heure_produit']) 
    and isset($_POST['minute_produit']) 
    and isset($_POST['seconde_produit']) 
    and isset($_POST['aug_prix']) 
    and isset($_POST['aug_duree']) 
    and isset($_POST['prix_clic'])
    and ($_POST['prix_produit'] > 0)
    and ($_POST['heure_produit'] > 0)  
    and ($_POST['minute_produit'] >= 0)  
    and ($_POST['seconde_produit'] >= 0)  
    and ($_POST['aug_prix'] > 0)  
    and ($_POST['aug_duree'] > 0)  
    and ($_POST['prix_clic'] > 0)    
    ) {
        $new_card = new Card(   //On crée un nouvel instance Card
            htmlspecialchars($_POST['nom_produit']),
            htmlspecialchars($_POST['description_produit']),
            $fichier,
          (int)$_POST['prix_produit'],
           (int) $_POST['heure_produit'],
          (int)  $_POST['minute_produit'],
           (int) $_POST['seconde_produit'],
           (int) $_POST['aug_prix'],
          (int)  $_POST['aug_duree'],
          (int)  $_POST['prix_clic'],
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
            'price_up' => $new_card->getPriceUp(), 'time_up' => $new_card->getTimeUp(), 'prix_clic' => $new_card->getPriceClic(), 'active' => $new_card->getActive()
        );

        array_push($contenu_produit, $tab_provi);

        //Et pour finir, on enregistre le tout
        file_put_contents('data/card.json', json_encode($contenu_produit));

        echo '<p class="text-center w-100" id="reussite"> Ajout Réussi ! </p>';
    } else echo '<p class="text-center w-100" id="echec"> Ajout échoué, arrêtez de toucher au code source ! </p>';
}
