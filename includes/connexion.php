<?php

/************ Gère la connexion admin ******************/

session_start(); //On ouvre une session pour pouvoir stocker une variable pour savoir si l'on est connecté en mode admin ou pas

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['connexion'])) {

    $login = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);

    if ($login === 'admin' and $pass === 'admin') {
        $_SESSION['admin'] = true; //Si le nom de l'utilisateur et le mdp sont bons, on restera connecté en mode admin
        $_SESSION['user'] = '';
        $_SESSION['money'] = 0;
    } else {
        $list_members = json_decode(file_get_contents('../data/membre.json'), true);

        foreach ($list_members as $id => $value) {
            if ($login === $value['name'] and $pass=== $value['password']) {
                $_SESSION['user'] =$value['name'];
                $_SESSION['money'] = $value['money'];
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deconnexion'])) {    //Si on est connecté en mode admin, et que l'on souhaite se déconnecte

    $_SESSION['admin'] = false; //Alors on sera pu considéré comme "Admin" 
    $_SESSION['user'] = '';
    $_SESSION['money'] = 0;
    session_destroy();
    session_unset();
}

header('Location: ../index.php'); //On redirige ensuite l'utilisateur sur la page d'accueil
