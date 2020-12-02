<?php



/************ Permet l'affichage des cartes fraichement ajouté ******************/

require 'classes/card.class.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['add'])) {
    if ($_FILES['image_produit']['name'] != '' and $_FILES['image_produit']['size'] < 100000000000000000) {
        
        $name_file = $_FILES['image_produit']['name']; //Nom de l'image
        $content_dir = "D:\Formation\Plateforme_solo\assets\\"; //Chemin du dossier pour enregistrer nos images
        $tmp_file = $_FILES['image_produit']['tmp_name']; //Fichier temporaire stocké sur l'ordi qui sera supprimé avec move

        move_uploaded_file($tmp_file, $content_dir . $name_file); //On place l'image dans le dossier

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
}
