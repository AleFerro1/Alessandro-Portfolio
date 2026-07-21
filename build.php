<?php
// Combina e minifica CSS
$cssFiles = [
    'css/main.css',
    'css/hero.css',
    'css/accent-lines.css',
    'css/side-nav.css',
    'css/scroll-cue.css',
    'css/backgrounds.css',
    'css/about.css',
    'css/skills-section.css',
    'css/lang-switcher.css',
    'css/constellation.css',
    'css/skill-card.css',
    'css/projects.css',
    'css/contact.css',
    'css/footer.css',
    'css/orb-animations.css',
    'css/responsive.css',
    'css/preloader.css'
];
$cssContent = '';
foreach ($cssFiles as $file) {
    $content = file_get_contents($file);
    // Minificazione base: rimuove commenti, spazi, newline
    $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
    $content = str_replace(["\r\n","\r","\n","\t"], '', $content);
    $content = preg_replace('/\s+/', ' ', $content);
    $cssContent .= $content;
}
file_put_contents('dist/style.min.css', $cssContent);

// Combina e minifica JS 
$jsFiles = [
    'js/preloader.js',      // se esiste, altrimenti commentalo
    'js/navigation.js',     // definisce getIndexFromHash, goToSection, animateSectionContent
    'js/projects.js',       // definisce cardIndex, maxCards, updateCardDeck
    'js/avatar.js',
    'js/language.js',
    'js/lazy-loading.js',
    'js/skill-card.js',
    'js/constellation.js',  // definisce initConstellation
    'js/main.js'            // usa tutte le funzioni precedenti
];
$jsContent = '';
foreach ($jsFiles as $file) {
    $content = file_get_contents($file);
    // Minificazione base: rimuove commenti e spazi
    $content = preg_replace('#//.*#', '', $content);
    $content = str_replace(["\r\n","\r","\n","\t"], '', $content);
    $content = preg_replace('/\s+/', ' ', $content);
    $jsContent .= ';' . $content;
}
file_put_contents('dist/script.min.js', $jsContent);

echo "Build completata";