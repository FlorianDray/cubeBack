<link href="style.css" rel="stylesheet" type="text/css"/>

<?php session_start(); ?>
<header>

    <div class="barre-haut">
        <img src="./assets/images/logo-sneak-me-blanc.png" alt="Logo">
        <a href="./logout.php" class="btn-deconnexion">
            <img src="./assets/images/deco-bouton.png" alt="Déconnexion">
        </a>
    </div>

    <div class="contenu-page">
        <div class="menu-lateral">
            <nav>
                <ul>
                <li><a href="./index.php">Accueil</a></li>
                <li><a href="./products.php">Produits</a></li>
                <li><a href="#">Catégories</a></li>
                <li><a href="#">Marques</a></li>
                </ul>
            </nav>
        </div>
    </div>

</header>