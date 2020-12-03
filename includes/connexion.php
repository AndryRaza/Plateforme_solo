<?php

/************ Gère la connexion admin ******************/

session_start(); //On ouvre une session pour pouvoir stocker une variable pour savoir si l'on est connecté en mode admin ou pas

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['connexion'])) {
    if ($_POST['user'] === 'admin' and $_POST['pass'] === 'test') {
        $_SESSION['admin'] = true; //Si le nom de l'utilisateur et le mdp sont bons, on restera connecté en mode admin
        $_SESSION['user'] = '';
        $_SESSION['money'] = 0;
    } else {
        $list_members = json_decode(file_get_contents('../data/membre.json'), true);

        foreach ($list_members as $id => $value) {
            if ($_POST['user'] === $value['name'] and $_POST['pass']=== $value['password']) {
                $_SESSION['user'] = $_POST['user'];
                $_SESSION['money'] = $value['money'];
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deconnexion'])) {    //Si on est connecté en mode admin, et que l'on souhaite se déconnecte

    $_SESSION['admin'] = false; //Alors on sera pu considéré comme "Admin" 
    $_SESSION['user'] = '';
    $_SESSION['money'] = 0;

}

header('Location: ../index.php'); //On redirige ensuite l'utilisateur sur la page d'accueil
