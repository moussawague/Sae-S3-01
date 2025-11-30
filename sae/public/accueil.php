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
                    <a class="nav-link" href="espace_donateur.html"><img src="img/compte.svg" alt="compte"> Espace donateur</a>
                    <a class="btn custom-btn2" href="faireDon.html">Faire un don</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<main>
    <section class="banner">
        <div class="article">
            <h1>SECOURIR,<br>ACCOMPAGNER,<br>RECONSTRUIRE</h1>
            <p>Découvrez nos valeurs, nos actions et comment vous pouvez y participer.</p>
            <div class="plus">
                <button type="button" class="btn btn-outline">Faire un don</button>
            </div>
        </div>
    </section>

    <section class="section1">
        <h1>Actualités et dossiers</h1>
        <div class="groupe">
            <a class="article" onclick="window.location.href='centre_daccueil.html'">
                <img src="img/actu5.jpg" alt="image1">
                <div id="description">
                    <button type="button" class="btn btn-primary" disabled>Actualité</button>
                    <h4>Ouverture d’un centre d’accueil à Lille</h4>
                    <p>Une nouvelle structure pour accueillir les familles en difficulté.</p>
                </div>
            </a>
            <div class="block">
                <img src="img/actu2.jpg" alt="image2">
                <div class="description1">
                    <button type="button" class="btn btn-primary" disabled>Actualité</button>
                    <h4>Quand l’été devient un danger pour les sans-abri</h4>
                    <h5>15 septembre 2025</h5>
                </div>
            </div>
            <div class="block">
                <img src="img/actu4.jpg" alt="image3">
                <div class="description1">
                    <button type="button" class="btn btn-danger" disabled>Action sociale</button>
                    <h4>A Lyon, un nouveau refuge mères et enfants isolées</h4>
                    <h5>26 septembre 2025</h5>
                </div>
            </div>
            <div class="block">
                <img src="img/actu3.jpg" alt="image4">
                <div class="description1">
                    <button type="button" class="btn btn-primary" disabled>Actualité</button>
                    <h4>Aidez les familles touchées par l’ouragan Melissa</h4>
                    <h5>31 octobre 2025</h5>
                </div>
            </div>
        </div>
        <div class="btn-info"><a class="btn" href="actualite.html">Voir plus</a></div>
    </section>

    <section class="section2">
        <h1>Chiffres <span class="highlight">&nbspclés&nbsp</span></h1>
        <div id="grid">
            <div class="block">
                <img src="img/structure.svg" alt="structures">
                <h3>225</h3>
                <h4>structures et services</h4>
            </div>
            <div class="block">
                <img src="img/personne.svg" alt="personnes">
                <h3>23k</h3>
                <h4>personnes accueillies</h4>
            </div>
            <div class="block">
                <img src="img/euro.svg" alt="millions">
                <h3>205</h3>
                <h4>millions d’euros</h4>
            </div>
            <div class="block">
                <img src="img/pays.svg" alt="pays">
                <h3>134</h3>
                <h4>pays dans le monde</h4>
            </div>
        </div>
        <div class="plus">
            <button type="button" class="btn">Plus d'information</button>
        </div>


    </section>

    <section class="section3">
        <h1>Nos actions</h1>
        <div class="grid">
            <div class="carte">
                <img src="img/accompagner.jpg" alt="Personnes accompagnées">
                <div class="description">Personnes accompagnées</div>
                <div class="cacher">Chaque jour, nos équipes se mobilisent auprès de personnes en situation de vulnérabilité pour leur apporter soutien, écoute et solutions concrètes.</div>
            </div>
            <div class="carte">
                <img src="img/champs-daction.jpg" alt="Champs d'action">
                <div class="description">Champs d'action</div>
                <div class="cacher">Chaque jour, les équipes de l'Armée du Salut agissent concrètement pour répondre aux défis sociaux et humanitaires.</div>
            </div>
            <div class="carte">
                <img src="img/evenement.jpg" alt="Événements">
                <div class="description">Événements</div>
                <div class="cacher">L'Armée du Salut organise de nombreux événements dans le but de récolter tout ce dont les personnes prises en charge pourront avoir besoin.</div>
            </div>
            <div class="carte">
                <img src="img/etablissement.jpg" alt="Établissements et postes">
                <div class="description">Établissements et postes</div>
                <div class="cacher">L'Armée du Salut compte plus de 200 établissements implantés dans 28 départements et 12 régions, ainsi que 23 postes (paroisses).</div>
            </div>
        </div>
    </section>

    <section class="section4">
        <h1>Aider l'armée du salut</h1>
        <div id="soutenir">
            <div class="block">
                <img src="img/rejoindre.svg" alt="image1">
                <div class="description1">
                    <h4>M'ENGAGER</h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Bénévolat et engagement citoyen
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>En devenant bénévole, en effectuant un service civique ou un mécénat de compétences, chacun peut s’engager concrètement et agir pour les personnes vulnérables que nous accompagnons.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Travailler à l'Armée du Salut
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>A la Fondation de l’Armée du Salut, nous recrutons régulièrement de nouveaux professionnels aux profils variés dans tous nos domaines d’activité : inclusion, jeunesse, protection de l’enfance, handicap, dépendance et soin et équipes support.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Mécénat de compétences
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>A la Fondation de l’Armée du Salut, nous recrutons régulièrement de nouveaux professionnels aux profils variés dans tous nos domaines d’activité : inclusion, jeunesse, protection de l’enfance, handicap, dépendance et soin et équipes support.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    M'impliquer à la Congrégation
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Au sein des communautés chrétiennes de la Congrégation de l’Armée du Salut (les postes), il est possible de prendre différents engagements., il est possible d’engager sa vie soit comme soldat ou comme officier. Un soldat est un membre laïc engagé, témoin de sa foi au quotidien, participant à la vie de sa communauté et aux actions sociales de l’Armée du Salut. L’officier, quant à lui, est consacré à plein temps, après formation et consécration, pour assumer des responsabilités de leadership, de direction pastorale et sociale.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive1" aria-expanded="true" aria-controls="collapseFive1">
                                    Devenir philanthrope
                                </button>
                            </h2>
                            <div id="collapseFive1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix1" aria-expanded="true" aria-controls="collapseSix1">
                                    Devenir entreprise mécène
                                </button>
                            </h2>
                            <div id="collapseSix1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="plus">
                        <a href="#">Voir plus d'actualité</a>
                    </div>
                </div>
            </div>
            <div class="block">
                <img src="img/soutenir.svg" alt="image1">
                <div class="description1">
                    <h4>DONNER</h4>
                    <div class="accordion" id="accordionExample1">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                    Dons pour l'action sociale
                                </button>
                            </h2>
                            <div id="collapseOne1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Chaque don compte. Grâce à votre générosité, nos équipes de salariés et bénévoles œuvrent chaque jour pour venir en aide aux personnes fragilisées par la précarité, touchées par un handicap, l’isolement ou le grand âge. Donner à la Fondation de l’Armée du Salut permet de répondre à l’urgence sociale et de proposer un accompagnement durable aux plus fragiles</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                    Don pour l'action spirituelle
                                </button>
                            </h2>
                            <div id="collapseTwo1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Nos équipes d’officiers (pasteurs), de salariés et de bénévoles œuvrent chaque jour pour annoncer l’Évangile de Jésus-Christ et soulager, en son nom, sans discrimination, les détresses humaines.

                                        Votre don permet à ces postes de développer des actions de proximité (colis alimentaires, dons de vêtements, soutien scolaire, activités de type scoutes, lutte contre la solitude des personnes âgées …).</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                    Legs, assurance vie, donation
                                </button>
                            </h2>
                            <div id="collapseThree1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Grâce à votre générosité, vous pouvez transformer durablement la vie de personnes en détresse. Qu’il s’agisse d’un legs, d’une donation ou d’une assurance-vie, chaque transmission est un acte de solidarité essentiel à la poursuite de nos missions sociales, éducatives et spirituelles.

                                        La Fondation de l’Armée du Salut est reconnue d’utilité publique par décret en date du 11 avril 2000. La Congrégation de l’Armée du Salut est légalement reconnue par décret en date du 7 janvier 1994. A ce titre, elles sont exonérées de droits de successions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour1" aria-expanded="true" aria-controls="collapseFour1">
                                    Faire un don IFI
                                </button>
                            </h2>
                            <div id="collapseFour1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>L’Impôt sur la Fortune Immobilière (IFI) est un impôt payé par les contribuables dont le patrimoine immobilier net taxable dépasse 1,3 million d’euros.

                                        En soutenant la Fondation de l’Armée du Salut, reconnue d’utilité publique, vous pouvez réduire le montant de cet impôt grâce à votre don. Si vous êtes assujetti à l’IFI, vous pouvez aider la Fondation de l’Armée du Salut dans son action en effectuant un don qui vous donne le droit à une déduction d’impôt pouvant aller jusqu’à 50.000€.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="plus">
                        <a href="#">Voir plus d'actualité</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

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

<!-- Popup de don -->
<div class="overlay" id="donPopup">
    <div class="custom-modal">
        <span class="close" id="closeBtn">&times;</span>
        <div class="icon">🎁</div>
        <h2>Votre geste, leur sourire.</h2>
        <p class="highlight">Première grande maraude en Île-de-France cet automne !</p>
        <p>Avec <span class="highlight">20 € ou plus</span>, vous offrez un colis alimentaire complet à une famille en Île-de-France. Chaque don est un geste qui se transforme en grand sourire.</p>
        <div class="input-group">
            <label for="amount">Montant du don</label><br>
            <input type="number" id="amount" value="20" min="1"> €
        </div>
        <button id="donBtn">Faire un don</button>
    </div>
</div>
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
