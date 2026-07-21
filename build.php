<?php
// Combina e minifica CSS
$cssFiles = [
    'css/about.css', 'css/accent-lines.css', 'css/backgrounds.css', 'css/constellation.css',
    'css/contact.css', 'css/footer.css', 'css/hero.css', 'css/lang-switcher.css',
    'css/main.css', 'css/orb-animations.css', 'css/projects.css', 'css/responsive.css',
    'css/scroll-cue.css', 'css/side-nav.css', 'css/skill-card.css', 'css/skills-section.css'
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
    'js/avatar.js', 'js/constellation.js', 'js/language.js', 'js/lazy-loading.js',
    'js/main.js', 'js/navigation.js', 'js/preloader.js', 'js/projects.js',
    'js/skill-card.js'
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