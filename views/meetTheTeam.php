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

                            <h2>Biographie</h2>

                            <p><strong>Titres précoces</strong></p>
                            <p><strong>2 ans :</strong> Head de la Nase (NASE)</p>
                            <p><strong>6 ans :</strong> Ambassadeur Junior des mouettes</p>
                            <p><strong>9 ans :</strong>Directeur du protocole familial </p>

                            <p>
                                Jonathan Basque est né un matin de printemps 1992 dans une petite ville portuaire de Belgique, entre un centre de recherche océanographique et un festival de musique électro. Dès l’âge de trois ans, il déchiffrait les panneaux de signalisation maritime comme d’autres enfants lisent des livres d’images. Sa première console de jeu, bricolée par son grand-père ingénieur naval, intégrait déjà un mini-serveur local pour diffuser des textures 3D sur le quai du port. À cinq ans, Jonathan organisait des « sommets diplomatiques » entre les mouettes et les goélands, négociant des accords de partage de restes de frites et de crevettes grises.

                                Très vite, il développa une passion pour le langage des machines. À sept ans, il écrivait ses premiers scripts BASIC pour automatiser l’arrosage des plantes de sa mère, botaniste de métier. Il baptisa son programme « AquaDiplomat » et le présenta à l’école primaire lors d’un exposé sur « la coopération entre végétaux et IA ». Ses camarades furent subjugués, même si la maîtresse insista pour rappeler que l’eau de l’arrosage ne devait pas fuir sur les livres.

                                À neuf ans, Jonathan reçut en cadeau un robot-jouet programmable qu’il baptisa « Ambassadeur ». Il lui apprit à saluer chaque invité en imitant l’accent de différentes régions d’Europe, de l’Espagne au Danemark, en passant par la Grèce. L’enthousiasme de Jonathan pour la diplomatie technologique le poussa à créer un petit journal, « Le Messager Bionumérique », qu’il distribuait dans le quartier, mêlant compte-rendu des débats de mouettes, tutoriels de codage et chroniques météo spatiales – il prédisait souvent des pluies de météorites, avec un taux de réussite surprenant de 12 %.

                                Son adolescence fut marquée par un stage au Parlement européen simulé organisé par sa bibliothèque locale : il y présenta un projet de drone diplomatique capable de livrer du chocolat belge en zones de conflit. À 14 ans, il gagna le concours régional de robotique avec un prototype de drone-chat qui miaulait en cinq langues. Ses parents, étonnés, se demandaient s’il ne se prenait pas pour un agent secret en mission top‑secrète.

                                C’est à 16 ans que Jonathan décida de consacrer sa vie à décrypter les protocoles de communication entre humains et machines. Il partit en échange scolaire à Helsinki, où il suivit des cours de relations internationales et de deep learning. Là-bas, il organisa des dîners clandestins entre hackers et diplomates, échangeant recettes de ragoût finnois contre algorithmes de reconnaissance d’émotions.

                                Aujourd’hui, chacun de ses controllers porte l’empreinte de ce jeune prodige qui, dès l’enfance, mêlait diplomatie, codage et un humour si décalé qu’on le croirait sorti d’un roman de science-fiction.
                            </p>

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

                            <h2>Biographie</h2>

                            <p><strong>Titres précoces</strong></p>
                            <p><strong>2 ans :</strong> Gardien en chef des circuits imprimés</p>
                            <p><strong>6 ans :</strong> Oracle des Timbres Junior</p>
                            <p><strong>9 ans :</strong>Ministre de la migration des boîtes en carton</p>

                            <p>
                                Emilien Devauchelle est né en 1993 dans un village niché au cœur des montagnes suisses, là où les serveurs informatiques étaient presque aussi rares que les marmottes. Dès son plus jeune âge, il passa plus de temps à explorer les entrailles de l’ordinateur familial qu’à jouer au ballon. À quatre ans, il avait déjà démonté trois ordinateurs portables pour en étudier les disques durs, les piles CMOS et les ventilateurs miniatures. Sa mère, archiviste, lui confia ses archives de factures pour qu’il crée un système de classement automatisé… qu’il baptisa « Oracle des Timbres ».

                                À six ans, Emilien mit au point son premier SGBD rudimentaire à base de boîtes en carton étiquetées « Table Utilisateurs », « Table Produits » et « Table Secrets de famille ». Il codait ses requêtes en hiéroglyphes inventés, persuadé que cela renforcerait la sécurité. Ses camarades de classe l’appelaient « le petit magicien des données », surtout lorsqu’il prédisait avec exactitude la date de leur prochain contrôle de mathématiques grâce à l’analyse statistique de leurs bulletins précédents.

                                À huit ans, il suivit un cours de codage en ligne et découvrit MySQL. Il passa l’été à construire un prototype de base de données qui suivait l’évolution de la taille des sapins du jardin de ses grands-parents. À la rentrée, il présenta un graphique interactif sur les cycles de vie des conifères, déclenchant l’admiration (et la jalousie) de son institutrice.

                                À dix ans, Emilien gagna un hackathon local où il proposa un script Python pour générer automatiquement des playlists musicales basées sur les battements de cœur des participants. Il connecta un capteur cardiaque à un Raspberry Pi, et le résultat fit sensation : les parents dansaient au rythme de leurs propres pouls.

                                Adolescent, il s’intéressa à la magie vaudou des serveurs. Il organisa des « veillées sysadmin » dans le grenier familial, où il récitait des incantations Git pour résoudre des conflits de fusion (« merge »). Il créa même un talisman USB censé protéger les données contre les ransomwares – une clé USB ornée de runes gravées au laser.

                                À 15 ans, Emilien décrocha un stage dans une start-up de cybersécurité à Zurich, où il implanta un cluster Kubernetes miniature dans un aquarium transformé en datacenter expérimental. Les poissons nagèrent parmi les câbles réseau, et l’installation devint la star du salon tech local.

                                Ces expériences enfantines forgèrent l’âme du futur maître des bases de données que nous connaissons aujourd’hui : un ingénieur capable de construire des tables indestructibles et des controllers aux fondations plus solides que les montagnes helvétiques.
                            </p>

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

                            <h2>Biographie</h2>

                            <p><strong>Titres précoces</strong></p>
                            <p><strong>2 ans :</strong> Directeur artistique des murs de crèche</p>
                            <p><strong>6 ans :</strong> Maître des pixels volants</p>
                            <p><strong>9 ans :</strong> Ninja du CSS précoce</p>

                            <p>
                                Thomas Dubois vint au monde en 1994 dans un quartier artistique de Lyon, entouré de graffitis colorés et de galeries d’art urbain. Dès l’âge de deux ans, il griffonnait des esquisses sur les murs avec des craies géantes, persuadé que chaque surface était une toile vierge. Sa première tablette graphique, offerte à cinq ans, devint son terrain de jeu : il y peignit des univers fantastiques peuplés de néons et de formes géométriques.

                                À six ans, Thomas s’inscrivit à un atelier de design numérique où il apprit les bases du HTML en jouant à construire des pages de fans de Pokémon. Il imagina des layouts responsives pour Pokéball, avec des menus déroulants en forme d’écailles de Salamèche. Sa professeure le surnomma « le petit architecte du web » lorsqu’il réussit à intégrer un diaporama animé sans plugin externe.

                                À huit ans, il gagna un concours de design de t-shirt organisé par la mairie de Lyon. Son motif, un chat robotique stylisé entouré de circuits imprimés, fut porté par des centaines d’enfants lors de la fête de la musique. Cet événement marqua sa passion pour l’UX : il comprit que le design pouvait fédérer les gens.

                                Adolescent, Thomas consacra ses weekends à coder des animations CSS extravagantes. Il enseigna à ses amis comment créer des transitions hover dignes de blockbusters, avec des effets de distorsion et de particules. Son site personnel, « ThomasArtLab », devint célèbre parmi les collégiens pour ses tutoriaux en mode « live coding » et ses DJ sets en streaming, où chaque beat faisait pulser un motif SVG sur l’écran.

                                À 14 ans, il participa à un projet de réalité augmentée pour un musée local : en scannant une fresque médiévale, les visiteurs voyaient apparaître des dragons en 3D. Thomas codait le prototype dans sa chambre, entouré de posters de synth-wave et de sculptures en argile qu’il modelait pour comprendre le volume.

                                Ces aventures enfantines révélèrent un artiste du pixel et un ingénieur de l’interface hors pair, prêt à transformer chaque ligne de code en une expérience sensorielle.
                            </p>

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

                            <h2>Biographie</h2>

                            <p><strong>Titres précoces</strong></p>
                            <p><strong>2 ans :</strong> Grand Maître des tangrams</p>
                            <p><strong>6 ans :</strong> Architecte de fractales en pâte à modeler</p>
                            <p><strong>9 ans :</strong> Directeur des labyrinthes fractals</p>

                            <p>
                                Victor Martin naquit en 1991 à Bordeaux, ville de vin et de poésie. Très tôt, il manifesta un goût prononcé pour les formes et les structures mathématiques. À quatre ans, il jouait aux tangrams avec une telle précision qu’il battait ses parents à plate couture. À six ans, il s’amusa à modéliser en pâte à modeler des fractales de Mandelbrot, convaincu que l’on pouvait toucher l’infini avec les doigts.

                                À huit ans, Victor reçut en cadeau un kit de construction de robots LEGO Mindstorms. Il bâtit un automate qui traçait des cercles parfaits sur du papier, avec une précision au dixième de millimètre. Ses camarades de classe le regardaient avec admiration quand il expliquait, schéma à l’appui, comment son robot calculait le rayon et la circonférence grâce à un algorithme maison.

                                Adolescent, il se plongea dans l’algorithmique avancée. Il apprit Python et C++ pour créer des simulations de modèles moléculaires, qu’il affichait ensuite en 3D sur son ordinateur. Il rêvait de développer un jour un modèle capable de prédire la formation des cristaux de neige.

                                À 13 ans, Victor gagna un concours scientifique national en présentant un générateur de labyrinthes fractals, dont chaque couloir était défini par une règle récursive. Les juges furent impressionnés par la clarté de sa documentation et la modularité de son code.

                                À 15 ans, il participa à un stage d’été au CNRS où il assista des chercheurs en géométrie algorithmique. Il contribua à optimiser un algorithme de triangulation de surfaces complexes, tout en organisant des soirées « coding & vin » (sans alcool pour lui, bien sûr) où il faisait découvrir la beauté des structures mathématiques à ses amis.

                                Ces premières explorations enfantines façonnèrent le futur architecte logiciel que nous connaissons aujourd’hui : un maître des classes et des modèles, capable de faire dialoguer élégance mathématique et pragmatisme industriel.
                            </p>

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