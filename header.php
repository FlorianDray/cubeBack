<link href="style.css" rel="stylesheet" type="text/css"/>

<?php session_start(); ?>
<header>
    <div class="barre-haut">
        <a href="./index.php"><img src="./assets/images/logo-sneak-me-blanc.png" alt="Logo"></a>
        <div class="bouton-barre">
            <a href="./goback.php" class="btn-profil">
                <img src="./assets/images/image-de-profil-blanc.png" alt="Profil">
            </a>
            <a href="./logout.php" class="btn-deconnexion">
                <img src="./assets/images/deco-bouton.png" alt="Déconnexion">
            </a>
        </div>
    </div>
    <div class="contenu-page">
        <div class="menu-lateral">
            <nav class="vertical-center">
                <a href="./index.php" class="ptiteborder">Accueil</a>
                <a href="./products.php">Produits</a>
                <a href="./colors.php">Couleurs</a>
                <a href="./brands.php">Marques</a>
            </nav>
        </div>
    </div>
</header>