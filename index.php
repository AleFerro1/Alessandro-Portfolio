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
    ['id' => 11, 'x' => 0.22, 'y' => 0.85]
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
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Alessandro Ferraresi — Junior Web Developer</title>
    <link rel="icon" type="image/png" href="/assets/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg" />
    <link rel="shortcut icon" href="/assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="AleFerraresi" />
    <link rel="manifest" href="/assets/site.webmanifest" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/portfolio.css"/>
  </head>
  <body>
    <!-- Language Switcher -->
    <div class="lang-switcher" id="langSwitcher">
      <button class="lang-toggle">
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
        <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down">
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
          <div class="scroll-cue" aria-hidden="true"></div>
        </div>
      </section>

      <section class="about_me" id="about">
        <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up">
          <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
        </div>
        <div class="about-bg section-bg"></div>
        <div class="about-overlay section-overlay"></div>
        <div class="about-inner">
            <div class="about-avatar">
              <img id="avatarImg" src="" alt="Alessandro Ferraresi" width="180" height="180" loading="lazy" decoding="async" />
              <div class="avatar-fallback" id="avatarFallback">AF</div>
            </div>
            <div class="about-content">
              <h2 class="about-title"><?= $lang->get_string('about_title') ?></h2>
              <div class="accent-line accent-line--about"></div>
              <p class="about-text"><?= $lang->get_string('aboutme'); ?></p>
            </div>
        </div>
        <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down">
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
          <div class="scroll-cue" aria-hidden="true"></div>
        </div>
      </section>

      <section class="skills_section" id="skills">
        <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up">
          <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
        </div>
        <div class="skills-bg section-bg"></div>
        <div class="skills-overlay section-overlay"></div>
        <div class="skills-inner">
          <h2 class="about-title"><?= $lang->get_string('skills_title') ?></h2>
          <div class="accent-line accent-line--about"></div>
          <div class="constellation-wrapper" id="constellationContainer">
            <canvas id="constellationCanvas"></canvas>
            <div id="labelsContainer"></div>
          </div>
        </div>
        <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down">
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
          <div class="scroll-cue" aria-hidden="true"></div>
        </div>
      </section>

      <!-- MAZZO DI CARTE (PROJECTS) -->
      <section class="projects_section" id="projects">
        <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up">
          <div class="scroll-cue scroll-cue--up" aria-hidden="true"></div>
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint_up') ?></span>
        </div>
        <div class="projects-bg section-bg"></div>
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
                            <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank" class="project-visit-btn">
                                <?= $lang->get_string('view_project') ?>
                            </a>
                        </div>
                        <div class="project-mockup">
                          <div class="mockup-img">
                              <img src="./<?= htmlspecialchars($project['img']) ?>" alt="<?= htmlspecialchars($project['name']) ?> preview" class="mockup-img-photo" loading="lazy" decoding="async" />
                          </div>
                      </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="scroll-cue-wrapper scroll-cue-wrapper--section" data-direction="down">
          <span class="scroll-cue-label"><?= $lang->get_string('scroll_hint') ?></span>
          <div class="scroll-cue" aria-hidden="true"></div>
        </div>
      </section>

      <!-- SEZIONE CONTACT CON SVG PSICHEDELICO INLINE -->
      <section class="contact_section" id="contact">
        <div class="scroll-cue-wrapper scroll-cue-wrapper--up scroll-cue-wrapper--section" data-direction="up">
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
                <p class="contact-tagline"><?= $lang->get_string('contact_tagline') ?></p>
                <p class="contact-desc"><?= $lang->get_string('contact_desc') ?></p>
                
                <a href="mailto:alessandroferraresi2006@gmail.com" class="contact-btn"><?= $lang->get_string('contact_btn') ?></a>
                
                <a href="./assets/docs/alessandro-ferraresi-CV.pdf" download class="contact-btn contact-btn--secondary">
                    <?= $lang->get_string('download_cv') ?>
                </a>

                <div class="contact-socials">
                    <a href="https://www.instagram.com/alessandro_ferraresi_/?hl=it" target="_blank" class="social-link"><?= $lang->get_string('contact_social_gh') ?></a>
                    <span class="social-divider">&bull;</span>
                    <a href="https://linkedin.com/in/alessandro-ferraresi-56ab04383" target="_blank" class="social-link"><?= $lang->get_string('contact_social_li') ?></a>
                </div>
            </div>
        </div>
        <div class="site-footer">
          <p class="footer-text">
            &copy; <?= date('Y') ?> Alessandro Ferraresi — <?= $lang->get_string('footer_rights') ?>
          </p>
        </div>
      </section>
    </div>

    <!-- Overlay e Card per i dettagli della Skill -->
    <div id="skillOverlay" class="skill-overlay"></div>
    <div id="skillCard" class="skill-card">
        <button class="skill-card-close" id="closeSkillCard">✕</button>
        <h3 class="skill-card-title" id="skillCardTitle">Nome Skill</h3>
        <p class="skill-card-desc" id="skillCardDesc">Descrizione della skill...</p>
    </div>

    <script>
      (function() {
  // Rileva mobile (per rimuovere SVG pesante)
  const isMobile = window.matchMedia('(max-width: 768px)').matches;
  if (isMobile) {
    const svgContainer = document.getElementById('contactSvgContainer');
    if (svgContainer) svgContainer.remove();
  }

  // Elementi principali
  const wrapper = document.getElementById("pageWrapper");
  const sections = document.querySelectorAll("section[id]");
  const navItems = document.querySelectorAll("#sideList li");
  const sideList = document.getElementById('sideList');

  let currentIndex = 0;
  let isAnimating = false;
  const TRANSITION_MS = 1000;

  // Variabili per la costellazione (dichiarate subito per evitare TDZ)
  let skillsData = [];
  let hoveredNodeId = null;
  let nodes = [];
  let constellationInitialized = false;
  let staticCanvas = null;
  let staticCtx = null;
  let mainCanvas, mainCtx, labelsContainer;

  history.scrollRestoration = 'manual';

  // ========== FUNZIONI DI NAVIGAZIONE ==========
  function getIndexFromHash() {
    const hash = window.location.hash.replace('#', '');
    if (!hash) return 0;
    const target = document.getElementById(hash);
    if (!target) return 0;
    return Array.from(sections).indexOf(target);
  }

  const originalHash = window.location.hash;
  if (originalHash) {
    history.replaceState(null, '', window.location.pathname + window.location.search);
  }

  wrapper.addEventListener('transitionstart', () => {
    wrapper.style.willChange = 'transform';
  });
  wrapper.addEventListener('transitionend', () => {
    wrapper.style.willChange = 'auto';
  });

function animateSectionContent(section) {
  const containers = section.querySelectorAll('.about-inner, .skills-inner, .projects-container, .contact-inner');
  containers.forEach(el => {
    el.classList.add('in-view');
    if (el.classList.contains('skills-inner')) {
      initConstellation();
    }
  });

  // Riavvia l'animazione delle accent-line nella sezione corrente
  const accentLines = section.querySelectorAll('.accent-line');
  accentLines.forEach(line => {
    line.classList.remove('animate-line');
    void line.offsetWidth;           // forza il reflow
    line.classList.add('animate-line');
  });
}

  let currentOffset = 0;
let onWrapperTransitionEnd = null;
let wrapperTransitionTimer = null;

function goToSection(index) {
  const clamped = Math.max(0, Math.min(sections.length - 1, index));
  const targetOffset = clamped * 100; // in vh
  if (clamped === currentIndex && targetOffset === currentOffset) return;

  // Rimuovi tutte le classi in-view (uscita animata)
  document.querySelectorAll('.about-inner, .skills-inner, .projects-container, .contact-inner')
    .forEach(el => el.classList.remove('in-view'));

  currentIndex = clamped;
  currentOffset = targetOffset;
  isAnimating = true;
  wrapper.style.transform = `translateY(-${targetOffset}vh)`;

  // Aggiorna menu laterale
  navItems.forEach(li => li.classList.remove("active"));
  const activeLi = document.querySelector(`#sideList li[data-target="${sections[currentIndex].id}"]`);
  if (activeLi) activeLi.classList.add("active");

  // Aggiorna hash
  const newHash = `#${sections[currentIndex].id}`;
  if (window.location.hash !== newHash) {
    history.pushState(null, '', newHash);
  }

  // --- Gestione caso iniziale (nessun movimento) ---
  if (targetOffset === 0 && wrapper.style.transform === '') {
    // Primo caricamento: nessuna transizione del wrapper, anima subito
    animateSectionContent(sections[currentIndex]);
    isAnimating = false;
    return;
  }

  // --- Aspetta la fine della transizione del wrapper ---
  if (onWrapperTransitionEnd) {
    wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
  }
  onWrapperTransitionEnd = () => {
    wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
    onWrapperTransitionEnd = null;
    animateSectionContent(sections[currentIndex]);
    isAnimating = false;
  };
  wrapper.addEventListener('transitionend', onWrapperTransitionEnd);

  // Timeout di sicurezza (se transitionend non scatta)
  clearTimeout(wrapperTransitionTimer);
  wrapperTransitionTimer = setTimeout(() => {
    if (onWrapperTransitionEnd) {
      wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
      onWrapperTransitionEnd = null;
      animateSectionContent(sections[currentIndex]);
    }
    isAnimating = false;
  }, TRANSITION_MS + 100);
}

  // ========== MAZZO DI CARTE (PROJECTS) ==========
  let cardIndex = 0;
  const maxCards = <?= count($phpProjects) ?> - 1;
  const cardDeck = document.getElementById('cardDeck');

  function updateCardDeck(index) {
    const cards = cardDeck.querySelectorAll('.project-card');
    const endIndicator = document.getElementById('endOfDeck');
    
    cards.forEach((card, i) => {
      if (i < index) {
        card.style.opacity = '0';
        card.style.transform = 'translateX(-120%) rotate(-15deg) scale(0.7)';
        card.style.zIndex = '0';
        card.style.pointerEvents = 'none';
      } else if (i === index) {
        card.style.opacity = '1';
        card.style.transform = 'translateX(0) rotate(0deg) scale(1)';
        card.style.zIndex = '10';
        card.style.pointerEvents = 'auto';
      } else {
        const stackOffset = (i - index) * 20; 
        card.style.opacity = '1';
        card.style.transform = `translateX(0) rotate(0deg) scale(${1 - (i - index) * 0.05}) translateY(-${stackOffset}px)`;
        card.style.zIndex = '5';
        card.style.pointerEvents = 'none';
      }
    });

    if (endIndicator) {
      endIndicator.style.opacity = index === maxCards ? '1' : '0';
      endIndicator.style.transform = index === maxCards ? 'translateY(0)' : 'translateY(20px)';
    }
  }

  // ========== SCROLL CUE (FRECCE) ==========
  document.querySelectorAll('.scroll-cue-wrapper').forEach(el => {
    el.addEventListener('click', (e) => {
      e.stopPropagation();
      if (isAnimating) return;
      const direction = el.dataset.direction === 'up' ? -1 : 1;
      const parentSection = el.closest('section');
      const idx = Array.from(sections).indexOf(parentSection);

      if (parentSection.id === 'projects') {
        if (direction === 1) {
          if (cardIndex < maxCards) { cardIndex++; updateCardDeck(cardIndex); }
          else { goToSection(idx + 1); }
        } else {
          if (cardIndex > 0) { cardIndex--; updateCardDeck(cardIndex); }
          else { goToSection(idx - 1); }
        }
        return;
      }

      goToSection(idx + direction);
    });
  });

  setTimeout(() => updateCardDeck(0), 100);

  // ========== GESTIONE SCROLL (mouse/trackpad) ==========
  function sectionCanScroll(el) {
    return el.scrollHeight > el.clientHeight + 1;
  }
  function sectionAtTop(el) {
    return el.scrollTop <= 0;
  }
  function sectionAtBottom(el) {
    return el.scrollTop + el.clientHeight >= el.scrollHeight - 1;
  }

  window.addEventListener("wheel", (e) => {
    if (isAnimating) return;
    const sectionEl = sections[currentIndex];
    const sectionId = sectionEl.id;

    if (sectionId === 'projects') {
      e.preventDefault();
      if (e.deltaY > 0) {
        if (cardIndex < maxCards) { cardIndex++; updateCardDeck(cardIndex); }
        else { goToSection(currentIndex + 1); }
      } else if (e.deltaY < 0) {
        if (cardIndex > 0) { cardIndex--; updateCardDeck(cardIndex); }
        else { goToSection(currentIndex - 1); }
      }
      return;
    }

    // Se la sezione ha overflow, lascia scorrere naturalmente
    if (sectionCanScroll(sectionEl)) {
      if (e.deltaY < 0 && !sectionAtTop(sectionEl)) return;
      if (e.deltaY > 0 && !sectionAtBottom(sectionEl)) return;
    }

    e.preventDefault();
    goToSection(currentIndex + (e.deltaY > 0 ? 1 : -1));
  }, { passive: false });

  // ========== GESTIONE TOUCH ==========
  let touchStartY = 0;
  window.addEventListener("touchstart", (e) => {
    touchStartY = e.touches[0].clientY;
  }, { passive: true });

  window.addEventListener("touchmove", (e) => {
    if (isAnimating) return;
    const sectionEl = sections[currentIndex];
    if (sectionEl.id === 'projects') {
      e.preventDefault();
      return;
    }
    if (sectionCanScroll(sectionEl)) {
      const currentY = e.touches[0].clientY;
      const delta = touchStartY - currentY;
      if (delta < 0 && !sectionAtTop(sectionEl)) return;
      if (delta > 0 && !sectionAtBottom(sectionEl)) return;
    }
    e.preventDefault();
  }, { passive: false });

  window.addEventListener("touchend", (e) => {
    if (isAnimating) return;
    const delta = touchStartY - e.changedTouches[0].clientY;
    if (Math.abs(delta) < 50) return;
    
    const sectionEl = sections[currentIndex];
    const sectionId = sectionEl.id;

    if (sectionId !== 'projects' && sectionCanScroll(sectionEl)) {
      if (delta < 0 && !sectionAtTop(sectionEl)) return;
      if (delta > 0 && !sectionAtBottom(sectionEl)) return;
    }

    if (sectionId === 'projects') {
      if (delta > 0) {
        if (cardIndex < maxCards) { cardIndex++; updateCardDeck(cardIndex); }
        else { goToSection(currentIndex + 1); }
      } else if (delta < 0) {
        if (cardIndex > 0) { cardIndex--; updateCardDeck(cardIndex); }
        else { goToSection(currentIndex - 1); }
      }
    } else {
      goToSection(currentIndex + (delta > 0 ? 1 : -1));
    }
  });

  // ========== TASTIERA ==========
  window.addEventListener("keydown", (e) => {
    if (isAnimating) return;
    const sectionId = sections[currentIndex].id;
    let direction = 0;
    if (["ArrowDown", "PageDown"].includes(e.key)) direction = 1;
    else if (["ArrowUp", "PageUp"].includes(e.key)) direction = -1;
    
    if (direction !== 0) {
      e.preventDefault();
      if (sectionId === 'projects') {
        if (direction === 1) {
          if (cardIndex < maxCards) { cardIndex++; updateCardDeck(cardIndex); }
          else { goToSection(currentIndex + 1); }
        } else {
          if (cardIndex > 0) { cardIndex--; updateCardDeck(cardIndex); }
          else { goToSection(currentIndex - 1); }
        }
      } else {
        goToSection(currentIndex + direction);
      }
    }
  });

  // ========== NAVIGAZIONE LATERALE (click) ==========
  sideList.addEventListener('click', (e) => {
    const li = e.target.closest('li');
    if (!li) return;
    if (isAnimating) return;
    const target = document.getElementById(li.dataset.target);
    const index = Array.from(sections).indexOf(target);
    if (target.id === 'projects') {
      cardIndex = 0;
      setTimeout(() => updateCardDeck(0), 300);
    }
    goToSection(index);
  });

  // ========== GESTIONE HASH ==========
  window.addEventListener("hashchange", () => {
    if (isAnimating) return;
    const newIndex = getIndexFromHash();
    if (sections[newIndex] && sections[newIndex].id === 'projects') {
      cardIndex = 0;
      setTimeout(() => updateCardDeck(0), 300);
    }
    goToSection(newIndex);
  });

  // ========== AVVIO ==========
  if (originalHash) {
    history.replaceState(null, '', originalHash);
  }
  const finalIndex = getIndexFromHash();
  goToSection(finalIndex);

  // Forza l'animazione sulla sezione iniziale (l'Observer potrebbe non averla ancora rilevata)
  const initialSection = sections[currentIndex];
  if (initialSection) {
    animateSectionContent(initialSection);
  }

  // ========== AVATAR FALLBACK ==========
  const avatarImg = document.getElementById("avatarImg");
  const avatarFallback = document.getElementById("avatarFallback");
  if (avatarImg) {
    const showFallback = () => {
      avatarImg.style.display = "none";
      if (avatarFallback) avatarFallback.style.display = "flex";
    };
    if (!avatarImg.getAttribute("src")) {
      showFallback();
    } else {
      avatarImg.addEventListener("error", showFallback);
    }
  }

  // ========== LINGUA ==========
  const langSwitcher = document.getElementById("langSwitcher");
  const langToggle = langSwitcher.querySelector(".lang-toggle");
  const langItems = langSwitcher.querySelectorAll(".lang-dropdown li");

  langToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    langSwitcher.classList.toggle("open");
  });

  langItems.forEach(item => {
    item.addEventListener("click", () => {
      const langCode = item.dataset.lang;
      if (item.classList.contains("active")) {
        langSwitcher.classList.remove("open");
        return;
      }
      fetch("./lang/set_language.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ lang: langCode })
      })
        .then((res) => res.json())
        .then((data) => {
          if (data && data.success) {
            window.location.reload();
          }
        })
        .catch((err) => console.error("Impossibile cambiare lingua:", err));
      langSwitcher.classList.remove("open");
    });
  });

  document.addEventListener("click", () => {
    langSwitcher.classList.remove("open");
  });

  // ========== COSTELLAZIONE ==========
  function initConstellation() {
    if (constellationInitialized) return;
    constellationInitialized = true;

    const container = document.getElementById('constellationContainer');
    if(!container) return;
    mainCanvas = document.getElementById('constellationCanvas');
    mainCtx = mainCanvas.getContext('2d');
    labelsContainer = document.getElementById('labelsContainer');

    skillsData = <?php echo json_encode($jsonSkills); ?>; 
    const connections = [
        [0,1], [0,9], [0,10],
        [1,2], [1,3], [1,9],
        [2,3], [2,9],
        [3,4], [3,7], [3,8],
        [4,5], [4,8],
        [5,6], [5,7], [5,11],
        [6,7], [6,11],
        [7,8], [7,11],
        [10,11],
        [5,10]
    ];

    labelsContainer.innerHTML = '';
    skillsData.forEach(skill => {
        const label = document.createElement('div');
        label.className = 'skill-label';
        label.dataset.id = skill.id;
        label.innerHTML = `<span class="skill-name">${skill.name}</span>`;
        label.addEventListener('click', () => openSkillCard(skill.id));
        labelsContainer.appendChild(label);
    });

    staticCanvas = document.createElement('canvas');
    staticCtx = staticCanvas.getContext('2d');

    function drawStaticLayer() {
      const w = container.offsetWidth;
      const h = container.offsetHeight;
      staticCanvas.width = w;
      staticCanvas.height = h;
      staticCtx.clearRect(0, 0, w, h);

      nodes = skillsData.map(s => ({...s, px: s.x * w, py: s.y * h}));

      connections.forEach(([fromIdx, toIdx]) => {
          const from = nodes[fromIdx];
          const to = nodes[toIdx];
          staticCtx.beginPath();
          staticCtx.moveTo(from.px, from.py);
          staticCtx.lineTo(to.px, to.py);
          staticCtx.strokeStyle = 'rgba(255, 255, 255, 0.20)';
          staticCtx.lineWidth = 1.8;
          staticCtx.shadowColor = 'rgba(228, 230, 234, 0.2)';
          staticCtx.shadowBlur = 10;
          staticCtx.stroke();
          staticCtx.shadowBlur = 0;
      });

      nodes.forEach(node => {
          staticCtx.beginPath(); 
          staticCtx.arc(node.px, node.py, 10, 0, Math.PI * 2);
          staticCtx.fillStyle = 'rgba(255, 255, 255, 0.1)';
          staticCtx.shadowColor = '#ffffff';
          staticCtx.shadowBlur = 25;
          staticCtx.fill();
          staticCtx.beginPath(); 
          staticCtx.arc(node.px, node.py, 4, 0, Math.PI * 2);
          staticCtx.fillStyle = '#ffffff';
          staticCtx.shadowBlur = 25;
          staticCtx.fill();
          staticCtx.shadowBlur = 0;
      });
    }

    function positionLabels() {
      const w = container.offsetWidth;
      const allLabels = labelsContainer.querySelectorAll('.skill-label');
      const labelOffsets = [];

      const sortedNodes = nodes.slice().sort((a, b) => a.py - b.py);

      sortedNodes.forEach(node => {
          const label = Array.from(allLabels).find(l => parseInt(l.dataset.id) === node.id);
          if (!label) return;

          const labelWidth = label.offsetWidth || 80;
          const labelHeight = label.offsetHeight || 20;
          const halfWidth = labelWidth / 2;
          const halfHeight = labelHeight / 2;

          let left, top;
          const margin = 30;

          if (node.x < 0.5) {
              left = node.px + margin;
          } else {
              left = node.px - margin - labelWidth;
          }

          if (left < 5) left = 5;
          if (left + labelWidth > w - 5) left = w - 5 - labelWidth;

          top = node.py - halfHeight;

          let overlap = true;
          let attempts = 0;
          const verticalStep = labelHeight + 4;

          while (overlap && attempts < 10) {
              overlap = false;
              for (const off of labelOffsets) {
                  if (Math.abs(left - off.left) < labelWidth && Math.abs(top - off.top) < labelHeight) {
                      overlap = true;
                      top += verticalStep;
                      break;
                  }
              }
              attempts++;
          }

          if (top < 5) top = 5;
          if (top + labelHeight > container.offsetHeight - 5) top = container.offsetHeight - 5 - labelHeight;

          label.style.left = (left + halfWidth) + 'px';
          label.style.top = top + 'px';

          labelOffsets.push({ left, top, id: node.id });
      });
    }

    function drawConstellation(hoverId = null) {
      const w = container.offsetWidth;
      const h = container.offsetHeight;
      mainCanvas.width = w;
      mainCanvas.height = h;
      mainCtx.clearRect(0, 0, w, h);
      mainCtx.drawImage(staticCanvas, 0, 0);

      if (hoverId !== null) {
        const node = nodes.find(n => n.id === hoverId);
        if (node) {
          mainCtx.beginPath(); 
          mainCtx.arc(node.px, node.py, 18, 0, Math.PI * 2);
          mainCtx.fillStyle = 'rgba(255, 255, 255, 0.3)';
          mainCtx.shadowColor = '#ffffff';
          mainCtx.shadowBlur = 50;
          mainCtx.fill();
          mainCtx.beginPath(); 
          mainCtx.arc(node.px, node.py, 8, 0, Math.PI * 2);
          mainCtx.fillStyle = '#ffffff';
          mainCtx.shadowBlur = 25;
          mainCtx.fill();
          mainCtx.shadowBlur = 0;
        }
      }

      positionLabels();
    }

    drawStaticLayer();
    drawConstellation(null);

    let hoverRAF = null;
    mainCanvas.addEventListener('mousemove', (e) => {
      if (hoverRAF) return;
      hoverRAF = requestAnimationFrame(() => {
        hoverRAF = null;
        const rect = mainCanvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;
        let found = false;
        for (let node of nodes) {
          const dx = mouseX - node.px, dy = mouseY - node.py;
          if (Math.sqrt(dx*dx + dy*dy) < 25) {
            if (hoveredNodeId !== node.id) {
              hoveredNodeId = node.id;
              drawConstellation(hoveredNodeId);
              mainCanvas.style.cursor = 'pointer';
            }
            found = true;
            break;
          }
        }
        if (!found && hoveredNodeId !== null) {
          hoveredNodeId = null;
          drawConstellation(null);
          mainCanvas.style.cursor = 'default';
        }
      });
    });

    mainCanvas.addEventListener('click', (e) => {
      const rect = mainCanvas.getBoundingClientRect();
      const mouseX = e.clientX - rect.left, mouseY = e.clientY - rect.top;
      for (let node of nodes) {
        const dx = mouseX - node.px, dy = mouseY - node.py;
        if (Math.sqrt(dx*dx + dy*dy) < 25) { openSkillCard(node.id); break; }
      }
    });

    let resizeTimeout = null;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        drawStaticLayer();
        drawConstellation(hoveredNodeId);
      }, 150);
    });
  }

  // ========== SKILL CARD ==========
  const overlay = document.getElementById('skillOverlay');
  const card = document.getElementById('skillCard');
  const cardTitle = document.getElementById('skillCardTitle');
  const cardDesc = document.getElementById('skillCardDesc');
  const closeBtn = document.getElementById('closeSkillCard');

  function openSkillCard(id) {
      const skill = skillsData.find(s => s.id === id);
      if(!skill) return;
      cardTitle.textContent = skill.name;
      cardDesc.textContent = skill.desc;
      overlay.classList.add('active');
      card.classList.add('active');
  }
  function closeSkillCardFn() {
      overlay.classList.remove('active');
      card.classList.remove('active');
  }
  closeBtn.addEventListener('click', closeSkillCardFn);
  overlay.addEventListener('click', closeSkillCardFn);
  
  // Inizializza la costellazione se la sezione skills è già visibile
  if (document.getElementById('skills').getBoundingClientRect().top < window.innerHeight) {
      setTimeout(initConstellation, 100);
  }
})();
    </script>
  </body>
</html>