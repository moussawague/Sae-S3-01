<?php
if (!session_id()) session_start();

require_once '../../vendor/autoload.php';

use sae\Messages;



if (!($_SESSION['part']===true)) {
    Messages::goHome("Bienvenue bénévole !", "success", "index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>

    <nav class="navbar navbar-expand-xxl navbar-light bg-white">
        <div class="container-fluid">
            <a href="accueil.html">
                <img src="img/logo.png" alt="Armée du Salut" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="accueil.html">Armée du salut</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actualite.html">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actions_sociales.html">Nos Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="m'engager.html">M'engager</a>
                    </li>
                </ul>
                <div class="btn-container">
                    <a class="nav-link" href="espace_donateur.php"><img src="img/compte.svg" alt="compte"> Espace donateur</a>
                    <a class="btn custom-btn2" href="faireDon.html">Faire un don</a>
                </div>
            </div>
        </div>
    </nav>
</header>
<body>
<?php
// 🔥 AFFICHAGE DU MESSAGE FLASH
Messages::messageFlash();
?>
<h1>participant</h1>
<h1>participant</h1>
<h1>participant</h1>
<h1>participant</h1>
<button type="button" class="btn btn-primary btn-lg">
    <a href="data.php">Données bénévoles</a>
</button>
</body>

<footer class="footer">
    <div class="footer-container">
        <!-- Section Newsletter -->
        <div class="footer-section newsletter-section">
            <h3>Suivez nos actions au quotidien</h3>
            <p class="newsletter-title">Recevez la newsletter de l'Armée du Salut</p>
            <div class="separator"></div>

            <div class="newsletter-form">
                <input type="email" placeholder="Votre email" class="email-input">
                <button class="footer-btn">S'inscrire →</button>
            </div>
            <div class="newsletter-checkbox">
                <label>
                    <input type="checkbox">
                    Je m'inscris à la Newsletter de la Fondation
                </label>
            </div>
        </div>

        <!-- Section Informations -->
        <div class="footer-section info-section">
            <div class="footer-column">
                <h4>ARMÉE DU SALUT</h4>
                <p>60, rue des Frères Flavien<br>
                    75976 Paris cedex 20<br>
                    France<br>
                    01 43 62 25 00</p>

                <div class="social-icons">
                    <span>SUIVEZ-NOUS</span>
                    <div class="icons">
                        <a href="#" class="social-icon">☐</a>
                        <a href="#" class="social-icon">in</a>
                    </div>
                </div>
            </div>

            <div class="footer-column">
                <h4>VERSIONS ACCOMPLIES</h4>
                <ul>
                    <li><a href="#">Personnes accompagnées</a></li>
                    <li><a href="#">Événements</a></li>
                    <li><a href="#">Champs d'action</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Établissements et postes</a></li>
                    <li><a href="#">La Nuit de la Philanthropie</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>DONNER</h4>
                <h4>M'ENGAGER</h4>
                <button href="#" class="footer-btn">Contactez-nous →</button>

                <div class="label-ideas">
                    <h5>LABEL IDEAS</h5>
                    <p>Le Label IDEAS atteste de la mise en œuvre par la Fondation de l'Armée du Salut de bonnes pratiques en matière de gouvernance, de gestion financière et d'évaluation.</p>
                </div>
            </div>
        </div>

        <!-- Section Mentions légales -->
        <div class="footer-bottom">
            <div class="legal-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">Gestion des cookies</a>
                <a href="#">Crédits supermegas</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>



<script>
    window.onload = () => {
        const popup = document.getElementById('donPopup');
        const closeBtn = document.getElementById('closeBtn');
        const donBtn = document.getElementById('donBtn');

        // Affiche le popup automatiquement
        popup.style.display = 'flex';

        // Fermer le popup
        closeBtn.onclick = () => popup.style.display = 'none';

        // Redirection sur la page de don
        donBtn.onclick = () => {
            const amount = document.getElementById('amount').value;
            // On peut ajouter le montant dans l'URL si besoin
            window.location.href = `faireDon.html?amount=${amount}`;
        }

        // Clic en dehors de la modale pour fermer
        window.onclick = (e) => { if(e.target === popup) popup.style.display = 'none'; }
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.3 });

        const section2 = document.querySelector('.section2');
        if (section2) observer.observe(section2);
    });
</script>

</body>
</html>
