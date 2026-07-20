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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet"
    />
    <style>
      /* ========== VARIABILI E RESET ========== */
      :root {
        --bg: #09090C;
        --title: #ffffff;
        --subtitle: rgba(238, 238, 238, 0.5);
        --muted: #b3b3b3;
        --accent: #e4e6ea;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      html {
        scroll-behavior: smooth;
        height: 100%;
      }

      body {
        background: var(--bg);
        font-family: "Inter", sans-serif;
        height: 100%;
        overflow: hidden;
      }

      section {
        height: 100vh;
        content-visibility: auto;
        contain-intrinsic-size: auto 100vh;
      }

      .page-wrapper {
        transition: transform 1s cubic-bezier(0.76, 0, 0.24, 1);
        will-change: auto;
      }

      /* ========== HERO ========== */
      .hero {
        height: 100vh;
        position: relative;
        overflow: hidden;
      }

      .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(11, 11, 15, 0.25) 0%, rgba(11, 11, 15, 0.35) 45%, rgba(11, 11, 15, 0.8) 100%);
        z-index: 1;
        pointer-events: none;
      }

      .titleContainer {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 2;
        text-align: center;
        padding: 0 6%;
      }

      .title {
        font-family: "Inter", sans-serif;
        font-weight: 250;
        font-size: clamp(1.7rem, 7.4vw, 5.2rem);
        line-height: 1.1;
        letter-spacing: 0.5px;
        white-space: nowrap;
        text-align: center;
        background: linear-gradient(180deg, #ffffff 0%, #f2f3f8 55%, var(--accent) 130%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        filter: drop-shadow(0 8px 26px rgba(0, 0, 0, 0.45));
        opacity: 0;
        animation: heroFadeUp 1.1s cubic-bezier(0.16, 0.84, 0.44, 1) 0.1s forwards;
      }

      .accent-line {
        width: 46px;
        height: 2px;
        margin: 24px auto 16px;
        background: var(--accent);
        box-shadow: 0 0 14px var(--accent), 0 0 28px rgba(228, 230, 234, 0.5);
        transform-origin: center;
        opacity: 0;
        animation: lineGrow 0.9s cubic-bezier(0.16, 0.84, 0.44, 1) 0.55s forwards;
      }

      .subtitle {
        font-family: "Inter", sans-serif;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.65);
        font-size: clamp(0.85rem, 1.6vw, 1.1rem);
        letter-spacing: 4px;
        text-transform: uppercase;
        text-align: center;
        opacity: 0;
        animation: heroFadeUp 1s cubic-bezier(0.16, 0.84, 0.44, 1) 0.75s forwards;
      }

      @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to { opacity: 1; transform: translateY(0); }
      }

      @keyframes lineGrow {
        from { opacity: 0; transform: scaleX(0); }
        to { opacity: 1; transform: scaleX(1); }
      }

      /* ========== NAVIGAZIONE LATERALE (desktop) ========== */
      .side-list {
        position: fixed;
        top: 50%;
        left: 5%;
        transform: translateY(-50%);
        list-style: none;
        z-index: 50;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .side-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: "Inter", sans-serif;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        color: #ffffff;
        cursor: pointer;
        opacity: 0.35;
        transform: scale(1);
        transform-origin: left center;
        transition: opacity 0.4s ease, text-shadow 0.4s ease, transform 0.4s ease, font-weight 0.4s ease;
      }

      .side-list li::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        background: transparent;
        border: 1.5px solid rgba(255, 255, 255, 0.6);
        transition: background 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease, width 0.4s ease, height 0.4s ease;
      }

      .side-list li.active {
        opacity: 1;
        font-weight: 600;
        font-size: 1.12rem;
        transform: scale(1.08);
        text-shadow: 0 0 10px var(--accent), 0 0 24px rgba(255, 255, 255, 0.6), 0 0 42px rgba(255, 255, 255, 0.25);
      }

      .side-list li.active::before {
        width: 10px;
        height: 10px;
        background: var(--accent);
        border-color: var(--accent);
        box-shadow: 0 0 10px var(--accent), 0 0 22px rgba(255, 255, 255, 0.7), 0 0 36px rgba(255, 255, 255, 0.3);
      }

      .side-list li:hover { opacity: 0.7; }
      .side-list li.active:hover { opacity: 1; }

      /* Scroll cue */
      .scroll-cue-wrapper {
        position: absolute;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        cursor: pointer;
      }

      .hero .scroll-cue-wrapper {
        bottom: 32px;
        left: 50%;
        transform: translateX(-50%);
      }

      .scroll-cue-wrapper--section {
        bottom: 6%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
      }

      .scroll-cue-label {
        font-family: "Inter", sans-serif;
        font-weight: 400;
        font-size: 0.72rem;
        letter-spacing: 1.6px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.5);
        white-space: nowrap;
        transition: color 0.3s ease;
      }

      .scroll-cue {
        width: 44px;
        height: 44px;
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 14px rgba(255, 255, 255, 0.06);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
      }

      .scroll-cue-wrapper:hover .scroll-cue-label { color: rgba(255, 255, 255, 0.85); }
      .scroll-cue-wrapper:hover .scroll-cue {
        border-color: rgba(255, 255, 255, 0.6);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.12);
      }

      .scroll-cue::before {
        content: "";
        width: 9px;
        height: 9px;
        border-right: 2px solid rgba(255, 255, 255, 0.8);
        border-bottom: 2px solid rgba(255, 255, 255, 0.8);
        transform: translateY(-2px) rotate(45deg);
        animation: arrowBounceY 1.6s ease-in-out infinite;
      }

      @keyframes arrowBounceY {
        0%, 100% { transform: translateY(-2px) rotate(45deg); opacity: 0.6; }
        50% { transform: translateY(3px) rotate(45deg); opacity: 1; }
      }

      .scroll-cue-wrapper--up {
        top: 6%;
        bottom: auto;
        left: 50%;
        transform: translateX(-50%);
      }

      .scroll-cue--up::before {
        transform: translateY(2px) rotate(-135deg);
        animation: arrowBounceUp 1.6s ease-in-out infinite;
      }

      @keyframes arrowBounceUp {
        0%, 100% { transform: translateY(2px) rotate(-135deg); opacity: 0.6; }
        50% { transform: translateY(-3px) rotate(-135deg); opacity: 1; }
      }

      /* ========== CLASSI BASE SFONDI E OVERLAY ========== */
      .section-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        background-size: cover;
        background-position: center bottom;
        background-repeat: no-repeat;
        transform-origin: center bottom;
      }

      .about-bg {
        background-image: url("/assets/img/moon.webp");
        filter: brightness(0.82) contrast(1.05);
        animation: moonDrift 30s ease-in-out infinite alternate;
      }

      .skills-bg {
        background-image: url("/assets/img/moondown.webp");
        filter: brightness(0.82) contrast(1.05);
        animation: moonDrift 30s ease-in-out infinite alternate;
      }

      .projects-bg {
        background-image: url("/assets/img/earth.webp");
        filter: brightness(0.85) contrast(1.1);
        animation: earthDrift 20s ease-in-out infinite alternate;
      }

      @keyframes moonDrift {
        from { transform: scale(1); }
        to { transform: scale(1.07); }
      }

      @keyframes earthDrift {
        from { transform: scale(1); }
        to { transform: scale(1.03); }
      }

      .section-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
      }

      .about-overlay {
        background: linear-gradient(180deg, #09090C 0%, rgba(6, 6, 8, 0.5) 35%, rgba(6, 6, 8, 0.88) 100%), radial-gradient(circle at 50% 62%, rgba(6, 6, 8, 0.15) 0%, rgba(6, 6, 8, 0.82) 68%);
      }

      .skills-overlay {
        background: linear-gradient(180deg, rgba(6, 6, 8, 0.88) 0%, rgba(6, 6, 8, 0.5) 35%, rgba(6, 6, 8, 0.88) 100%), radial-gradient(circle at 50% 62%, rgba(6, 6, 8, 0.15) 0%, rgba(6, 6, 8, 0.82) 68%);
      }

      .projects-overlay {
        background: linear-gradient(180deg, rgba(6, 6, 8, 0.88) 0%, rgba(6, 6, 8, 0.5) 35%, rgb(0, 0, 0) 100%), radial-gradient(circle at 50% 62%, rgba(6, 6, 8, 0.15) 0%, rgba(6, 6, 8, 0.82) 68%);
      }

      /* ========== ABOUT ME ========== */
      .about_me {
        height: 100vh;
        position: relative;
        overflow: hidden;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6%;
      }

      .about-text a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        position: relative;
        transition: color 0.3s ease;
      }

      .about-text a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 1px;
        background: var(--accent);
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
      }

      .about-text a:hover {
        color: #ffffff;
      }

      .about-text a:hover::after {
        transform: scaleX(1);
        transform-origin: left;
      }

      .about-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 3rem;
        max-width: 960px;
        width: 100%;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.9s cubic-bezier(0.16, 0.84, 0.44, 1), transform 0.9s cubic-bezier(0.16, 0.84, 0.44, 1);
      }

      .about-inner.in-view { opacity: 1; transform: translateY(0); }

      .about-avatar {
        position: relative;
        flex-shrink: 0;
        width: 180px;
        height: 180px;
      }

      .about-avatar::before {
        content: "";
        position: absolute;
        inset: -34px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 72%);
        pointer-events: none;
      }

      .about-avatar img, .avatar-fallback {
        position: absolute;
        inset: 0;
        width: 180px;
        height: 180px;
        border-radius: 50%;
      }

      .about-avatar img {
        object-fit: cover;
        display: block;
        border: 2px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.16), 0 0 60px rgba(255, 255, 255, 0.07);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
      }

      .about-avatar img:hover { transform: scale(1.05); box-shadow: 0 0 45px rgba(255, 255, 255, 0.26), 0 0 80px rgba(255, 255, 255, 0.12); }

      .avatar-fallback {
        display: none;
        align-items: center;
        justify-content: center;
        font-family: "Inter", sans-serif;
        font-weight: 600;
        font-size: 2.6rem;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.85);
        background: linear-gradient(160deg, #1c1c22 0%, #0a0a0d 100%);
        border: 2px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.1), 0 0 60px rgba(255, 255, 255, 0.05);
      }

      .about-content {
        position: relative;
        max-width: 670px;
        padding: 2.3rem 2.4rem;
        border-radius: 30px 8px 30px 8px;
        border: 1px solid transparent;
        background: linear-gradient(rgba(255, 255, 255, 0.035), rgba(255, 255, 255, 0.02)) padding-box, linear-gradient(135deg, rgba(105, 105, 105, 0.42) 0%, rgba(255, 255, 255, 0.05) 22%, rgba(255, 255, 255, 0.02) 40%, rgba(63, 63, 63, 0.3) 58%, rgba(255, 255, 255, 0.02) 76%, rgba(83, 82, 82, 0.42) 100%) border-box;
        background-size: 100% 100%, 320% 320%;
        animation: borderShimmer 25s ease-in-out infinite;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 25px 55px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
      }

      @keyframes borderShimmer {
        0% { background-position: 0% 0%, 0% 0%; }
        50% { background-position: 0% 0%, 100% 100%; }
        100% { background-position: 0% 0%, 0% 0%; }
      }

      .about-content:hover { transform: translateY(-4px); box-shadow: 0 32px 65px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.14); }

      .about-content::before, .about-content::after {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        pointer-events: none;
        opacity: 0.55;
      }

      .about-content::before { top: 12px; left: 12px; border-top: 1.5px solid rgba(255, 255, 255, 0.7); border-left: 1.5px solid rgba(255, 255, 255, 0.7); }
      .about-content::after { bottom: 12px; right: 12px; border-bottom: 1.5px solid rgba(255, 255, 255, 0.7); border-right: 1.5px solid rgba(255, 255, 255, 0.7); }

      .about-title {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: clamp(2rem, 5vw, 3rem);
        color: var(--title);
        letter-spacing: 0.5px;
        margin: 0 0 0.5rem;
        text-align: left;
      }

      .accent-line--about {
        position: relative;
        animation: none;
        opacity: 1;
        transform: scaleX(1);
        margin: 0 0 1.6rem 4px;
        width: 64px;
        height: 2px;
        background: linear-gradient(90deg, var(--accent) 0%, rgba(228, 230, 234, 0) 100%);
      }

      .accent-line--about::before {
        content: "";
        position: absolute;
        left: -4px;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 8px var(--accent), 0 0 14px rgba(228, 230, 234, 0.5);
      }

      .about-text {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: clamp(0.95rem, 1.6vw, 1.1rem);
        line-height: 1.75;
        color: var(--muted);
        text-align: left;
      }

      .about-text strong { color: #ffffff; font-weight: 500; }

      /* ========== SKILLS ========== */
      .skills_section {
        height: 100vh;
        position: relative;
        overflow: hidden;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6%;
      }

      .skills-inner {
        position: relative;
        z-index: 2;
        max-width: 1180px;
        width: 100%;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.9s cubic-bezier(0.16, 0.84, 0.44, 1), transform 0.9s cubic-bezier(0.16, 0.84, 0.44, 1);
      }

      .skills-inner.in-view { opacity: 1; transform: translateY(0); }

      /* ========== LANG SWITCHER ========== */
      .lang-switcher {
        position: fixed;
        top: 24px;
        right: 28px;
        z-index: 100;
        font-family: "Inter", sans-serif;
      }

      .lang-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 40px;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.4px;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.16, 0.84, 0.44, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.06);
      }

      .lang-toggle:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.35);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(255, 255, 255, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
      }

      .lang-name { font-weight: 500; }

      .lang-chevron {
        color: rgba(255, 255, 255, 0.6);
        transition: transform 0.35s ease, color 0.3s;
        font-size: 0.8rem;
      }

      .lang-switcher.open .lang-chevron {
        transform: rotate(180deg);
        color: #ffffff;
      }

      .lang-toggle .fi {
        font-size: 1.2rem;
        border-radius: 3px;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
      }

      .lang-toggle:hover .fi { transform: scale(1.08); }

      .lang-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        list-style: none;
        background: rgba(15, 15, 20, 0.9);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 8px 0;
        min-width: 170px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.04) inset;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.96);
        transition: all 0.3s cubic-bezier(0.16, 0.84, 0.44, 1);
        transform-origin: top right;
        overflow: hidden;
      }

      .lang-switcher.open .lang-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
      }

      .lang-dropdown li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
      }

      .lang-dropdown li:hover { background: rgba(255, 255, 255, 0.06); color: #ffffff; }

      .lang-dropdown li.active {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
        font-weight: 600;
      }

      .lang-dropdown li.active::after {
        content: "";
        position: absolute;
        right: 18px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 10px var(--accent), 0 0 20px rgba(228, 230, 234, 0.6);
      }

      .lang-dropdown .fi {
        font-size: 1.25rem;
        border-radius: 3px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
      }

      /* ========== COSTELLAZIONE ========== */
      .constellation-wrapper {
        position: relative;
        width: 100%;
        min-height: 480px;
        height: 65vh;
        margin-top: 1.5rem;
        overflow: hidden;
      }

      .constellation-wrapper canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        cursor: pointer;
      }

      #labelsContainer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
      }

      .skill-label {
        position: absolute;
        transform: translateX(-50%);
        text-align: center;
        font-family: "Inter", sans-serif;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        font-size: clamp(0.75rem, 1.2vw, 0.95rem);
        letter-spacing: 0.5px;
        background: rgba(6, 6, 8, 0.4);
        backdrop-filter: blur(4px);
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        white-space: nowrap;
        transition: all 0.4s ease;
        pointer-events: auto;
      }

      .skill-label .skill-name { display: inline-block; text-shadow: 0 2px 12px rgba(0,0,0,0.8); }
      .skill-label:hover { color: #ffffff; background: rgba(255, 255, 255, 0.15); box-shadow: 0 0 20px rgba(255, 255, 255, 0.1); transform: translateX(-50%) scale(1.05); }

      /* ========== SKILL CARD ========== */
      .skill-overlay {
        position: fixed;
        inset: 0;
        background: rgba(6, 6, 8, 0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 200;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
      }

      .skill-overlay.active { opacity: 1; visibility: visible; }

      .skill-card {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        z-index: 201;
        max-width: 460px;
        width: 90%;
        padding: 2.5rem 2.5rem 2rem;
        background: rgba(16, 16, 20, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6), 0 0 40px rgba(255, 255, 255, 0.05);
        opacity: 0;
        visibility: hidden;
        transition: transform 0.4s cubic-bezier(0.16, 0.84, 0.44, 1), opacity 0.4s cubic-bezier(0.16, 0.84, 0.44, 1), visibility 0.4s ease;
      }

      .skill-card.active { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1); }
      .skill-card-close {
        position: absolute;
        top: 16px;
        right: 18px;
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.4rem;
        cursor: pointer;
        transition: color 0.3s, transform 0.3s;
        padding: 4px 6px;
      }
      .skill-card-close:hover { color: #ffffff; transform: rotate(90deg); }

      .skill-card-title { font-family: "Inter", sans-serif; font-weight: 400; font-size: 2.2rem; color: #ffffff; margin-bottom: 0.2rem; }
      .skill-card-level {
        display: inline-block;
        font-family: "Inter", sans-serif;
        font-weight: 500;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: var(--accent);
        background: rgba(255, 255, 255, 0.08);
        padding: 4px 14px;
        border-radius: 40px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        margin-bottom: 1.5rem;
        text-transform: uppercase;
      }
      .skill-card-desc { 
        font-family: "Inter", sans-serif;
        font-weight: 300; 
        font-size: 1rem; 
        line-height: 1.7; 
        color: var(--muted); 
        margin-top: 20px;
      }

      /* ============================================================
         MAZZO DI CARTE (PROJECTS)
         ============================================================ */
      .projects_section {
        height: 100vh;
        position: relative;
        overflow: hidden;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4%;
      }

      .projects-container {
        position: relative;
        z-index: 2;
        max-width: 1350px;
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.9s cubic-bezier(0.16, 0.84, 0.44, 1), transform 0.9s cubic-bezier(0.16, 0.84, 0.44, 1);
      }

      .projects-container.in-view { opacity: 1; transform: translateY(0); }

      .projects-deck-title {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: clamp(2rem, 5vw, 3rem);
        color: var(--title);
        letter-spacing: 0.5px;
        margin: 0 0 0.5rem;
        text-align: center;
      }

      .card-deck {
        position: relative;
        width: 100%;
        height: 65vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .project-card {
        position: absolute;
        width: 100%;
        max-width: 1200px;
        height: auto;
        background: rgba(10, 10, 12, 0.75);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.8), 0 0 30px rgba(255, 255, 255, 0.02);
        padding: 2.5rem 3rem;
        transition: transform 0.6s cubic-bezier(0.16, 0.84, 0.44, 1), opacity 0.6s cubic-bezier(0.16, 0.84, 0.44, 1);
      }

      .project-card-inner {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 2rem;
      }

      .project-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
      }

      .project-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 0.5rem;
      }

      .tag-pill {
        display: inline-block;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 4px 14px;
        border-radius: 40px;
        font-family: "Inter", sans-serif;
        font-weight: 500;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
      }

      .project-card-title {
        font-family: "Inter", sans-serif;
        font-weight: 350;
        font-size: clamp(2rem, 4vw, 3rem);
        color: #ffffff;
        line-height: 1.1;
      }

      .project-card-desc {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: clamp(0.9rem, 1.2vw, 1.1rem);
        color: var(--muted);
        line-height: 1.6;
        margin: 0.3rem 0 1.2rem;
      }

      .project-visit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        align-self: flex-start;
        background: #ffffff;
        color: #09090C;
        font-family: "Inter", sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 10px 28px;
        border-radius: 40px;
        text-decoration: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
      }

      .project-visit-btn:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 10px 40px rgba(255, 255, 255, 0.25);
        background: #f0f0f0;
      }

      .project-mockup {
        flex: 1;
        position: relative;
        display: flex;
        justify-content: flex-end;
        border-radius: 20px;
        overflow: hidden;
      }

      .mockup-img {
        width: 100%;
        padding-top: 70%;
        position: relative;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        overflow: hidden;
        background: linear-gradient(120deg, #000000, #060606, #121212, #020202);
        background-size: 300% 300%;
        animation: mockupGradient 12s ease infinite;
      }

      .mockup-img-photo {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 3%;
      }

      @keyframes mockupGradient {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
      }

      .end-of-deck-indicator {
        position: absolute;
        bottom: 10%;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        font-family: "Inter", sans-serif;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 300;
        font-size: 1rem;
        letter-spacing: 1px;
        opacity: 0;
        transition: opacity 0.5s ease, transform 0.5s ease;
        pointer-events: none;
      }

      /* ============================================================
         SEZIONE CONTACT
         ============================================================ */
      .contact_section {
        height: 100vh;
        position: relative;
        overflow: hidden;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6%;
      }

      .contact-svg-container {
        position: absolute;
        inset: -6%;
        z-index: 0;
        width: 112%;
        height: 112%;
        transform-origin: center bottom;
        animation: contactDrift 30s ease-in-out infinite alternate;
        will-change: transform;
      }

      @keyframes contactDrift {
        0%   { transform: scale(1)    translate(0%, 0%); }
        50%  { transform: scale(1.05) translate(-1.2%, 0.8%); }
        100% { transform: scale(1.1)  translate(1.2%, -0.8%); }
      }

      @media (prefers-reduced-motion: reduce) {
        .contact-svg-container { animation: none; }
      }

      .contact-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(180deg, rgb(0, 0, 0) 0%, rgba(6, 6, 8, 0.15) 45%, rgba(6, 6, 8, 0.88) 100%);
        pointer-events: none;
      }

      .contact-inner {
        position: relative;
        z-index: 2;
        max-width: 800px;
        width: 100%;
        text-align: center;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.9s cubic-bezier(0.16, 0.84, 0.44, 1), transform 0.9s cubic-bezier(0.16, 0.84, 0.44, 1);
      }

      .contact-inner.in-view {
        opacity: 1;
        transform: translateY(0);
      }

      .contact-content {
        margin-top: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
      }

      .contact-tagline {
        font-family: "Inter", sans-serif;
        font-weight: 400;
        font-size: clamp(1.2rem, 2vw, 1.8rem);
        color: #ffffff;
        letter-spacing: -0.02em;
      }

      .contact-desc {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: clamp(0.95rem, 1.2vw, 1.1rem);
        color: var(--muted);
        max-width: 500px;
        line-height: 1.6;
      }

      .contact-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        color: #09090C;
        font-family: "Inter", sans-serif;
        font-weight: 600;
        font-size: 1rem;
        padding: 14px 40px;
        border-radius: 40px;
        text-decoration: none;
        transition: transform 0.3s cubic-bezier(0.16, 0.84, 0.44, 1), box-shadow 0.3s cubic-bezier(0.16, 0.84, 0.44, 1), background 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        margin-top: 0.5rem;
      }

      .contact-btn:hover {
        transform: scale(1.05) translateY(-3px);
        box-shadow: 0 12px 45px rgba(255, 255, 255, 0.25);
        background: #f0f0f0;
      }

      .contact-btn--secondary {
        background: transparent;
        color: #ffffff;
        border: 1.5px solid rgba(255, 255, 255, 0.3);
        box-shadow: none;
      }

      .contact-btn--secondary:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 30px rgba(255, 255, 255, 0.1);
        color: #ffffff;
      }

      .contact-socials {
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: "Inter", sans-serif;
        font-weight: 400;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
      }

      .contact-socials .social-link {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .contact-socials .social-link:hover { color: #ffffff; }

      .social-divider { color: rgba(255, 255, 255, 0.2); }

      .skills-inner .about-title,
      .contact-inner .about-title {
        text-align: center;
      }

      .skills-inner .accent-line--about,
      .contact-inner .accent-line--about {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1.6rem;
      }

      .projects-container .accent-line--about {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 2rem;
      }

      /* ========== FOOTER ========== */
      .site-footer {
        position: absolute;
        bottom: 4%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        display: flex;
        justify-content: center;
      }

      .footer-text {
        font-family: "Inter", sans-serif;
        font-weight: 300;
        font-size: 0.78rem;
        letter-spacing: 0.4px;
        color: rgba(255, 255, 255, 0.35);
        text-align: center;
      }

      /* Sfondo animato (orb) */
      .hero-bg {
        position: absolute;
        inset: 0;
        background: #000;
        overflow: hidden;
        z-index: 0;
      }

      .hero-bg::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        background-repeat: repeat;
        background-size: 128px 128px;
        pointer-events: none;
        z-index: 1;
        mix-blend-mode: overlay;
      }

      .orb {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(
          circle at 30% 30%,
          rgba(255, 255, 255, 0.95) 0%,
          rgba(255, 255, 255, 0.7) 15%,
          rgba(255, 255, 255, 0.3) 40%,
          rgba(255, 255, 255, 0.05) 70%,
          rgba(255, 255, 255, 0) 100%
        );
        filter: blur(35px);
        opacity: 0.35;
        will-change: transform, opacity;
        mix-blend-mode: screen;
      }

      .orb-1 { width: 300px; height: 300px; top: 10%; left: -5%; animation: drift1 12s ease-in-out infinite alternate; }
      .orb-2 { width: 400px; height: 400px; bottom: -10%; right: -10%; animation: drift2 16s ease-in-out infinite alternate; }
      .orb-3 { width: 200px; height: 200px; top: 60%; left: 30%; animation: drift3 10s ease-in-out infinite alternate; }
      .orb-4 { width: 250px; height: 250px; top: -5%; right: 15%; animation: drift4 8s ease-in-out infinite alternate; }
      .orb-5 { width: 350px; height: 350px; bottom: 20%; left: 60%; animation: drift5 25s ease-in-out infinite alternate; }

      @keyframes drift1 { 0% { transform: translate(0, 0) scale(1); opacity: 0.4; } 100% { transform: translate(120px, 80px) scale(1.2); opacity: 0.6; } }
      @keyframes drift2 { 0% { transform: translate(0, 0) scale(0.9); opacity: 0.3; } 100% { transform: translate(-90px, -100px) scale(1.1); opacity: 0.5; } }
      @keyframes drift3 { 0% { transform: translate(0, 0) scale(1); opacity: 0.5; } 100% { transform: translate(-50px, -30px) scale(0.8); opacity: 0.3; } }
      @keyframes drift4 { 0% { transform: translate(0, 0) scale(1.1); opacity: 0.35; } 100% { transform: translate(70px, -40px) scale(1); opacity: 0.55; } }
      @keyframes drift5 { 0% { transform: translate(0, 0) scale(0.9); opacity: 0.45; } 100% { transform: translate(-100px, 60px) scale(1.05); opacity: 0.3; } }

      /* ============================================================
         MEDIA QUERIES RESPONSIVE
         ============================================================ */
      /* Tablet (fino a 1024px) */
      @media (max-width: 1024px) {
        .project-card { padding: 2rem; }
        .project-card-inner { flex-direction: column-reverse; align-items: stretch; }
        .project-mockup { justify-content: center; width: 100%; }
        .mockup-img { padding-top: 40%; width: 80%; align-self: center; }
        .project-visit-btn { align-self: auto; width: 100%; justify-content: center; }
      }

      /* Mobile (fino a 768px) */
      @media (max-width: 768px) {
        .side-list {
          position: fixed;
          top: auto;
          bottom: 0;
          left: 0;
          right: 0;
          transform: none;
          flex-direction: row;
          justify-content: space-around;
          align-items: center;
          gap: 0;
          background: rgba(6, 6, 8, 0.75);
          backdrop-filter: blur(20px);
          -webkit-backdrop-filter: blur(20px);
          border-top: 1px solid rgba(255, 255, 255, 0.12);
          padding: 8px 5px calc(8px + env(safe-area-inset-bottom, 0px));
          padding: 8px 5px calc(8px + constant(safe-area-inset-bottom, 0px)); /* fallback */
          z-index: 50;
        }

        .side-list li {
          flex-direction: column;
          gap: 2px;
          font-size: 0.65rem;
          opacity: 0.5;
          transform: none;
          white-space: nowrap;
          padding: 4px 8px;
        }

        .side-list li::before {
          width: 4px;
          height: 4px;
          border-width: 1px;
        }

        .side-list li.active {
          opacity: 1;
          font-weight: 600;
          font-size: 0.65rem;
          transform: none;
          text-shadow: 0 0 6px var(--accent);
        }

        .side-list li.active::before {
          width: 5px;
          height: 5px;
          background: var(--accent);
          box-shadow: 0 0 8px var(--accent);
        }

        .scroll-cue-wrapper--section {
          bottom: calc(100px + env(safe-area-inset-bottom, 0px));
          bottom: calc(100px + constant(safe-area-inset-bottom, 0px));
        }

        .hero .scroll-cue-wrapper {
          bottom: calc(100px + env(safe-area-inset-bottom, 0px));
          bottom: calc(100px + constant(safe-area-inset-bottom, 0px));
        }

        .about-inner { flex-direction: column; text-align: center; gap: 1.5rem; }
        .about-content { max-width: 100%; padding: 1.8rem; }
        .about-title, .about-text { text-align: center; }
        .accent-line--about { margin: 0 auto 1.5rem; }
        .about-avatar { width: 130px; height: 130px; }
        .about-avatar img, .avatar-fallback { width: 130px; height: 130px; }
        .about-avatar::before { inset: -22px; }

        .constellation-wrapper { min-height: 320px; height: 45vh; }
        .skill-label { font-size: 0.7rem; padding: 3px 8px; background: rgba(6, 6, 8, 0.6); }

        .projects_section { padding: 0 2%; }
        .project-card { padding: 1.5rem; border-radius: 20px; }
        .project-card-title { font-size: 1.8rem; }
        .mockup-img { width: 100%; padding-top: 50%; }

        .contact-btn { width: 80%; padding: 12px 20px; }

        .hero {
          background-color: var(--bg);
          background-image:
            linear-gradient(180deg, rgba(9,9,12,0.4) 0%, rgba(9,9,12,0.9) 100%),
            url("/assets/img/hero-poster.jpg");
          background-size: cover;
          background-position: center;
        }

        .about-bg,
        .skills-bg,
        .projects-bg,
        .about-content,
        .mockup-img,
        .contact-svg-container {
          animation: none !important;
        }

        .about-content,
        .skill-card,
        .lang-toggle,
        .lang-dropdown,
        .skill-overlay,
        .skill-label,
        .project-card {
          backdrop-filter: none;
          -webkit-backdrop-filter: none;
        }

        .about-content { background: rgba(14, 14, 17, 0.9); }
        .skill-card { background: rgba(14, 14, 17, 0.95); }
        .lang-toggle { background: rgba(14, 14, 17, 0.85); }
        .lang-dropdown { background: rgba(14, 14, 17, 0.95); }
        .skill-overlay { background: rgba(6, 6, 8, 0.85); }
        .skill-label { background: rgba(6, 6, 8, 0.75); }
        .project-card { background: rgba(10, 10, 12, 0.92); }

        .about-avatar img,
        .about-avatar img:hover {
          box-shadow: 0 0 16px rgba(255, 255, 255, 0.12);
        }
        .side-list li.active {
          text-shadow: 0 0 8px var(--accent);
        }
        .side-list li.active::before {
          box-shadow: 0 0 8px var(--accent);
        }
        .contact-svg-container { display: none; }

        .site-footer { 
          bottom: calc(70px + env(safe-area-inset-bottom, 0px));
          bottom: calc(70px + constant(safe-area-inset-bottom, 0px)); /* fallback */
        }

        /* Language Switcher mobile */
        .lang-toggle {
          padding: 6px 12px;
          gap: 0;
          border-radius: 24px;
          width: auto;
          height: auto;
          display: inline-flex;
          align-items: center;
          justify-content: center;
        }
        .lang-toggle .lang-name,
        .lang-toggle .lang-chevron {
          display: none;
        }
        .lang-toggle .fi {
          font-size: 1.2rem;
          margin: 0;
        }
        .lang-dropdown {
          right: auto;
          left: 50%;
          transform: translateX(-50%) translateY(-10px) scale(0.96);
          transform-origin: top center;
          min-width: auto;
          padding: 4px 6px;
          border-radius: 24px;
        }
        .lang-switcher.open .lang-dropdown {
          transform: translateX(-50%) translateY(0) scale(1);
        }
        .lang-dropdown li {
          padding: 8px 12px;
          justify-content: center;
          gap: 0;
        }
        .lang-dropdown li .name {
          display: none;
        }
        .lang-dropdown .fi {
          font-size: 1.2rem;
          margin: 0;
        }
        .lang-dropdown li.active::after {
          display: none;
        }
        .lang-dropdown li.active {
          background: rgba(255, 255, 255, 0.12);
          border-radius: 16px;
        }
      }

      /* Schermi molto piccoli (fino a 480px) */
      @media (max-width: 480px) {
        .side-list li { font-size: 0.6rem; padding: 2px 5px; }
        .side-list li::before { width: 3px; height: 3px; }
        .side-list li.active::before { width: 4px; height: 4px; }
        
        .title { white-space: normal; font-size: clamp(1.3rem, 8vw, 2.5rem); }
        .subtitle { font-size: 0.8rem; letter-spacing: 2px; }

        .about-avatar { width: 100px; height: 100px; }
        .about-avatar img, .avatar-fallback { width: 100px; height: 100px; }
        .about-content { padding: 1.2rem; }

        .constellation-wrapper { min-height: 250px; height: 35vh; }
        .skill-label { font-size: 0.6rem; padding: 2px 6px; }

        .project-card { padding: 1rem; }
        .project-card-title { font-size: 1.4rem; }
        .project-card-desc { font-size: 0.8rem; }
        .tag-pill { font-size: 0.7rem; padding: 2px 10px; }
        .project-visit-btn { font-size: 0.85rem; padding: 8px 20px; }

        .contact-btn { font-size: 0.9rem; padding: 10px 25px; width: 90%; }
        .contact-tagline { font-size: 1rem; }
        .contact-desc { font-size: 0.85rem; }
        
        .scroll-cue-label {
          white-space: normal;
          font-size: 0.55rem;
          letter-spacing: 1px;
          max-width: 70vw;
          line-height: 1.2;
          text-align: center;
        }
        .scroll-cue { width: 36px; height: 36px; }
        .scroll-cue::before { width: 7px; height: 7px; }

        .footer-text { font-size: 0.7rem; }
        .site-footer { 
          bottom: calc(65px + env(safe-area-inset-bottom, 0px));
          bottom: calc(65px + constant(safe-area-inset-bottom, 0px)); /* fallback */
        }
      }

      /* Preferenze di sistema: riduci movimento */
      @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        .scroll-cue::before { animation: none; }
        .title, .accent-line, .subtitle { animation: none; opacity: 1; transform: none; }
        .about-inner { transition: none; opacity: 1; transform: none; }
        .about-bg, .projects-bg { animation: none; }
        .about-content { transition: none; }
        .about-content:hover { transform: none; }
      }
    </style>
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
        const isMobile = window.matchMedia('(max-width: 768px)').matches;
        if (isMobile) {
          const svgContainer = document.getElementById('contactSvgContainer');
          if (svgContainer) svgContainer.remove();
        }

        const wrapper = document.getElementById("pageWrapper");
        const sections = document.querySelectorAll("section[id]");
        const navItems = document.querySelectorAll("#sideList li");
        const sideList = document.getElementById('sideList');

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

        wrapper.addEventListener('transitionstart', () => {
          wrapper.style.willChange = 'transform';
        });
        wrapper.addEventListener('transitionend', () => {
          wrapper.style.willChange = 'auto';
        });

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

        window.addEventListener("hashchange", () => {
          if (isAnimating) return;
          const newIndex = getIndexFromHash();
          if (sections[newIndex] && sections[newIndex].id === 'projects') {
              cardIndex = 0;
              setTimeout(() => updateCardDeck(0), 300);
          }
          goToSection(newIndex);
        });

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

        // --- COSTELLAZIONE (posizionamento etichette ottimizzato) ---
        let skillsData = [];
        let hoveredNodeId = null;
        let nodes = [];
        let constellationInitialized = false;
        let staticCanvas = null;
        let staticCtx = null;
        let mainCanvas, mainCtx, labelsContainer;

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
        
        if (document.getElementById('skills').getBoundingClientRect().top < window.innerHeight) {
            setTimeout(initConstellation, 100);
        }
      })();
    </script>
  </body>
</html>