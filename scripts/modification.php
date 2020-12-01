<?php 

/************ Permet la modification/suppression des cartes ******************/

/***************************Partie pour modifier une carte ***************************/ 
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['maj'])) {


    $produit = json_decode(file_get_contents('../data/card.json'),true); //On ouvre le fichier json et on stock le tableau qu'il renvoie 


    //Il manque la sécurité 

    //Si l'utilisateur souhaite modifier l'image de son enchère, sinon on garde la même image qu'à l'ajout
    if (isset($_FILES['image_modifie']['name']))
    {
    $content_dir = "D:\Formation\Projet-perso-enchere\assets\\"; //Chemin pour placer l'image
    $name_file = $_FILES['image_modifie']['name']; //On définit le nom de l'image
    $tmp_file = $_FILES['image_modifie']['tmp_name']; //On garde provisoirement l'image, quand on le déplacera il sera supprimé
    move_uploaded_file($tmp_file, $content_dir . $name_file); //On déplace l'image dans le dossier défini précédemment
    $produit[$j]['image'] = $name_file; //On modifie le nom de l'image du produit dans notre fichier json
    
    }

    
    
    $j=  $_POST['id_produit_modif']; //On récupère la place du produit dans notre fichier json pour pouvoir ensuite modifier ses caractéristiques

    $produit[$j]['nom'] = $_POST['nom_modifie']; //On modifie le nom
    $produit[$j]['description'] = $_POST['description_modifie']; //On modifie la description
    $produit[$j]['price'] = $_POST['prix_modifie']; //On modifie son prix s'il le souhaite
    $produit[$j]['price_up'] = $_POST['aug_prix_modifie']; //On modifie de combien le prix de l'enchère sera augmenté
    $produit[$j]['time_up'] = $_POST['aug_duree_modifie']; //On modifie de combien le temps de l'enchère sera augmenté

    file_put_contents('../data/card.json', json_encode($produit)); //On "traduit" la nouvelle liste en json puis on l'enregistre dans le fichier json
    header('Location: ../index.php'); 
}

/***************************Partie pour désactiver une carte ***************************/ 
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['desactivate'])) {

    $j= $_POST['id_produit_modif']; //On récupère l'index du produit cliqué
    $produit = json_decode(file_get_contents('../data/card.json'),true);
    $produit[$j]['active'] = false;

    file_put_contents('../data/card.json',json_encode($produit));
    header('Location: ../index.php'); 
}

/***************************Partie pour activer une carte ***************************/ 
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['activate'])) {
    
    $j= $_POST['id_desac']; //On récupère l'index du produit cliqué
    $produit = json_decode(file_get_contents('../data/card.json'),true);
    $produit[$j]['active'] = true;

    file_put_contents('../data/card.json',json_encode($produit));
    header('Location: ../pages/page_desactivate.php');
}

//Les modifications faites, on redirige l'utilisateur sur la page d'accueil
?>
