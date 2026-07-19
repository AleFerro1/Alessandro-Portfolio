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
        'img' => '/assets/img/project1.png',
        'tags' => ['LAMP', 'WebSocket', 'REST API']
    ],
];

session_write_close();
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alessandro Ferraresi — Junior Web Developer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link rel="stylesheet" href="./css/portfolio.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <!-- Language Switcher -->
    <div class="lang-switcher" id="langSwitcher">
      <button class="lang-toggle">
        <!-- Bandierina nel pulsante principale -->
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
        <video id="bg-video" autoplay muted loop playsinline>
          <source src="./assets/video/wallpaper1.mp4" type="video/mp4" />
        </video>
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
        <div class="about-bg"></div>
        <div class="about-overlay"></div>
        <div class="about-inner">
            <div class="about-avatar">
              <img id="avatarImg" src="" alt="Alessandro Ferraresi" />
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
        <div class="skills-bg"></div>
        <div class="skills-overlay"></div>
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
        <div class="projects-bg"></div>
        <div class="projects-overlay"></div>
        
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
                              <img src="./<?= htmlspecialchars($project['img']) ?>" alt="<?= htmlspecialchars($project['name']) ?> preview" class="mockup-img-photo" />
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
        <!-- Contenitore SVG posizionato assolutamente -->
        <div class="contact-svg-container">
          <svg width="100%" height="100%" viewBox="0 0 690 410" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <title>Vermi scuri striscianti</title>
            <desc>Texture frattale statica, animata via CSS transform anziché ricalcolata ad ogni frame.</desc>

            <filter id="vermi" x="-15%" y="-15%" width="130%" height="130%" color-interpolation-filters="sRGB">
              <feTurbulence type="fractalNoise" baseFrequency="0.025" numOctaves="1" seed="11" stitchTiles="stitch" result="noiseBase" />
              <feColorMatrix in="noiseBase" type="matrix"
                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1.2 -0.5" result="threshold" />
              <feMorphology in="threshold" operator="erode" radius="0.6" result="worms" />

              <feTurbulence type="fractalNoise" baseFrequency="0.008" numOctaves="1" seed="57" stitchTiles="stitch" result="distortionMap" />
              <feDisplacementMap in="worms" in2="distortionMap" scale="10" xChannelSelector="R" yChannelSelector="G" result="twistedWorms" />

              <feComponentTransfer in="twistedWorms">
                <feFuncR type="linear" slope="0.5" intercept="0" />
                <feFuncG type="linear" slope="0.5" intercept="0" />
                <feFuncB type="linear" slope="0.5" intercept="0" />
              </feComponentTransfer>
            </filter>

            <rect x="0" y="0" width="690" height="410" filter="url(#vermi)" />
          </svg>
        </div>

        <!-- Overlay per la leggibilità (scurisce leggermente i bordi) -->
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

        
    </section>

    <script>
      // ... (Tutto il tuo JavaScript precedente rimane identico fino all'Observer)
      const video = document.getElementById("bg-video");
      video.playbackRate = 0.78;

      const wrapper = document.getElementById("pageWrapper");
      const sections = document.querySelectorAll("section[id]");
      const navItems = document.querySelectorAll("#sideList li");

      let currentIndex = 0;
      let isAnimating = false;
      const TRANSITION_MS = 1000;

      history.scrollRestoration = 'manual';

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

      function goToSection(index) {
        const clamped = Math.max(0, Math.min(sections.length - 1, index));
        if (clamped === currentIndex && wrapper.style.transform) return;

        currentIndex = clamped;
        isAnimating = true;
        wrapper.style.transform = `translateY(-${currentIndex * 100}vh)`;

        navItems.forEach(li => li.classList.remove("active"));
        const activeLi = document.querySelector(`#sideList li[data-target="${sections[currentIndex].id}"]`);
        if (activeLi) activeLi.classList.add("active");

        const newHash = `#${sections[currentIndex].id}`;
        if (window.location.hash !== newHash) {
          history.pushState(null, '', newHash);
        }

        clearTimeout(window.scrollTimeout);
        window.scrollTimeout = setTimeout(() => {
          isAnimating = false;
        }, TRANSITION_MS);
      }

      let cardIndex = 0;
      let maxCards = <?= count($phpProjects) ?> - 1;
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

          if (index === maxCards) {
              endIndicator.style.opacity = '1';
              endIndicator.style.transform = 'translateY(0)';
          } else {
              endIndicator.style.opacity = '0';
              endIndicator.style.transform = 'translateY(20px)';
          }
      }

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
                    
      window.addEventListener("wheel", (e) => {
        if (isAnimating) return;
        const sectionId = sections[currentIndex].id;

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

        e.preventDefault();
        if (isAnimating) return;
        goToSection(currentIndex + (e.deltaY > 0 ? 1 : -1));
      }, { passive: false });

      let touchStartY = 0;
      window.addEventListener("touchstart", (e) => {
        touchStartY = e.touches[0].clientY;
      }, { passive: true });
      window.addEventListener("touchmove", (e) => {
        e.preventDefault();
      }, { passive: false });
      window.addEventListener("touchend", (e) => {
        if (isAnimating) return;
        const delta = touchStartY - e.changedTouches[0].clientY;
        if (Math.abs(delta) < 50) return;
        
        const sectionId = sections[currentIndex].id;
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

      navItems.forEach(li => {
        li.addEventListener("click", () => {
          if (isAnimating) return;
          const target = document.getElementById(li.dataset.target);
          const index = Array.from(sections).indexOf(target);
          if (target.id === 'projects') {
              cardIndex = 0;
              setTimeout(() => updateCardDeck(0), 300);
          }
          goToSection(index);
        });
      });

      window.addEventListener("hashchange", () => {
        if (isAnimating) return;
        const newIndex = getIndexFromHash();
        if (sections[newIndex] && sections[newIndex].id === 'projects') {
            cardIndex = 0;
            setTimeout(() => updateCardDeck(0), 300);
        }
        goToSection(newIndex);
      });

      // Aggiornato l'Observer per includere la nuova sezione Contact
      const revealElements = document.querySelectorAll(".about-inner, .skills-inner, .projects-container, .contact-inner");
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("in-view");
            if(entry.target.classList.contains('skills-inner')) {
              initConstellation(); 
            }
          }
        });
      }, { threshold: 0.15 });

      revealElements.forEach(el => revealObserver.observe(el));

      if (originalHash) {
        history.replaceState(null, '', originalHash);
      }
      const finalIndex = getIndexFromHash();
      goToSection(finalIndex);

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

      // LOGICA COSTELLAZIONE (identica)
      let skillsData = [];
      let hoveredNodeId = null;
      let nodes = [];

      function initConstellation() {
        const container = document.getElementById('constellationContainer');
        if(!container) return;
        const canvas = document.getElementById('constellationCanvas');
        const ctx = canvas.getContext('2d');
        const labelsContainer = document.getElementById('labelsContainer');

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
            label.addEventListener('mouseenter', () => {
                hoveredNodeId = skill.id;
                drawConstellation(hoveredNodeId);
            });
            label.addEventListener('mouseleave', () => {});
            label.addEventListener('click', () => {
                openSkillCard(skill.id);
            });
            labelsContainer.appendChild(label);
        });

        function drawConstellation(hoverId = null) {
            const w = container.offsetWidth;
            const h = container.offsetHeight;
            canvas.width = w;
            canvas.height = h;
            ctx.clearRect(0, 0, w, h);
            nodes = skillsData.map(s => ({...s, px: s.x * w, py: s.y * h}));
            const allLabels = labelsContainer.querySelectorAll('.skill-label');
            allLabels.forEach(label => {
                const id = parseInt(label.dataset.id);
                const node = nodes.find(n => n.id === id);
                if(node) {
                    let top = node.py + 28;
                    if (node.y > 0.7) top = node.py - 55;
                    label.style.left = (node.px - 70) + 'px';
                    label.style.top = top + 'px';
                }
            });
            connections.forEach(([fromIdx, toIdx]) => {
                const from = nodes[fromIdx];
                const to = nodes[toIdx];
                ctx.beginPath();
                ctx.moveTo(from.px, from.py);
                ctx.lineTo(to.px, to.py);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.20)';
                ctx.lineWidth = 1.8;
                ctx.shadowColor = 'rgba(228, 230, 234, 0.2)';
                ctx.shadowBlur = 10;
                ctx.stroke();
                ctx.shadowBlur = 0;
            });
            nodes.forEach(node => {
                let outerRadius = 10, innerRadius = 4, glowSize = 25, glowColor = 'rgba(255, 255, 255, 0.1)';
                if (hoverId !== null && node.id === hoverId) {
                    outerRadius = 18; innerRadius = 8; glowSize = 50; glowColor = 'rgba(255, 255, 255, 0.3)';
                }
                ctx.beginPath(); ctx.arc(node.px, node.py, outerRadius, 0, Math.PI * 2);
                ctx.fillStyle = glowColor; ctx.shadowColor = '#ffffff'; ctx.shadowBlur = glowSize; ctx.fill();
                ctx.beginPath(); ctx.arc(node.px, node.py, innerRadius, 0, Math.PI * 2);
                ctx.fillStyle = '#ffffff'; ctx.shadowBlur = 25; ctx.fill(); ctx.shadowBlur = 0;
            });
        }

        canvas.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;
            let found = false;
            for (let node of nodes) {
                const dx = mouseX - node.px, dy = mouseY - node.py;
                if (Math.sqrt(dx*dx + dy*dy) < 25) {
                    if (hoveredNodeId !== node.id) {
                        hoveredNodeId = node.id; drawConstellation(hoveredNodeId); canvas.style.cursor = 'pointer';
                    }
                    found = true; break;
                }
            }
            if (!found && hoveredNodeId !== null) {
                hoveredNodeId = null; drawConstellation(null); canvas.style.cursor = 'default';
            }
        });
        canvas.addEventListener('click', (e) => {
            const rect = canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left, mouseY = e.clientY - rect.top;
            for (let node of nodes) {
                const dx = mouseX - node.px, dy = mouseY - node.py;
                if (Math.sqrt(dx*dx + dy*dy) < 25) { openSkillCard(node.id); break; }
            }
        });
        window.addEventListener('resize', () => drawConstellation(hoveredNodeId));
        drawConstellation(null);
      }

      const overlay = document.getElementById('skillOverlay');
      const card = document.getElementById('skillCard');
      const cardTitle = document.getElementById('skillCardTitle');
      const cardLevel = document.getElementById('skillCardLevel');
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
      
      if (document.getElementById('skills').getBoundingClientRect().top < window.innerHeight) {
          setTimeout(initConstellation, 100);
      }
    </script>
  </body>
</html>