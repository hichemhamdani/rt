<?php
/**
 * Front Page — Static rebuild, pixel-perfect sans Elementor
 */
defined( 'ABSPATH' ) || exit;

$site_url    = esc_url( home_url() );
$uploads_url = $site_url . '/wp-content/uploads';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Disrupting Industrial Gas Supply | Rutherford &amp; Titan</title>
<?php wp_head(); ?>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Reddit+Sans:wght@300;400;500&family=Cabin:wght@400;500&display=swap" rel="stylesheet">

<!-- Font Awesome 5 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">

<!-- Swiper 8 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

<!-- Elementor kit + page CSS (fichiers physiques toujours présents dans uploads) -->
<link rel="stylesheet" href="<?php echo $site_url; ?>/wp-content/uploads/elementor/css/post-3.css">
<link rel="stylesheet" href="<?php echo $site_url; ?>/wp-content/uploads/elementor/css/post-2.css">

<style>
/* ======================================================
   Variables
   ====================================================== */
:root {
  --navy:   #17376C;
  --blue:   #0058FC;
  --yellow: #FFCE00;
  --bg:     #F3F6FD;
  --white:  #FFFFFF;
  --dark:   #111111;
  --border: #E0E0E0;
  --fh: 'Oswald', sans-serif;
  --fb: 'Reddit Sans', sans-serif;
  --fc: 'Cabin', sans-serif;
  --mw: 1280px;
}

/* ======================================================
   Reset & Base
   ====================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  background: var(--bg);
  color: var(--navy);
  font-family: var(--fb);
  font-size: 1.2rem;
  font-weight: 300;
  line-height: 1.2;
}
a { color: var(--blue); text-decoration: none; }
img { max-width: 100%; display: block; }
p { margin-bottom: 1rem; }
p:last-child { margin-bottom: 0; }

/* ======================================================
   Utilities
   ====================================================== */
.rt-label {
  display: block;
  font-family: var(--fb);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--blue);
  margin-bottom: 0.4rem;
}
.rt-label--white { color: var(--white) !important; }
.rt-label--yellow { color: var(--yellow) !important; }

.rt-btn {
  display: inline-block;
  font-family: var(--fh);
  font-size: 1.3rem;
  font-weight: 300;
  text-transform: uppercase;
  text-decoration: none;
  padding: 1rem 2rem;
  background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
  color: var(--white);
  transition: opacity .2s;
  cursor: pointer;
  border: none;
}
.rt-btn:hover { opacity: .88; color: var(--white); }
.rt-btn--white {
  background: #fff;
  color: var(--navy);
  border: 1px solid #fff;
}
.rt-btn--navy {
  background: var(--navy);
  color: var(--white);
}

.rt-divider {
  border: none;
  border-top: 1px solid var(--border);
  margin: 2rem 0;
}

/* ======================================================
   HEADER
   ====================================================== */
.rt-header-wrap {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 200;
}

/* Top announcement bar */
.rt-topbar {
  background: linear-gradient(90deg, var(--navy), var(--blue));
  transition: opacity .3s, visibility .3s;
}
.rt-topbar-inner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: var(--mw);
  margin: 0 auto;
  padding: 0.5rem 3rem;
}
.rt-topbar a {
  color: #fff;
  font-family: var(--fh);
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}
.rt-topbar-right { display: flex; gap: 2rem; }

/* Main header */
.rt-header {
  transition: background-color .5s ease;
}
.rt-header.scrolled { background-color: #17376CF2; }
.rt-header-inner {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 0 3rem;
  height: 70px;
  max-width: var(--mw);
  margin: 0 auto;
}

.rt-logo {
  color: #fff;
  font-family: var(--fh);
  font-size: 1.3rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  white-space: nowrap;
  flex-shrink: 0;
}

/* Nav */
.rt-nav {
  display: flex;
  align-items: center;
  list-style: none;
  flex: 1;
  justify-content: flex-end;
}
.rt-nav > li { position: relative; }
.rt-nav > li > a {
  display: flex;
  align-items: center;
  height: 70px;
  padding: 0 1.2rem;
  color: #fff;
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}
.rt-nav > li > a:hover { color: var(--yellow); }

/* Dropdown */
.rt-dropdown {
  position: absolute;
  top: 70px;
  left: 0;
  min-width: 580px;
  padding: 2rem;
  background: linear-gradient(135deg, var(--navy), var(--blue));
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: opacity .2s;
  z-index: 300;
}
.rt-nav > li:hover .rt-dropdown {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}
.rt-dropdown h4 {
  color: #fff;
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
  border-bottom: 1px solid rgba(255,255,255,.3);
  padding-bottom: .4rem;
  margin-bottom: .5rem;
}
.rt-dropdown ul { list-style: none; }
.rt-dropdown ul li a {
  color: rgba(255,255,255,.8);
  font-size: .9rem;
  display: block;
  padding: .25rem 0;
}
.rt-dropdown ul li a:hover { color: var(--yellow); }

.rt-phone-btn {
  flex-shrink: 0;
  color: #fff !important;
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: .7rem 1.4rem;
  background: linear-gradient(90deg, var(--navy), var(--blue));
  border: 1px solid rgba(255,255,255,.4);
  white-space: nowrap;
}

.rt-mobile-toggle {
  display: none;
  background: none;
  border: none;
  color: #fff;
  font-size: 1.4rem;
  cursor: pointer;
  margin-left: auto;
}

/* ======================================================
   HERO
   ====================================================== */
.rt-hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  overflow: hidden;
}
.rt-hero-inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: var(--mw);
  margin: 0 auto;
  padding: 3rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.rt-hero-video {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
}
.rt-hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(17,17,17,.11), rgba(17,17,17,.11));
  z-index: 1;
}
.rt-hero-content {
  max-width: 650px;
}
.rt-hero-brand {
  color: #fff;
  font-family: var(--fb);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  text-shadow: 0 0 20px #000;
  margin-bottom: .5rem;
}
.rt-hero h1 {
  color: #fff;
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  text-transform: uppercase;
  line-height: 1em;
  text-shadow: 0 0 30px #000;
  margin: 0 0 1rem;
}
.rt-hero-hr {
  border: none;
  border-top: 2px solid var(--yellow);
  width: 100%;
  margin: 0 0 1rem;
}
.rt-hero-text {
  color: #fff;
  text-shadow: 0 0 20px #000;
  margin-bottom: 1.5rem;
}

/* ======================================================
   NAV BOTTOM BAR
   ====================================================== */
.rt-navbar {
  background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
}
.rt-navbar-inner {
  display: flex;
  max-width: var(--mw);
  margin: 0 auto;
}
.rt-navbar-item {
  flex: 1;
  padding: 3rem 1rem;
  border-right: 1px solid rgba(255,255,255,.15);
}
.rt-navbar-item:last-child { border-right: none; }
.rt-navbar-title {
  color: #fff;
  font-family: var(--fb);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: .4rem;
}
.rt-navbar-desc {
  color: #fff;
  font-family: var(--fc);
  font-size: 12px;
}

/* ======================================================
   EXPERTISE
   ====================================================== */
.rt-expertise-wrap {
  background: var(--bg);
  padding: 6rem 3rem;
}
.rt-expertise {
  max-width: var(--mw);
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 3rem;
}
.rt-expertise-content { flex: 1; }
.rt-expertise-content h2 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  line-height: 1.1;
  color: var(--navy);
  margin: 0 0 1rem;
}
.rt-expertise-cta {
  display: flex;
  align-items: center;
  gap: 2rem;
  margin-top: 1rem;
  flex-wrap: wrap;
}
.rt-join-link {
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
  color: var(--navy);
  text-decoration: none;
}
.rt-cta-box {
  display: flex;
  align-items: center;
  gap: 15px;
  text-decoration: none;
  color: var(--navy);
}
.rt-cta-icon {
  width: 36px;
  height: 36px;
  background: var(--yellow);
  color: var(--navy);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .9rem;
  flex-shrink: 0;
}
.rt-cta-label { font-weight: 700; }
.rt-expertise-img {
  flex: 0 0 45.35%;
  max-width: 45.35%;
}
.rt-expertise-img img {
  width: 100%;
  height: 540px;
  object-fit: cover;
  border: 1px solid var(--border);
  padding: 10px;
}

/* ======================================================
   GENERATORS
   ====================================================== */
.rt-gen-wrap {
  background: #fff;
  padding: 6rem 3rem;
}
.rt-generators {
  max-width: var(--mw);
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 3rem;
}
.rt-gen-img {
  flex: 0 0 40%;
  max-width: 40%;
}
.rt-gen-img img {
  width: 100%;
  border: 1px solid var(--border);
  padding: 10px;
}
.rt-gen-content { flex: 1; }
.rt-gen-content h3 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  line-height: 1.1;
  color: var(--navy);
  margin: 0 0 1.5rem;
}
.rt-gen-cards {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}
.rt-gen-card {
  flex: 1;
  min-width: 200px;
  padding: 2rem;
  border: 1px solid var(--border);
  box-shadow: 0 0 20px rgba(0,0,0,.12);
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.rt-gen-card--accent { border-color: var(--yellow); }
.rt-gen-card-icon {
  width: 36px;
  height: 36px;
  background: var(--blue);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 2px;
}
.rt-gen-card h4 {
  font-family: var(--fh);
  font-size: 1rem;
  color: var(--navy);
  font-weight: 400;
  text-transform: uppercase;
  margin: 0;
}
.rt-gen-card p { font-size: 1rem; margin: 0; }

/* ======================================================
   SMART SYSTEMS + SERVICES (split section)
   ====================================================== */
.rt-split-section {
  position: relative;
  min-height: 70vh;
  display: flex;
  overflow: hidden;
}
.rt-split-bg {
  position: absolute;
  inset: 0;
  background-image: url('<?php echo $uploads_url; ?>/high-pressure-horizontal-chemical-liquid-nitrogen-cryogenic-storage-tank.jpg');
  background-position: bottom center;
  background-size: cover;
  z-index: 0;
}
.rt-split-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, var(--navy) 50%, var(--blue) 50%);
  z-index: 1;
}
.rt-split-inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: var(--mw);
  margin: 0 auto;
  display: flex;
  align-items: stretch;
  padding: 0 3rem;
}

/* Left column */
.rt-smart-col {
  width: 50%;
  padding: 6rem 3rem;
}
.rt-smart-col h3 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  line-height: 1.1;
  color: #fff;
  margin: 0 0 1rem;
}
.rt-smart-col p { color: #fff; }

/* ======================================================
   SERVICES (standalone section)
   ====================================================== */
.rt-services-wrap {
  background: var(--bg);
  padding: 6rem 3rem;
  text-align: center;
}
.rt-services-inner {
  max-width: var(--mw);
  margin: 0 auto;
}
.rt-services-inner h2 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  line-height: 1.1;
  color: var(--navy);
  margin: .3rem 0 1rem;
}
.rt-services-desc {
  max-width: 750px;
  margin: 0 auto 2.5rem;
}
.rt-service-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  text-align: left;
}
.rt-service-card {
  background: #fff;
  border: 2px solid var(--yellow);
  box-shadow: 0 0 20px 1px rgba(0,0,0,.12);
  overflow: hidden;
}
.rt-service-card img {
  width: 100%;
  height: 280px;
  object-fit: cover;
}
.rt-service-card h4 {
  font-family: var(--fh);
  font-size: 1.1rem;
  color: var(--navy);
  padding: 1rem 2rem .4rem;
  font-weight: 400;
  text-transform: uppercase;
}
.rt-service-card p {
  color: var(--navy);
  font-size: 1rem;
  padding: 0 2rem 1.5rem;
  margin: 0;
}

/* ======================================================
   CLIENTS (Trust Us)
   ====================================================== */
.rt-clients-wrap {
  background: #fff;
  padding: 6rem 3rem;
}
.rt-clients-inner {
  max-width: var(--mw);
  margin: 0 auto;
  text-align: center;
}
.rt-clients-inner h3 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  color: var(--navy);
  margin-bottom: .3rem;
}
.rt-clients-inner .rt-sub { margin-bottom: 2rem; }
.rt-client-swiper { position: relative; padding-bottom: 3.5rem; }
.rt-client-swiper .swiper-slide img { width: 100%; object-fit: contain; }
.rt-client-swiper .swiper-button-prev,
.rt-client-swiper .swiper-button-next { color: var(--navy); }

/* ======================================================
   PRODUCTS
   ====================================================== */
.rt-products-wrap {
  background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
  padding: 6rem 3rem;
  text-align: center;
}
.rt-products-inner {
  max-width: var(--mw);
  margin: 0 auto;
}
.rt-products-wrap h2 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  line-height: 1.1;
  color: #fff;
  margin: 0 0 1rem;
}
.rt-products-wrap .rt-sub {
  color: #fff;
  max-width: 750px;
  margin: 0 auto 2rem;
}
.rt-prod-swiper { position: relative; padding-bottom: 3.5rem; }
.rt-prod-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  text-decoration: none;
}
.rt-prod-card img { width: 100%; aspect-ratio: 1; object-fit: cover; }
.rt-prod-card-footer {
  background: var(--bg);
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: .6rem;
  flex: 1;
}
.rt-prod-card h3 {
  font-family: var(--fh);
  font-size: 1.5rem;
  font-weight: 400;
  color: var(--navy);
  text-align: left;
  margin: 0;
  line-height: 1.1;
}
.rt-prod-card .discover {
  font-family: var(--fh);
  font-size: 1rem;
  color: var(--navy);
  text-transform: uppercase;
  align-self: flex-end;
}
.rt-prod-swiper .swiper-button-prev,
.rt-prod-swiper .swiper-button-next { color: #fff; }

/* ======================================================
   FAQ + CONTACT
   ====================================================== */
.rt-faq-wrap {
  background: var(--bg);
  padding: 6rem 3rem;
}
.rt-faq-inner {
  max-width: var(--mw);
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 4rem;
}
.rt-faq-left { width: 100%; }
.rt-faq-bottom {
  display: flex;
  gap: 3rem;
  align-items: flex-start;
}
.rt-faq-left h2 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  color: var(--navy);
  margin: 0 0 .5rem;
}
.rt-faq-left > p { margin-bottom: 1.5rem; }
/* Accordion */
.rt-faq-item { border-top: 1px solid var(--border); }
.rt-faq-item:last-child { border-bottom: 1px solid var(--border); }
.rt-faq-q {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  cursor: pointer;
  padding: 1.1rem 0;
  color: var(--navy);
  font-family: var(--fb);
  font-size: 1.1rem;
  font-weight: 400;
  line-height: 1.3;
  user-select: none;
}
.rt-faq-q .rt-faq-icon { color: var(--navy); font-size: .8rem; flex-shrink: 0; }
.rt-faq-q.open { color: var(--blue); }
.rt-faq-q.open .rt-faq-icon { color: var(--blue); }
.rt-faq-a { display: none; padding: 0 0 1.5rem; font-size: 1rem; }
.rt-faq-a.open { display: block; }

/* Row 2: image */
.rt-faq-img { flex: 1; }
.rt-faq-img img {
  width: 100%;
  height: 100%;
  min-height: 400px;
  object-fit: cover;
  object-position: center;
  border: 1px solid var(--border);
  padding: 10px;
}

/* Row 2: contact box */
.rt-contact-box {
  flex: 1;
  border: 2px solid var(--yellow);
  box-shadow: 0 0 30px rgba(0,0,0,.2);
  padding: 2rem;
  background: #fff;
  overflow: hidden;
}
.rt-contact-box h2 {
  font-family: var(--fh);
  font-size: 3rem;
  font-weight: 400;
  color: var(--navy);
  margin: 0 0 1rem;
}

/* ======================================================
   FOOTER
   ====================================================== */
.rt-footer-wrap {
  background: var(--bg);
  padding: 6rem 3rem;
}
.rt-footer-inner { max-width: var(--mw); margin: 0 auto; }
/* Reviews */
.rt-reviews-swiper { padding-bottom: 3rem; }
.rt-review { overflow: hidden; border: 1px solid var(--border); }
.rt-review-head {
  background: var(--navy);
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.2rem;
}
.rt-review-logo {
  width: 58px;
  height: 58px;
  object-fit: contain;
  flex-shrink: 0;
}
.rt-review-info { flex: 1; min-width: 0; }
.rt-review-name {
  color: #fff;
  font-family: var(--fh);
  font-size: .75rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  line-height: 1.4;
  margin-bottom: .5rem;
}
.rt-stars { color: var(--yellow); font-size: .9rem; }
.rt-review-body { background: #fff; padding: 1.5rem; min-height: 120px; }
.rt-review-body p { color: var(--navy); font-size: 1rem; margin: 0; }
/* Footer columns */
.rt-footer-cols { display: flex; gap: 3rem; }
.rt-footer-col { flex: 1; }
.rt-footer-col h4 { font-family: var(--fh); color: var(--navy); margin-bottom: .6rem; }
.rt-footer-col ul { list-style: none; }
.rt-footer-col ul li { padding: .2rem 0; }
.rt-footer-col ul li a { color: var(--navy); display: flex; align-items: center; gap: .5rem; }
.rt-footer-col ul li a:hover { color: var(--blue); }
.rt-footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: .9rem;
  flex-wrap: wrap;
  gap: 1rem;
}
.rt-footer-bottom a { color: var(--navy); padding: 0 .8rem; }

/* ======================================================
   RESPONSIVE
   ====================================================== */
@media (max-width: 1024px) {
  .rt-topbar-right { display: none; }
  .rt-expertise { flex-wrap: wrap; }
  .rt-expertise-img { flex: 0 0 100%; max-width: 100%; }
  .rt-expertise-img img { height: 400px; }
  .rt-generators { flex-wrap: wrap; }
  .rt-gen-img { flex: 0 0 100%; max-width: 100%; }
  .rt-smart-col { width: 100%; padding: 4rem 2rem; }
  .rt-split-overlay { background: linear-gradient(180deg, var(--navy) 50%, var(--blue) 50%); }
  .rt-services-wrap { padding: 4rem 2rem; }
  .rt-faq-bottom { flex-direction: column; }
  .rt-faq-img { display: none; }
  .rt-footer-cols { flex-wrap: wrap; gap: 2rem; }
}

@media (max-width: 767px) {
  .rt-header-inner { padding: 0 1rem; }
  .rt-nav { display: none; }
  .rt-mobile-toggle { display: block; }
  .rt-nav.open {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    position: fixed;
    top: 70px; left: 0; right: 0; bottom: 0;
    background: var(--navy);
    padding: 2rem;
    z-index: 400;
    overflow-y: auto;
  }
  .rt-nav.open > li > a { height: auto; padding: .8rem 0; }
  .rt-navbar { display: none; }
  .rt-hero-inner { padding: 3rem 1rem; }
  .rt-hero h1 { font-size: 1.8rem; }
  .rt-expertise-wrap, .rt-gen-wrap, .rt-faq-wrap, .rt-clients-wrap, .rt-products-wrap, .rt-footer-wrap, .rt-services-wrap { padding: 3rem 1rem; }
  .rt-service-cards { grid-template-columns: 1fr; }
  .rt-phone-btn { display: none; }
  .rt-footer-cols { flex-direction: column; gap: 1.5rem; }
  .rt-footer-bottom { flex-direction: column; text-align: center; }
}
</style>
</head>

<body class="home page">

<!-- ============================
     HEADER (absolute over hero)
     ============================ -->
<div class="rt-header-wrap">
  <!-- Top bar -->
  <div class="rt-topbar" id="rt-topbar">
    <div class="rt-topbar-inner">
      <a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/free-supply-audit/">
        Free Liquid Nitrogen Supply Audit — Save Up To 75% — GO &gt;
      </a>
      <div class="rt-topbar-right">
        <a href="#">Ressources</a>
        <a href="<?php echo $site_url; ?>/join-us/">Join us</a>
      </div>
    </div>
  </div>

  <!-- Main header -->
  <div class="rt-header" id="rt-header">
    <div class="rt-header-inner">
    <a href="<?php echo $site_url; ?>" class="rt-logo">Rutherford &amp; Titan</a>

    <button class="rt-mobile-toggle" id="rt-toggle" aria-label="Menu">
      <i class="fas fa-bars"></i>
    </button>

    <ul class="rt-nav" id="rt-nav">
      <li>
        <a href="#">Solutions</a>
        <div class="rt-dropdown">
          <div>
            <h4>Liquid nitrogen</h4>
            <ul>
              <li><a href="<?php echo $site_url; ?>/product-category/liquid-nitrogen-generators/">On-Site LN2 Generators</a></li>
              <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/">The True Cost of LN2 in The USA</a></li>
              <li><a href="<?php echo $site_url; ?>/case-studies/">Our Clients and Their Applications</a></li>
              <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/membrane-and-pressure-swing-adsorbtion-comparison/">Tech Comparison: Membrane Vs. PSI</a></li>
            </ul>
          </div>
          <div>
            <h4>Gasses</h4>
            <ul>
              <li><a href="<?php echo $site_url; ?>/product-category/nitrogen-generators/">Nitrogen Gas Generators</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/oxygen-generators/">Oxygen Generators</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/helium-compressors/">Helium Generators</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/hydrogen-generators/">Hydrogen Generators</a></li>
            </ul>
          </div>
          <div>
            <h4>Storage, Transfer &amp; Safety</h4>
            <ul>
              <li><a href="<?php echo $site_url; ?>/product-category/bulk-storage-tanks/">Bulk Storage Tanks</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/cryogenic-hoses-pipes/">Cryogenic Hoses &amp; Pipes</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/gas-safety-systems/">Safety Systems</a></li>
              <li><a href="<?php echo $site_url; ?>/product-category/accessories/">Accessories</a></li>
            </ul>
          </div>
        </div>
      </li>
      <li><a href="http://rutherfordtitan.com/case-studies/">Clients &amp; applications</a></li>
      <li><a href="<?php echo $site_url; ?>/about-rutherford-titan/">About us</a></li>
      <li><a href="<?php echo $site_url; ?>/contact/">Contact</a></li>
    </ul>

    <a href="tel:+12819403597" class="rt-phone-btn rt-btn">Call (281) 940-3597</a>
    </div>
  </div>
</div>

<!-- ============================
     HERO
     ============================ -->
<section class="rt-hero">
  <video class="rt-hero-video" autoplay muted playsinline loop>
    <source src="<?php echo $uploads_url; ?>/sky-view-rt.mp4" type="video/mp4">
  </video>
  <div class="rt-hero-overlay"></div>
  <div class="rt-hero-inner">
    <div class="rt-hero-content">
      <div class="rt-hero-brand">Rutherford &amp; Titan</div>
      <h1>Industrial Gas Supply Expert In the United States</h1>
      <hr class="rt-hero-hr">
      <p class="rt-hero-text">Rutherford &amp; Titan helps businesses in the United States produce industrial gas supply on-site — from nitrogen, oxygen, argon, helium, and hydrogen. Most importantly, our experts help design and build the best system to increase productivity and reduce costs.</p>
      <a href="<?php echo $site_url; ?>/product-category/liquid-nitrogen-generators/" class="rt-btn rt-btn--white">LN2 Generators</a>
    </div>
  </div>
</section>

<!-- ============================
     NAV BOTTOM BAR
     ============================ -->
<nav class="rt-navbar">
  <div class="rt-navbar-inner">
    <div class="rt-navbar-item">
      <div class="rt-navbar-title">Expertise</div>
      <div class="rt-navbar-desc">↳ Building a Reliable Industrial Gas Supply</div>
    </div>
    <div class="rt-navbar-item">
      <div class="rt-navbar-title">Services</div>
      <div class="rt-navbar-desc">↳ Expert in all things cryogenics</div>
    </div>
    <div class="rt-navbar-item">
      <div class="rt-navbar-title">Products</div>
      <div class="rt-navbar-desc">↳ Produce, store, and transfer gas</div>
    </div>
    <div class="rt-navbar-item">
      <div class="rt-navbar-title">Free Consultation</div>
      <div class="rt-navbar-desc">↳ Talk to an expert</div>
    </div>
  </div>
</nav>

<!-- ============================
     EXPERTISE
     ============================ -->
<div class="rt-expertise-wrap" id="expertise">
  <div class="rt-expertise">
    <div class="rt-expertise-content">
      <span class="rt-label">Expertise</span>
      <h2>Making&nbsp; Reliable Industrial Gas Supply Accessible</h2>
      <p>Today our deep understanding of gas industry trends and business requirements allows us to collaborate with customers around the world to create smart <a href="<?php echo $site_url; ?>/industrial-gas-solutions/">industrial gas solutions</a> that deliver competitive advantage.</p>
      <p>At Rutherford &amp; Titan, our goal is to provide our clients with the best quality products and tailored services to build a reliable gas supply within their facilities with minimal downtime and maximum efficiency.</p>
      <div class="rt-expertise-cta">
        <a href="<?php echo $site_url; ?>/join-us/" class="rt-join-link">Join our team — Work with us</a>
        <a href="<?php echo $site_url; ?>/contact/" class="rt-cta-box">
          <div class="rt-cta-icon"><i class="fas fa-info"></i></div>
          <span class="rt-cta-label">Talk To An Expert</span>
        </a>
      </div>
    </div>
    <div class="rt-expertise-img">
      <img src="<?php echo $uploads_url; ?>/Industrial-gases.jpeg"
           alt="Two experts building a reliable gas supply within their facilities with minimal downtime and maximum efficiency"
           loading="eager">
    </div>
  </div>
</div>

<!-- ============================
     ON-SITE GENERATORS
     ============================ -->
<div class="rt-gen-wrap">
  <div class="rt-generators">
    <div class="rt-gen-img">
      <img src="<?php echo $uploads_url; ?>/RT-Tanks-Large-688x1024.jpeg"
           alt="Industrial gas supply can be stored in large tanks">
    </div>
    <div class="rt-gen-content">
      <span class="rt-label">Our craft</span>
      <h3>On-Site Industrial Gas Generators</h3>
      <div class="rt-gen-cards">
        <div class="rt-gen-card rt-gen-card--accent">
          <div class="rt-gen-card-icon"><i class="far fa-arrow-alt-circle-down"></i></div>
          <div>
            <h4>Save Up To 90%</h4>
            <p>Businesses see ROI as soon as six months after investing in a generator.</p>
          </div>
        </div>
        <div class="rt-gen-card">
          <div class="rt-gen-card-icon"><i class="far fa-check-circle"></i></div>
          <div>
            <h4>Guarantee On-Site Supply</h4>
            <p>No more delivery uncertainties. Produce what you need when you need it.</p>
          </div>
        </div>
      </div>
      <p>Our high-performance gas generators have a minimal footprint, improved efficiency, and good sound insulation. They can fit in most business facilities — from dermatologist practices to large industrial complexes.</p>
      <a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/" class="rt-btn rt-btn--navy">Discover</a>
    </div>
  </div>
</div>

<!-- ============================
     RT SMART SYSTEMS
     ============================ -->
<section class="rt-split-section" id="smart-systems">
  <div class="rt-split-bg"></div>
  <div class="rt-split-overlay"></div>
  <div class="rt-split-inner">
    <div class="rt-smart-col">
      <span class="rt-label rt-label--white">RT Smart Systems</span>
      <h3>Production, Storage, Transfer, and Safety</h3>
      <p>RT offers different products necessary for the safe and efficient transfer and storage of liquid Nitrogen — including maintenance and monitoring systems.</p>
      <p>We tailor our solutions to meet your application's specifications and carefully source products to build efficient systems and never compromise quality.</p>
      <a href="<?php echo $site_url; ?>/industrial-gas-solutions/" class="rt-btn rt-btn--white">Bulk Storage Tanks</a>
    </div>
  </div>
</section>

<!-- ============================
     SERVICES
     ============================ -->
<div class="rt-services-wrap" id="services">
  <div class="rt-services-inner">
    <span class="rt-label" style="display:block;">Services</span>
    <h2>Experts In All Things Cryogenics</h2>
    <p class="rt-services-desc">Get premium service from engineers who have seen it all. Our team of experienced experts help you build the best gas supply and distribution systems.</p>

    <div class="rt-service-cards">
      <div class="rt-service-card">
        <img src="<?php echo $uploads_url; ?>/RT-experts-LN2-768x512.jpeg" alt="Two RT experts showing LN2 pipes" loading="lazy">
        <h4>Planning</h4>
        <p>Every operation is unique. We help you plan a custom or turnkey solution that works for you.</p>
      </div>
      <div class="rt-service-card">
        <img src="<?php echo $uploads_url; ?>/Maintenance-RT-768x512.jpeg" alt="LN2 Tanks and piping maintenance engineers" loading="lazy">
        <h4>Maintenance</h4>
        <p>Our nationwide network of technicians is on standby to provide remote or on-site maintenance, minimizing downtime.</p>
      </div>
      <div class="rt-service-card">
        <img src="<?php echo $uploads_url; ?>/Installation-RT-e1745109982369-768x568.jpeg" alt="Worker standing at control sensors" loading="lazy">
        <h4>Installation</h4>
        <p>Our team quickly and efficiently installs your system while minimizing operational disruption.</p>
      </div>
      <div class="rt-service-card">
        <img src="<?php echo $uploads_url; ?>/Upgrade-system-RT-768x512.jpg" alt="RT experts helping upgrade industrial gas supply" loading="lazy">
        <h4>Upgrades</h4>
        <p>As your partner, we help you continually upgrade and reconfigure your system for maximum efficiency.</p>
      </div>
    </div>
  </div>
</div>

<!-- ============================
     THEY TRUST US
     ============================ -->
<div class="rt-clients-wrap">
  <div class="rt-clients-inner">
    <h3>They Trust Us</h3>
    <p class="rt-sub">They trust us with the liquid nitrogen supply</p>

    <div class="swiper rt-client-swiper">
      <div class="swiper-wrapper">
        <?php
        $client_logos = [
          ['ln2-generator-client-logo-air-force.jpeg',              'Air Force'],
          ['ln2-generator-client-logo-fbi.jpeg',                    'FBI'],
          ['ln2-generator-client-logo-lockhead-martins.jpeg',       'Lockheed Martin'],
          ['ln2-generator-client-logo-morgan-dermatology.jpeg',     'Morgan Dermatology'],
          ['ln2-generator-client-logo-nasa.jpeg',                   'NASA'],
          ['ln2-generator-client-logo-north-arizona-university.jpeg','NAU Arizona'],
          ['ln2-generator-client-logo-pharmative.jpeg',             'Pharmative'],
          ['ln2-generator-client-logo-socom.jpeg',                  'SOCOM'],
          ['ln2-generator-client-logo-toshiba.jpeg',                'Toshiba'],
          ['ln2-generator-client-logo-university-of-hawai.jpeg',    'University of Hawaii'],
        ];
        foreach ( $client_logos as $l ) : ?>
        <div class="swiper-slide">
          <img src="<?php echo $uploads_url . '/' . $l[0]; ?>" alt="<?php echo esc_attr( $l[1] ); ?>" loading="lazy">
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</div>

<!-- ============================
     PRODUCTS
     ============================ -->
<div class="rt-products-wrap" id="products">
  <div class="rt-products-inner">
    <span class="rt-label rt-label--white" style="text-align:center;display:block;">Products</span>
    <h2>Produce, Store, Transfer, and Secure Industrial Gas Supply</h2>
    <p class="rt-sub">We offer an extensive range of essential products, from on-site liquid nitrogen generators to bulk storage tanks for Oxygen, Argon, and other industrial gases.</p>

    <div class="swiper rt-prod-swiper">
      <div class="swiper-wrapper">
        <?php
        $products = [
          ['Oxygen Generators',           'Oxygen-generator-1-768x768.jpg',         '/product-category/oxygen-generators/'],
          ['Liquid Nitrogen Generators',  'Titan-LN2-480-768x768.jpg',              '/product-category/liquid-nitrogen-generators/'],
          ['LabGas Nitrogen Generators',  'LabGas-N2-rt.001-768x768.jpeg',          '/product-category/nitrogen-generators/'],
          ['Hydrogen Generators',         'Hydrogen-Generators.001-768x768.jpeg',   '/product-category/hydrogen-generators/'],
          ['Helium Compressors',          'Helium-generator-768x768.jpg',           '/product-category/helium-compressors/'],
          ['Gas Safety Systems',          'Oxygen-monitor.001-1-768x768.jpeg',      '/product-category/gas-safety-systems/'],
          ['Cryogenic Hoses &amp; Pipes', 'VJ-Hose-WArmor.001-768x768.jpeg',        '/product-category/cryogenic-hoses-pipes/'],
          ['Bulk Storage Tanks',          '8-768x768.jpg',                          '/product-category/bulk-storage-tanks/'],
          ['Accessories',                 '1-768x768.jpg',                          '/product-category/accessories/'],
        ];
        foreach ( $products as $p ) : ?>
        <div class="swiper-slide">
          <a href="<?php echo $site_url . $p[2]; ?>" class="rt-prod-card">
            <img src="<?php echo $uploads_url . '/' . $p[1]; ?>" alt="<?php echo strip_tags( $p[0] ); ?>" loading="lazy">
            <div class="rt-prod-card-footer">
              <h3><?php echo $p[0]; ?></h3>
              <span class="discover">Discover</span>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</div>

<!-- ============================
     FAQ + CONTACT FORM
     ============================ -->
<div class="rt-faq-wrap" id="faq">
  <div class="rt-faq-inner">

    <!-- FAQ -->
    <div class="rt-faq-left">
      <span class="rt-label">FAQ</span>
      <h2>Frequently Asked Questions</h2>
      <p>From cryogenic piping to on-site industrial gas generation, our engineering team answers the most frequently asked questions.</p>

      <?php
      $faqs = [
        ['What is the difference between a VJ hose and a stainless hose?',
         '<p>Having MLI insulation allows you to save on nitrogen, as stainless would evaporate at a higher rate as there is no thermal insulation.</p>'],
        ['What is the main difference between a portable small O2 monitor and a wall-mounted one?',
         '<p>A portable O2 monitor is for use when technicians are moving in and out of facilities that may have nitrogen on site.</p><p>They are short term monitors, usually 1-2 years in lifespan and are not robust enough for a permanent fixture inside a facility.</p><p>This is why we always recommend either a 3 or 10-year monitor on site.</p>'],
        ['Should I use copper or stainless?',
         '<p>This depends on the end molecule in use for that particular application. Give us a call to understand more.</p>'],
        ['Compression fittings or not?',
         '<p>This all depends on the end application use point and what is needed for that particular site.</p>'],
        ['How much electrical power do these units use?',
         '<p>1.5kw to 45kw, it just depends on the size of the system and how much nitrogen you are needing to produce.</p>'],
        ['Do on-site generators require extra fittings and accessories?',
         '<p>We want to ensure the ambient temperature of the room is cool, ideally with air-con and humidity is controlled.</p><p>The most important factor is heat extraction as some nitrogen generators can produce a lot of heat.</p>'],
      ];
      foreach ( $faqs as $faq ) : ?>
      <div class="rt-faq-item">
        <div class="rt-faq-q">
          <?php echo esc_html( $faq[0] ); ?>
          <span class="rt-faq-icon"><i class="fas fa-plus"></i></span>
        </div>
        <div class="rt-faq-a"><?php echo $faq[1]; ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Row 2: image + contact -->
    <div class="rt-faq-bottom">

      <div class="rt-faq-img">
        <img src="<?php echo $uploads_url; ?>/FAQ-RT-1024x683.jpeg" alt="US Engineer checking Liquid Nitrogen pipes" loading="lazy">
      </div>

      <div class="rt-contact-box" id="free-consultation">
        <span class="rt-label">Free Consultation</span>
        <h2>Talk To An Expert</h2>
        <p>Maintaining a reliable gas supply can be a costly endeavor, and the costs are not always obvious when you are first trying to establish your budget.</p>
        <p>Get in touch, and our experts will discuss your needs, help layout requirements, and find the best approach to address your supply challenges.</p>
        <iframe
          src="https://api.leadconnectorhq.com/widget/form/Q9DZvJ5xMKNCuqBt0yVs"
          style="width:100%;height:595px;border:none;border-radius:3px"
          title="Form 001"
        ></iframe>
        <script src="https://link.msgsndr.com/js/form_embed.js"></script>
      </div>

    </div>

  </div>
</div>

<!-- ============================
     FOOTER
     ============================ -->
<footer class="rt-footer-wrap">
  <div class="rt-footer-inner">

    <!-- Reviews carousel -->
    <div class="swiper rt-reviews-swiper">
      <div class="swiper-wrapper">
        <?php
        $reviews = [
          ['Logo-clients.002-150x150.jpeg', 'Wayne England - Operations Manager @ IVF Michigan',
           'Such an easy system to use, and we save about $35K a year from using it.'],
          ['Cryochambers.001-150x150.jpeg', 'Nawfel Oussedik - CEO @CryoChambers.com',
           'RT team is highly knowledgeable about the cryo market and cryogenic applications in general.'],
          ['Logo-clients.001-150x150.jpeg', 'Pavel Romashkin @ Staff Directory @ University of Atmospheric Research',
           'Robust, works great, and portable. Got the job done when nothing else would have worked at that location.'],
        ];
        foreach ( $reviews as $r ) : ?>
        <div class="swiper-slide">
          <div class="rt-review">
            <div class="rt-review-head">
              <img src="<?php echo $uploads_url . '/' . $r[0]; ?>" alt="<?php echo esc_attr( $r[1] ); ?>" class="rt-review-logo">
              <div class="rt-review-info">
                <div class="rt-review-name"><?php echo esc_html( $r[1] ); ?></div>
                <div class="rt-stars">★★★★★</div>
              </div>
            </div>
            <div class="rt-review-body">
              <p><?php echo esc_html( $r[2] ); ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <hr class="rt-divider">

    <!-- 3 columns -->
    <div class="rt-footer-cols">
      <div class="rt-footer-col">
        <h4>Rutherford &amp; Titan</h4>
        <p>RT is American industrial gas solution provider based in Washington State. We specialize in the production, transfer, and store of industrial gases.</p>
        <p><strong>Follow us</strong></p>
        <a href="https://www.linkedin.com/company/rtcryo" target="_blank" rel="noopener" style="color:var(--navy);font-size:1.5rem;">
          <i class="fab fa-linkedin"></i>
        </a>
      </div>
      <div class="rt-footer-col">
        <h4>Ln2 Generators</h4>
        <ul>
          <li><a href="<?php echo $site_url; ?>/product-category/liquid-nitrogen-generators/"><i class="far fa-dot-circle"></i> On-Site LN2 Generators</a></li>
          <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/"><i class="far fa-dot-circle"></i> The true cost of LN2 in the USA</a></li>
          <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/"><i class="far fa-dot-circle"></i> Why invest in LN2 generators</a></li>
        </ul>
      </div>
      <div class="rt-footer-col">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="<?php echo $site_url; ?>/contact/"><i class="far fa-dot-circle"></i> Contact Us</a></li>
          <li><a href="<?php echo $site_url; ?>/join-us/"><i class="far fa-dot-circle"></i> Join Us</a></li>
          <li><a href="<?php echo $site_url; ?>/privacy/"><i class="far fa-dot-circle"></i> Follow Your Order</a></li>
        </ul>
      </div>
    </div>

    <hr class="rt-divider">

    <div class="rt-footer-bottom">
      <span>Rutherford Titan — All rights reserved</span>
      <div>
        <a href="<?php echo $site_url; ?>/terms-conditions/">Terms &amp; Conditions</a>
        <a href="<?php echo $site_url; ?>/return-policy/">Return Policy</a>
        <a href="<?php echo $site_url; ?>/privacy/">Privacy Statement</a>
      </div>
    </div>

  </div>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ---- Sticky header ---- */
  var header  = document.getElementById('rt-header');
  var topbar  = document.getElementById('rt-topbar');
  function onScroll() {
    if (window.scrollY >= 50) {
      header.classList.add('scrolled');
      topbar.style.opacity    = '0';
      topbar.style.visibility = 'hidden';
    } else {
      header.classList.remove('scrolled');
      topbar.style.opacity    = '1';
      topbar.style.visibility = 'visible';
    }
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* ---- Mobile nav ---- */
  var toggle = document.getElementById('rt-toggle');
  var nav    = document.getElementById('rt-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
      toggle.querySelector('i').className = nav.classList.contains('open') ? 'fas fa-times' : 'fas fa-bars';
    });
  }

  /* ---- FAQ accordion ---- */
  document.querySelectorAll('.rt-faq-q').forEach(function (q) {
    q.addEventListener('click', function () {
      var item   = q.closest('.rt-faq-item');
      var answer = item.querySelector('.rt-faq-a');
      var icon   = q.querySelector('.rt-faq-icon i');
      var isOpen = answer.classList.contains('open');

      /* close all */
      document.querySelectorAll('.rt-faq-a').forEach(function (a) { a.classList.remove('open'); });
      document.querySelectorAll('.rt-faq-q').forEach(function (x) {
        x.classList.remove('open');
        x.querySelector('.rt-faq-icon i').className = 'fas fa-plus';
      });

      if (!isOpen) {
        answer.classList.add('open');
        q.classList.add('open');
        icon.className = 'fas fa-minus';
      }
    });
  });

  /* ---- Client logos Swiper ---- */
  new Swiper('.rt-client-swiper', {
    slidesPerView: 6,
    spaceBetween: 16,
    loop: true,
    speed: 500,
    navigation: { nextEl: '.rt-client-swiper .swiper-button-next', prevEl: '.rt-client-swiper .swiper-button-prev' },
    breakpoints: {
      320: { slidesPerView: 2 },
      768: { slidesPerView: 4 },
      1024: { slidesPerView: 6 }
    }
  });

  /* ---- Products Swiper ---- */
  new Swiper('.rt-prod-swiper', {
    slidesPerView: 4,
    spaceBetween: 16,
    loop: true,
    speed: 500,
    navigation: { nextEl: '.rt-prod-swiper .swiper-button-next', prevEl: '.rt-prod-swiper .swiper-button-prev' },
    breakpoints: {
      320: { slidesPerView: 1 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 4 }
    }
  });

  /* ---- Reviews Swiper ---- */
  new Swiper('.rt-reviews-swiper', {
    slidesPerView: 3,
    spaceBetween: 32,
    loop: true,
    speed: 500,
    pagination: { el: '.rt-reviews-swiper .swiper-pagination', clickable: true },
    breakpoints: {
      320: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 }
    }
  });

});
</script>

<?php wp_footer(); ?>
</body>
</html>
