<?php
require 'partials/head.php';   // make sure <html data-bs-theme="dark"> is in head.php
require 'partials/header.php';
?>

<style>
    .btn-group .btn {
        font-size: 2rem;
        background: none;
        border: 2px solid white;
        /* Add a white border */
        color: white;
        border-radius: 20px;
        /* Optional: Add rounded corners */
    }

    .btn-group .btn:hover {
        color: #ccc;
        text-shadow: 0 0 20px white;
        /* Add a subtle white glow */
        border-color: #ccc;
        /* Change border color on hover */
    }

    .btn-group .btn:focus {
        outline: none;
        /* Remove the focus outline */
        box-shadow: none;
        /* Ensure no shadow appears on focus */
    }

    .btn-group .btn:active {
        outline: none;
        /* Remove outline when the button is clicked */
        box-shadow: none;
        /* Remove any active state shadow */
    }

    .collapse {
        width: 50%;
        margin: 0 auto;
    }
</style>

<div class="container py-5 text-center">
    <h1 class="text-light mb-4">L'équipe</h1>

    <!-- Letter buttons -->
    <div class="btn-group mb-4 d-flex justify-content-center gap-0" role="group" aria-label="Team selector">
        <?php
        $selected = isset($selectedMember) ? (int)$selectedMember : null;
        foreach ($members as $i => $m): ?>
            <button
                type="button"
                class="btn text-light fw-bold"
                style="font-size: 2rem; background: none;"
                data-bs-toggle="collapse"
                data-bs-target="#panel-<?= $i ?>"
                aria-expanded="<?= $selected === $i ? 'true' : 'false' ?>"
                aria-controls="panel-<?= $i ?>">
                <?= $m['letter'] ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Collapsible panels -->
    <div class="d-flex flex-column align-items-center">
        <?php foreach ($members as $i => $m): ?>
            <div
                id="panel-<?= $i ?>"
                class="collapse<?= $selected === $i ? ' show' : '' ?>"
                data-bs-parent=".d-flex"
                style="width: 50%;">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body">
                        <h1 class="card-title"><?= $m['name'] ?></h1>
                        <?php if ($m['letter'] == 'J'): ?>

                            <p>
                                Jonathan Basque, envoyé spécial de l’Union Européenne pour étudier les mystères du Model‑View‑Controller, a débarqué un beau matin à l’agence en costume-cravate et baskets fluorescentes. Entre deux séances de négociations diplomatiques sur l’optimisation de routes API, il a codé nos controllers avec une rigueur de chef d’état – et un soupçon de caféine en intraveineuse. Lorsqu’il ne décrypte pas les secrets du routage REST, on le surprend à jongler avec des toboggans lunaires et à donner des conférences TEDx sur la diplomatie des microservices.
                            </p>

                            <h2>Diplomes</h2>

                            <p>Licence en informatique (Sorbonne)</p>
                            <p>Master en diplomatie technologique (Université de Bruxelles)</p>
                            <p>Doctorat en robotique politique (Stanford)</p>

                            <h2>Experiences professionelles</h2>

                            <p>Développeur de drones humanitaires (UE)</p>
                            <p>Analyste de réseaux extraterrestres</p>
                            <p>Consultant en design de smart‑frigos</p>
                            <p>Testeur de toboggans lunaires</p>
                            <p>Traducteur de langages dinosaures (COBOL jurassique)</p>
                            <p>Pilote de sous‑marins autonomes</p>
                            <p>Chef de projet IA au CERN</p>
                            <p>Coach éthique IA pour chimpanzés</p>
                            <p>Agent secret VR pour l’ONU</p>
                            <p>Chroniqueur tech médiévale</p>
                            <p>Animateur de podcast sur l’internet quantique</p>
                            <p>Architecte de bases de données sous‑marines</p>
                            <p>Enseignant en cuisine moléculaire robotisée</p>
                            <p>Designer de filtres AR pour plantes</p>
                            <p>Guide de musées holographiques</p>

                        <?php elseif ($m['letter'] == 'E'): ?>
                            <p>
                                Emilien Devauchelle, ancien gardien de serveurs antiques et autodidacte de SQL, a fondé la base de données du projet en jonglant avec MySQL, PostgreSQL et un soupçon de magie vaudou. Véritable maître des migrations, il a bâti des tables plus solides que des bunkers suisses. Quand il n’optimise pas nos requêtes, il écrit des romans d’anticipation sur la vie secrète des index, et monte des orchestres symphoniques… de disques durs. Ses controllers, eux aussi, sont nés sous sa plume trempée dans l’huile de serveur.
                            </p>

                            <h2>Diplômes</h2>

                            <p>Licence en génie logiciel (École Polytechnique)</p>
                            <p>Master en archéologie des serveurs (Oxford)</p>
                            <p>Doctorat en structures de données exotiques (Caltech)</p>

                            <h2>Expériences professionnelles</h2>

                            <p>Conservateur de disques durs préhistoriques</p>
                            <p>Architecte de bases sous-marines</p>
                            <p>Consultant en migration de données interplanétaires</p>
                            <p>Testeur de RAID en milieu hostile</p>
                            <p>Réparateur de mainframes steampunk</p>
                            <p>Analyste Big Data pour fourmis cybernétiques</p>
                            <p>Enseignant en SQL pour poulpes</p>
                            <p>Ingénieur DevOps sur montgolfières</p>
                            <p>Créateur de dashboards en réalité augmentée</p>
                            <p>Expert en sauvegarde quantique</p>
                            <p>Administrateur de clusters volcaniques</p>
                            <p>Coach en performance NoSQL</p>
                            <p>Pilote de chariots élévateurs autonomes</p>
                            <p>Éditeur de manuels de procédures cloud</p>
                            <p>Scénariste de web‑séries sur l’IoT</p>

                        <?php elseif ($m['letter'] == 'T'): ?>

                            <p>
                                Thomas Roeung, autodidacte du pixel et ninja du CSS, a façonné l’interface de notre site comme un sculpteur de marbre high‑tech. Entre deux frameworks JavaScript, il crée des animations dignes de blockbusters et des grilles responsives capables de résister à l’apocalypse du mobile. Quand il ne sublime pas un bouton hover, il compose des symphonies synth‑wave et monte des expositions de design pour IA en reconversion artistique.
                            </p>

                            <h2>Diplômes</h2>

                            <p>Licence en design interactif (École des Arts Déco)</p>
                            <p>Master en ergonomie numérique (MIT Media Lab)</p>
                            <p>Doctorat en psychologie des couleurs (Tokyo Tech)</p>

                            <h2>Expériences professionnelles</h2>

                            <p>Directeur artistique pour robots-peintres</p>
                            <p>Consultant UI pour vaisseaux spatiaux</p>
                            <p>Designer de thèmes WordPress subaquatiques</p>
                            <p>Testeur de typographies volantes</p>
                            <p>Créateur de palettes Pantone quantiques</p>
                            <p>Illustrateur de wireframes en lévitation</p>
                            <p>Animateur CSS pour hologrammes</p>
                            <p>Formateur en flexbox pour dauphins</p>
                            <p>Chef de projet UX sur montgolfières</p>
                            <p>Rédacteur de guidelines AR/VR</p>
                            <p>Styliste d’avatars Minecraft</p>
                            <p>Photographe de pixels haute résolution</p>
                            <p>Scénographe d’interfaces sensorielles</p>
                            <p>Expert en accessibilité pour IA aveugles</p>
                            <p>Musicien de jingles d’applications</p>

                        <?php elseif ($m['letter'] == 'V'): ?>

                            <p>
                                Victor Thibodeau, virtuose des classes et modèles, a orchestré notre architecture orientée objet avec la précision d’un chef d’orchestre baroque. Ses modèles, élégants et modulaires, pourraient presque s’auto-documenter. Il a même ajouté quelques controllers à son tableau de chasse, pour ne pas perdre la main. Lorsqu’il ne refactorise pas notre code, il conçoit des imprimantes 3D pour architectures fractales et organise des conférences sur l’esthétique du polymorphisme.
                            </p>

                            <h2>Diplômes</h2>

                            <p>Licence en informatique théorique (Université de Cambridge)</p>
                            <p>Master en modélisation 3D fractale (Caltech)</p>
                            <p>Doctorat en architecture logicielle auto‑évolutive (ETH Zurich)</p>

                            <h2>Expériences professionnelles</h2>

                            <p>Ingénieur en modélisation pour drones</p>
                            <p>Architecte de microservices steampunk</p>
                            <p>Consultant en design de patterns GoF vivants</p>
                            <p>Testeur de singletons autonomes</p>
                            <p>Développeur de plugins Minecraft éducatifs</p>
                            <p>Coach en SOLID pour robots</p>
                            <p>Analyste de code pour IA poètes</p>
                            <p>Enseignant en réflexivité Java</p>
                            <p>Créateur de générateurs de code automatique</p>
                            <p>Chef de projet blockchain musical</p>
                            <p>Réparateur de frameworks vintage</p>
                            <p>Scénariste de docstrings épiques</p>
                            <p>Musicien de méthodes récursives</p>
                            <p>Designer de pipelines CI/CD interstellaires</p>
                            <p>Traducteur de pseudo‑code en langues mortes</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require 'partials/footer.php';
?>