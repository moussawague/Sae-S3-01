<?php
if (!session_id()) session_start();

require_once '../../vendor/autoload.php';

use sae\Messages;
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
            <a href="index.php">
                <img src="img/logo.png" alt="Armée du Salut" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Armée du salut</a>
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
                    <a class="nav-link" href="espace_donateur.html"><img src="img/compte.svg" alt="compte"> Espace donateur</a>
                    <a class="btn custom-btn2" href="faireDon.html">Faire un don</a>
                </div>
            </div>
        </div>
    </nav>
</header>
<?php
// 🔥 AFFICHAGE DU MESSAGE FLASH
Messages::messageFlash();
?>
<div class="container mt-3">
    <h2>Mes onglets</h2>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#signin">Authentification</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#signup">Enregistrement</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="signin" class="container tab-pane active show"><br>
            <form class="row g-3 needs-validation" action="signin.php" method="post">
                <div class="col-md-4 ">
                    <label for="signin-email" class="form-label">email</label>
                    <input type="text" class="form-control" id="signin-email" name="signin-email" placeholder="Votre adresse email..."
                           required>
                </div>
                <div class="col-md-4">
                    <label for="signin-pwd" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="signin-pwd" name="signin-pwd"  placeholder="Votre mot de passe"
                           required>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">Se connecter</button>
                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-outline-danger" type="submit">Vous avez oublié votre mot de passe ?</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="signup" class="container tab-pane fade"><br>
            <h4>Formulaire d'inscription</h4>
            <form class="row g-3 needs-validation" action="signup.php" method="post">

                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="signup-civil" class="form-label">Civilité</label>
                        <select class="form-select" id="signup-civil" name="signup-civil">
                            <option value="M" selected>M</option>
                            <option value="Mme">Mme</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="signup-name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="signup-name" name="signup-name"
                               placeholder="Votre nom..." required>
                    </div>

                    <div class="col-md-5">
                        <label for="signup-firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="signup-firstname" name="signup-firstname"
                               placeholder="Votre prénom..." required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="signup-birth" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="signup-birth" name="signup-birth" required>
                    </div>

                    <div class="col-md-7">
                        <label for="signup-email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="signup-email" name="signup-email"
                               placeholder="Votre adresse email..." required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="signup-pwd" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="signup-pwd" name="signup-pwd"
                               placeholder="Votre mot de passe..." required>
                    </div>

                    <div class="col-md-6">
                        <label for="signup-repwd" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="signup-repwd" name="signup-repwd"
                               placeholder="Retapez votre mot de passe..." required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-8">
                        <button class="btn btn-primary col-md-3 me-3" type="submit">S'inscrire</button>
                        <button class="btn btn-outline-danger col-md-3 ms-3" type="reset">Annuler</button>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

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
    document.addEventListener('DOMContentLoaded', function() {
        // Récupère le chemin actuel
        const currentPage = window.location.pathname.split('/').pop();

        // Trouve tous les liens de navigation
        const navLinks = document.querySelectorAll('.nav-link');

        // Ajoute la classe active au lien correspondant
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
    });
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
