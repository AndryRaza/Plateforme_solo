<?php

/************ Gère la connexion admin ******************/

session_start(); //On ouvre une session pour pouvoir stocker une variable pour savoir si l'on est connecté en mode admin ou pas

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['connexion'])) {
    if ($_POST['user'] === 'admin' and $_POST['pass']==='test')
    {
       $_SESSION['admin'] = true; //Si le nom de l'utilisateur et le mdp sont bons, on restera connecté en mode admin
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deconnexion'])) {    //Si on est connecté en mode admin, et que l'on souhaite se déconnecte
    
       $_SESSION['admin'] = false; //Alors on sera pu considéré comme "Admin" 
    
}

header('Location: ../index.php'); //On redirige ensuite l'utilisateur sur la page d'accueil
?>

