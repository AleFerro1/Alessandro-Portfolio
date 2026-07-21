<?php
session_start();

if (empty($_SESSION['lang'])) {
    $_SESSION['lang'] = 'it';
}

require_once 'lang/Lang.php';
$language = strtolower($_SESSION['lang']);
$lang = new Lang($language);

// --- DATI DELLE SKILL (Costellazione) ---
$phpSkillNodes = [
    ['id' => 0, 'x' => 0.14, 'y' => 0.12],
    ['id' => 1, 'x' => 0.35, 'y' => 0.04],
    ['id' => 2, 'x' => 0.65, 'y' => 0.04],
    ['id' => 3, 'x' => 0.90, 'y' => 0.35],
    ['id' => 4, 'x' => 0.80, 'y' => 0.70],
    ['id' => 5, 'x' => 0.48, 'y' => 0.90],
    ['id' => 6, 'x' => 0.11, 'y' => 0.65],
    ['id' => 7, 'x' => 0.50, 'y' => 0.45],
    ['id' => 8, 'x' => 0.60, 'y' => 0.68],
    ['id' => 9, 'x' => 0.45, 'y' => 0.22],
    ['id' => 10, 'x' => 0.22, 'y' => 0.35],
    ['id' => 11, 'x' => 0.22, 'y' => 0.85],
    ['id' => 12, 'x' => 0.25, 'y' => 0.25],  // LAMP
    ['id' => 13, 'x' => 0.55, 'y' => 0.55]   // API REST
];

$jsonSkills = [];
foreach ($phpSkillNodes as $node) {
    $jsonSkills[] = [
        'id'    => $node['id'],
        'name'  => $lang->get_string('skill_' . $node['id'] . '_name'),
        'desc'  => $lang->get_string('skill_' . $node['id'] . '_desc'),
        'x'     => $node['x'],
        'y'     => $node['y']
    ];
}

// --- DATI DEI PROGETTI (Per il Mazzo di Carte) ---
$phpProjects = [
    [
        'id' => 0,
        'name' => $lang->get_string('project_0_name'),
        'desc' => $lang->get_string('project_0_desc'),
        'url' => 'https://chessnova.win',
        'img' => '/assets/img/project1.webp',
        'tags' => ['LAMP', 'WebSocket', 'REST API']
    ],
];

session_write_close();

// Pagina corrente per i meta tag
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$pageUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$ogImage = 'https://' . $_SERVER['HTTP_HOST'] . '/assets/apple-touch-icon.png';

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="theme-color" content="#09090C">
    <meta name="description" content="Alessandro Ferraresi - Junior Web Developer. Portfolio con progetti full-stack, competenze PHP, JavaScript, Linux e molto altro.">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook / LinkedIn -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $pageUrl ?>">
    <meta property="og:title" content="Alessandro Ferraresi">
    <meta property="og:description" content="Portfolio con progetti full-stack, costellazione di skill e contatti.">
    <meta property="og:image" content="<?= $ogImage ?>">
    <meta property="og:image:width" content="180">
    <meta property="og:image:height" content="180">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= $pageUrl ?>">
    <meta name="twitter:title" content="Alessandro Ferraresi">
    <meta name="twitter:description" content="Portfolio con progetti full-stack, costellazione di skill e contatti.">
    <meta name="twitter:image" content="<?= $ogImage ?>">

    <title>Alessandro Ferraresi</title>
    <link rel="icon" type="image/png" href="/assets/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg" />
    <link rel="shortcut icon" href="/assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="AleFerraresi" />
    <link rel="manifest" href="/assets/site.webmanifest" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./dist/style.min.css" />
</head>
<body>
    <!-- Preloader -->
    <div id="preloader" class="preloader" aria-hidden="true">
        <div class="preloader-logo">
            <span class="preloader-text">AF</span>
            <div class="preloader-glow"></div>
        </div>
    </div>

    <!-- Language Switcher -->
    <div class="lang-switcher" id="langSwitcher" aria-label="Selettore lingua">
        <button class="lang-toggle" aria-label="Cambia lingua">
            <span class="fi fi-<?= $language === 'en' ? 'gb' : 'it' ?> lang-flag-icon"></span>
            <span class="lang-name"><?= $language === 'en' ? 'English' : 'Italiano' ?></span>
            <span class="lang-chevron">⌄</span>
        </button>
        <ul class="lang-dropdown">
            <li class="<?= $language === 'it' ? 'active' : '' ?>" data-lang="it">
                <span class="fi fi-it lang-flag-icon"></span>
                <span class="name">Italiano</span>
            </li>
            <li class="<?= $language === 'en' ? 'active' : '' ?>" data-lang="en">
                <span class="fi fi-gb lang-flag-icon"></span>
                <span class="name">English</span>
            </li>
        </ul>
    </div>

    <ul class="side-list" id="sideList">
        <li data-target="home" class="active">Home</li>
        <li data-target="about"><?= $lang->get_string('about_title') ?></li>
        <li data-target="skills"><?= $lang->get_string('nav_skills') ?></li>
        <li data-target="projects"><?= $lang->get_string('nav_projects') ?></li>
        <li data-target="contact"><?= $lang->get_string('nav_contact') ?></li>
    </ul>

    <div class="page-wrapper" id="pageWrapper">
        <!-- Hero -->
        <section class="hero" id="home">
            <div class="hero-bg" aria-hidden="true">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
                <div class="orb orb-4"></div>
                <div class="orb orb-5"></div>
            </div>
            <div class="titleContainer">
                <h1 class="title"><?= $lang->get_string('presentazione'); ?></h1>
                <div class="accent-line"></div>
                <p class="subtitle">Junior Web Developer</p>
            </div>
            <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down" aria-label="Vai alla sezione successiva">
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
                <div class="scroll-cue" aria-hidden="true"></div>
            </div>
        </section>

        <!-- About -->
        <section class="about_me" id="about">
            <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up" aria-label="Vai alla sezione precedente">
                <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
            </div>
            <div class="about-bg section-bg" data-bg="/assets/img/moon.webp"></div>
            <div class="about-overlay section-overlay"></div>
            <div class="about-inner">
                <div class="about-avatar">
                    <img id="avatarImg" src="" alt="Alessandro Ferraresi" width="180" height="180" loading="lazy" decoding="async" fetchpriority="high" />
                    <div class="avatar-fallback" id="avatarFallback">AF</div>
                </div>
                <div class="about-content">
                    <h2 class="about-title"><?= $lang->get_string('about_title') ?></h2>
                    <div class="accent-line accent-line--about"></div>
                    <p class="about-text"><?= $lang->get_string('aboutme'); ?></p>
                </div>
            </div>
            <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down" aria-label="Vai alla sezione successiva">
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
                <div class="scroll-cue" aria-hidden="true"></div>
            </div>
        </section>

        <!-- Skills -->
        <section class="skills_section" id="skills">
            <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up" aria-label="Vai alla sezione precedente">
                <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
            </div>
            <div class="skills-bg section-bg" data-bg="/assets/img/moondown.webp"></div>
            <div class="skills-overlay section-overlay"></div>
            <div class="skills-inner">
                <h2 class="about-title"><?= $lang->get_string('skills_title') ?></h2>
                <div class="accent-line accent-line--about"></div>
                <div class="constellation-wrapper" id="constellationContainer">
                    <canvas id="constellationCanvas"></canvas>
                    <div id="labelsContainer"></div>
                </div>
            </div>
            <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down" aria-label="Vai alla sezione successiva">
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
                <div class="scroll-cue" aria-hidden="true"></div>
            </div>
        </section>

        <!-- Projects -->
        <section class="projects_section" id="projects">
            <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up" aria-label="Vai alla sezione precedente">
                <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
            </div>
            <div class="projects-bg section-bg" data-bg="/assets/img/earth.webp"></div>
            <div class="projects-overlay section-overlay"></div>
            <div class="projects-container">
                <h2 class="projects-deck-title"><?= $lang->get_string('projects_title') ?></h2>
                <div class="accent-line accent-line--about" style="margin: 0 auto 2rem;"></div>

                <div class="card-deck" id="cardDeck">
                    <?php foreach ($phpProjects as $index => $project): ?>
                    <div class="project-card" data-index="<?= $index ?>" data-total="<?= count($phpProjects) ?>">
                        <div class="project-card-inner">
                            <div class="project-info">
                                <div class="project-tags">
                                    <?php foreach ($project['tags'] as $tag): ?>
                                        <span class="tag-pill"><?= $tag ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <h3 class="project-card-title"><?= htmlspecialchars($project['name']) ?></h3>
                                <p class="project-card-desc"><?= htmlspecialchars($project['desc']) ?></p>
                                <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank" rel="noopener noreferrer" class="project-visit-btn" aria-label="Visita il progetto <?= htmlspecialchars($project['name']) ?>">
                                    <?= $lang->get_string('view_project') ?>
                                </a>
                            </div>
                            <div class="project-mockup">
                                <div class="mockup-img">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                         data-src="./<?= htmlspecialchars($project['img']) ?>"
                                         alt="<?= htmlspecialchars($project['name']) ?> preview"
                                         class="mockup-img-photo lazy-img"
                                         decoding="async" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Indicatori di navigazione del mazzo -->
                <div class="deck-dots" id="deckDots" aria-label="Navigazione progetti">
                    <?php for ($i = 0; $i < count($phpProjects); $i++): ?>
                        <span class="deck-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down" aria-label="Vai alla sezione successiva">
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
                <div class="scroll-cue" aria-hidden="true"></div>
            </div>
        </section>

        <!-- Contact -->
        <section class="contact_section" id="contact">
            <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up" aria-label="Vai alla sezione precedente">
                <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
                <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
            </div>
            <div class="contact-svg-container" id="contactSvgContainer">
                <svg width="100%" height="100%" viewBox="0 0 690 410" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                    <defs>
                        <filter id="vermi" x="-10%" y="-10%" width="120%" height="120%" color-interpolation-filters="sRGB">
                            <feTurbulence type="fractalNoise" baseFrequency="0.025" numOctaves="1" seed="11" stitchTiles="stitch" result="noise" />
                            <feColorMatrix in="noise" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1.2 -0.5" result="threshold" />
                            <feMorphology in="threshold" operator="erode" radius="0.6" result="worms" />
                            <feTurbulence type="fractalNoise" baseFrequency="0.008" numOctaves="1" seed="57" stitchTiles="stitch" result="distortion" />
                            <feDisplacementMap in="worms" in2="distortion" scale="8" xChannelSelector="R" yChannelSelector="G" result="twistedWorms" />
                        </filter>
                    </defs>
                    <rect width="100%" height="100%" fill="#000" />
                    <rect width="100%" height="100%" filter="url(#vermi)" opacity="0.5" />
                </svg>
            </div>
            <div class="contact-overlay"></div>
            <div class="contact-inner">
                <h2 class="about-title"><?= $lang->get_string('contact_title') ?></h2>
                <div class="accent-line accent-line--about"></div>
                <div class="contact-content">
                    <p class="contact-desc"><?= $lang->get_string('contact_desc') ?></p>
                    <a href="mailto:alessandroferraresi2006@gmail.com" class="contact-btn" aria-label="Invia una email"><?= $lang->get_string('contact_btn') ?></a>
                    <a href="./assets/docs/alessandro-ferraresi-CV.pdf" download class="contact-btn contact-btn--secondary" aria-label="Scarica il curriculum in PDF">
                        <?= $lang->get_string('download_cv') ?>
                    </a>
                    <div class="contact-socials">
                        <a href="https://github.com/AleFerro1" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Profilo GitHub"><?= $lang->get_string('contact_social_gh') ?></a>
                        <span class="social-divider">&bull;</span>
                        <a href="https://linkedin.com/in/alessandro-ferraresi-56ab04383" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Profilo LinkedIn"><?= $lang->get_string('contact_social_li') ?></a>
                    </div>
                </div>
            </div>
            <div class="site-footer">
                <p class="footer-text">&copy; <?= date('Y') ?> Alessandro Ferraresi — <?= $lang->get_string('footer_rights') ?></p>
            </div>
        </section>
    </div>

    <!-- Overlay e Card per i dettagli della Skill -->
    <div id="skillOverlay" class="skill-overlay"></div>
    <div id="skillCard" class="skill-card" aria-modal="true" role="dialog" aria-labelledby="skillCardTitle">
        <button class="skill-card-close" id="closeSkillCard" aria-label="Chiudi dettaglio skill">✕</button>
        <h3 class="skill-card-title" id="skillCardTitle">Nome Skill</h3>
        <p class="skill-card-desc" id="skillCardDesc">Descrizione della skill...</p>
    </div>
    <script> window.skillsData = <?php echo json_encode($jsonSkills); ?>; </script>
    <script src="./dist/script.min.js" defer></script>
</body>
</html>