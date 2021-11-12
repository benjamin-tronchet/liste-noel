<?php

    // ========================================================
    // Vérification de la dernière action de l'utilisateur sur le site
    // Si dernière action effectuée > 30 min alors Destruction des sessions utilisateurs et commandes
    // ========================================================

    function verify_max_lifetime() {
        
        // Si la session max_lifetime n'existe pas, alors on la crée
        if(empty($_SESSION['max_lifetime'])) {
            $_SESSION['max_lifetime'] = time();
        }
        
        // On récupère l'heure actuelle et on calcule la différence avec celle stockée en Session
        $now = time();
        $difference = $now - $_SESSION['max_lifetime'];
        
        // S'il s'est écoulé plus de 20 min >>> destruction de l'utilisateur // pro // panier // commande enregistrés
        if($difference > 1800) 
        {
            unset($_SESSION['user']);
            unset($_SESSION['pro']);
            unset($_SESSION['cart']);
            unset($_SESSION['createOrder']);
        }
        
        $_SESSION['max_lifetime'] = time();
    }

?>