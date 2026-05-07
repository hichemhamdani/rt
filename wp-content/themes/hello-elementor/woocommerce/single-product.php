<?php
/**
 * Single Product — Static rebuild, pixel-perfect sans Elementor
 */
defined( 'ABSPATH' ) || exit;

if ( ! isset( $product ) ) {
    global $product;
}
if ( ! is_a( $product, 'WC_Product' ) ) {
    $pid     = get_the_ID() ?: get_queried_object_id();
    $product = wc_get_product( $pid );
}
if ( ! $product ) { wp_redirect( home_url() ); exit; }

$site_url    = esc_url( home_url() );
$uploads_url = $site_url . '/wp-content/uploads';

$title       = $product->get_name();
$price_raw   = $product->get_price();
$short_desc  = $product->get_short_description();
$description = $product->get_description();
$sku         = $product->get_sku();
$product_id  = $product->get_id();

$main_img_id  = $product->get_image_id();
$gallery_ids  = $product->get_gallery_image_ids();
$all_img_ids  = array_merge( [ $main_img_id ], $gallery_ids );

$attributes = $product->get_attributes();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?php echo esc_html( $title ); ?> | Rutherford &amp; Titan</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Reddit+Sans:wght@300;400;500&family=Cabin:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
<link rel="stylesheet" href="<?php echo $site_url; ?>/wp-content/uploads/elementor/css/post-3.css">

<style>
/* ======================================================
   Variables & Reset
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
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  background: var(--bg);
  color: var(--navy);
  font-family: var(--fb);
  font-size: 1.1rem;
  font-weight: 300;
  line-height: 1.5;
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
  font-size: 1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--blue);
  margin-bottom: 0.4rem;
}
.rt-label--white  { color: var(--white) !important; }
.rt-label--yellow { color: var(--yellow) !important; }

.rt-btn {
  display: inline-block;
  font-family: var(--fh);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  text-decoration: none;
  padding: 0.8rem 2rem;
  background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 100%);
  color: var(--white);
  transition: opacity .2s;
  cursor: pointer;
  border: none;
  white-space: nowrap;
}
.rt-btn:hover { opacity: .88; color: var(--white); }
.rt-btn--blue   { background: var(--blue); }
.rt-btn--white  { background: #fff; color: var(--navy); border: 2px solid rgba(255,255,255,.5); }
.rt-btn--white:hover { color: var(--navy); background: rgba(255,255,255,.9); }
.rt-btn--outline-white {
  background: transparent;
  color: #fff;
  border: 2px solid rgba(255,255,255,.5);
}
.rt-btn--outline-white:hover { background: rgba(255,255,255,.1); color: #fff; }
.rt-divider { border: none; border-top: 1px solid var(--border); margin: 2rem 0; }

/* ======================================================
   HEADER
   ====================================================== */
.rt-header-wrap { position: fixed; top: 0; left: 0; width: 100%; z-index: 200; }
.admin-bar .rt-header-wrap { top: 32px; }
@media screen and (max-width: 782px) { .admin-bar .rt-header-wrap { top: 46px; } }

.rt-topbar { background: linear-gradient(90deg, var(--navy), var(--blue)); border-bottom: 1px solid rgba(255,255,255,0.25); transition: opacity .3s, visibility .3s; }
.rt-topbar-inner {
  display: flex; justify-content: space-between; align-items: center;
  max-width: var(--mw); margin: 0 auto; padding: 0.5rem 3rem;
}
.rt-topbar a { color: #fff; font-family: var(--fh); font-size: 1rem; text-transform: uppercase; letter-spacing: 0.1em; }
.rt-topbar-right { display: flex; gap: 2rem; }

.rt-header { transition: background-color .5s ease; }
.rt-header.scrolled { background-color: #17376CF2; }
.rt-header-inner {
  display: flex; align-items: center; gap: 1.5rem;
  padding: 0 3rem; height: 70px;
  max-width: var(--mw); margin: 0 auto;
}
.rt-logo {
  color: #fff; font-family: var(--fh); font-size: 1.3rem; font-weight: 400;
  text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap; flex-shrink: 0;
}
.rt-nav { display: flex; align-items: center; list-style: none; flex: 1; justify-content: flex-end; }
.rt-nav > li { position: relative; }
.rt-nav > li > a {
  display: flex; align-items: center; height: 70px; padding: 0 1.2rem;
  color: #fff; font-family: var(--fh); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em;
}
.rt-nav > li > a:hover { color: var(--yellow); }

.rt-dropdown {
  position: absolute; top: 70px; left: 0; min-width: 500px; padding: 2rem;
  background: linear-gradient(135deg, var(--navy), var(--blue));
  display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;
  opacity: 0; visibility: hidden; pointer-events: none; transition: opacity .2s; z-index: 300;
}
.rt-nav > li:hover .rt-dropdown { opacity: 1; visibility: visible; pointer-events: auto; }
.rt-dropdown h4 {
  color: #fff; font-family: var(--fh); font-size: 0.9rem; text-transform: uppercase;
  border-bottom: 1px solid rgba(255,255,255,.3); padding-bottom: .4rem; margin-bottom: .5rem;
}
.rt-dropdown ul { list-style: none; }
.rt-dropdown ul li a { color: rgba(255,255,255,.8); font-size: .85rem; display: block; padding: .25rem 0; }
.rt-dropdown ul li a:hover { color: var(--yellow); }

.rt-phone-btn {
  flex-shrink: 0; color: #fff !important; font-family: var(--fh); font-size: 0.9rem;
  text-transform: uppercase; letter-spacing: 0.1em; padding: .6rem 1.4rem;
  background: transparent; border: 2px solid rgba(255,255,255,.75); white-space: nowrap;
}
.rt-phone-btn:hover { background: rgba(255,255,255,.1); color: #fff !important; }

.rt-mobile-toggle {
  display: none; background: none; border: none; color: #fff; font-size: 1.4rem;
  cursor: pointer; margin-left: auto;
}

/* ======================================================
   PRODUCT HERO — image left, info right
   ====================================================== */
/* ======================================================
   PRODUCT HERO
   ====================================================== */
.sp-hero {
  /* top half: navy→blue gradient | bottom half: white */
  background:
    linear-gradient(to bottom, transparent 50%, #ffffff 50%),
    linear-gradient(90deg, #17376C 0%, #0058FC 100%);
  padding-top: 110px;
}
.admin-bar .sp-hero { padding-top: 142px; }
.sp-hero-inner {
  max-width: var(--mw);
  margin: 0 auto;
  display: flex;
  gap: 0;
  min-height: 620px;
}

/* ---- LEFT: image gallery ---- */
.sp-gallery {
  flex: 0 0 44%;
  display: flex;
  flex-direction: column;
}
.sp-main-img {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  min-height: 480px;
  height: 480px;
}
.sp-main-img img {
  max-height: 440px;
  width: auto;
  max-width: 100%;
  object-fit: contain;
  display: block;
}
.sp-gallery-dots {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  padding: 1.2rem 0 2rem;
  background: #fff;
  min-height: 52px;
}
.sp-gallery-dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  background: var(--navy);
  opacity: .25;
  cursor: pointer;
  transition: opacity .2s;
  flex-shrink: 0;
}
.sp-gallery-dot.active { opacity: .9; }

/* ---- RIGHT: info ---- */
.sp-info {
  flex: 1;
  padding: 2.5rem 3rem 2.5rem 2.5rem;
  display: flex;
  flex-direction: column;
}

/* — blue area — */
.sp-hero-title {
  color: #fff;
  font-family: var(--fh);
  font-size: 3.5rem;
  font-weight: 400;
  text-transform: uppercase;
  line-height: 1em;
  margin-bottom: 0.4rem;
  margin-top: 1rem;
}
.sp-hero-subtitle {
  color: rgba(255,255,255,.8);
  font-family: var(--fh);
  font-size: 1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  margin-bottom: 1.2rem;
}
.sp-hero-hr {
  border: none;
  border-top: 2px solid var(--yellow);
  width: 100%;
  margin-bottom: 1.5rem;
}
.sp-made-usa {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
}
.sp-made-flag {
  width: 52px;
  height: auto;
  flex-shrink: 0;
  border: 1px solid rgba(255,255,255,.3);
}
.sp-made-title {
  display: block;
  color: #fff;
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.sp-made-sub {
  display: block;
  color: rgba(255,255,255,.65);
  font-family: var(--fb);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-top: 3px;
}

/* — white area — */
.sp-hero-specs {
  display: flex;
  gap: 2.5rem;
  padding: 1.5rem 0 1.2rem;
}
.sp-hero-spec {
  display: flex;
  align-items: flex-start;
  gap: 0.7rem;
}
.sp-hero-spec-icon {
  color: var(--blue);
  font-size: 1.1rem;
  margin-top: 3px;
  flex-shrink: 0;
}
.sp-hero-spec-label {
  display: block;
  color: rgba(23,55,108,.55);
  font-family: var(--fb);
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 3px;
}
.sp-hero-spec-val {
  display: block;
  color: var(--navy);
  font-family: var(--fh);
  font-size: 0.85rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.sp-short-desc {
  color: #444;
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 1.2rem;
}
.sp-short-desc strong { color: var(--navy); }

/* price + cta side by side */
.sp-price-cta {
  display: flex;
  align-items: stretch;
  gap: 0;
  margin-top: auto;
}
.sp-price-block {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-right: 1.5rem;
}
.sp-from-label {
  display: block;
  color: rgba(23,55,108,.5);
  font-family: var(--fb);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 2px;
}
.sp-price-line {
  display: flex;
  align-items: baseline;
  gap: 0.4rem;
}
.sp-price-currency {
  color: var(--navy);
  font-family: var(--fh);
  font-size: 1rem;
  text-transform: uppercase;
}
.sp-price-amount {
  color: var(--navy);
  font-family: var(--fh);
  font-size: 2rem;
  font-weight: 400;
}
.sp-contact-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 2.5rem;
  background: var(--navy);
  color: #fff;
  font-family: var(--fh);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  text-decoration: none;
  flex-shrink: 0;
  transition: background .2s;
  min-height: 56px;
}
.sp-contact-btn:hover { background: var(--blue); color: #fff; }

/* ======================================================
   CLIENT LOGOS
   ====================================================== */
.rt-clients-wrap { background: #fff; padding: 3rem; border-bottom: 1px solid var(--border); }
.rt-clients-inner { max-width: var(--mw); margin: 0 auto; }
.rt-clients-inner h3 {
  font-family: var(--fh); font-size: 1.1rem; font-weight: 400;
  text-transform: uppercase; letter-spacing: 0.05em; color: var(--navy);
  margin-bottom: 1.5rem; text-align: center;
}
.rt-client-swiper .swiper-slide { display: flex; align-items: center; justify-content: center; }
.rt-client-swiper img {
  max-height: 48px; width: auto; object-fit: contain;
  filter: grayscale(1); opacity: .55; transition: opacity .2s;
}
.rt-client-swiper img:hover { opacity: .9; }
.rt-client-swiper .swiper-button-prev,
.rt-client-swiper .swiper-button-next { color: var(--navy); }
.rt-client-swiper .swiper-button-prev::after,
.rt-client-swiper .swiper-button-next::after { font-size: 1rem; }

/* ======================================================
   VALUE PROPOSITION
   ====================================================== */
.sp-value-wrap { background: var(--navy); padding: 6rem 3rem; }
.sp-value-inner { max-width: var(--mw); margin: 0 auto; }
.sp-value-header { text-align: center; margin-bottom: 3rem; }
.sp-value-header h2 {
  color: #fff; font-family: var(--fh); font-size: 2.5rem; font-weight: 400;
  text-transform: uppercase; line-height: 1.1; margin-bottom: 1rem;
}
.sp-value-header p { color: rgba(255,255,255,.65); font-size: 1rem; max-width: 640px; margin: 0 auto; }

.sp-value-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.sp-value-card {
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(255,255,255,.1);
  overflow: hidden;
}
.sp-value-card-img {
  width: 100%;
  aspect-ratio: 16/9;
  object-fit: cover;
  display: block;
}
.sp-value-card-body { padding: 2rem; }
.sp-value-card-label {
  color: var(--yellow);
  font-family: var(--fb);
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 0.5rem;
}
.sp-value-card h3 {
  color: #fff; font-family: var(--fh); font-size: 1.5rem; font-weight: 400;
  text-transform: uppercase; line-height: 1.1; margin-bottom: 1rem;
}
.sp-value-card p { color: rgba(255,255,255,.7); font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem; }

/* ======================================================
   ENGINEERING / DESCRIPTION
   ====================================================== */
.sp-eng-wrap { background: #fff; padding: 6rem 3rem; }
.sp-eng-inner { max-width: var(--mw); margin: 0 auto; }
.sp-eng-header { margin-bottom: 3rem; }
.sp-eng-header .rt-label { font-size: 1rem; }
.sp-eng-header h2 {
  color: var(--navy); font-family: var(--fh); font-size: 1.2rem; font-weight: 300;
  text-transform: none; letter-spacing: 0; line-height: 1.4; margin-top: 0.3rem;
}
.sp-eng-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start; }
.sp-eng-desc h3 {
  font-family: var(--fh); font-size: 1.3rem; font-weight: 400;
  text-transform: uppercase; color: var(--navy); margin: 1.5rem 0 0.5rem;
}
.sp-eng-desc h3:first-child { margin-top: 0; }
.sp-eng-desc p { font-size: 1rem; line-height: 1.7; color: #444; }

.sp-eng-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; background: var(--border); }
.sp-eng-card {
  background: #fff; padding: 2rem 1.5rem;
  border-bottom: 3px solid transparent;
  transition: border-color .2s;
}
.sp-eng-card:hover { border-bottom-color: var(--yellow); }
.sp-eng-card-icon {
  width: 40px; height: 40px;
  background: var(--navy); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem; margin-bottom: 1rem;
}
.sp-eng-card h4 {
  font-family: var(--fh); font-size: 1rem; font-weight: 400;
  text-transform: uppercase; letter-spacing: 0.03em; color: var(--navy); margin-bottom: 0.5rem;
}
.sp-eng-card p { font-size: 0.9rem; color: #555; line-height: 1.5; margin: 0; }
.sp-trademark { color: var(--blue); font-size: 0.6em; vertical-align: super; }

/* ======================================================
   SPECIFICATIONS
   ====================================================== */
.sp-specs-wrap { background: var(--navy); padding: 6rem 3rem; }
.sp-specs-inner { max-width: var(--mw); margin: 0 auto; }
.sp-specs-header { text-align: center; margin-bottom: 3rem; }
.sp-specs-header h2 {
  color: #fff; font-family: var(--fh); font-size: 2.5rem; font-weight: 400;
  text-transform: uppercase; margin-bottom: 0.5rem;
}
.sp-specs-header p { color: rgba(255,255,255,.6); font-size: 0.95rem; }
.sp-specs-header p a { color: var(--yellow); }

.sp-specs-group { margin-bottom: 2.5rem; }
.sp-specs-group-title {
  color: #fff;
  font-family: var(--fh);
  font-size: 1.1rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  border-bottom: 1px solid rgba(255,255,255,.15);
  padding-bottom: 0.75rem;
  margin-bottom: 1.5rem;
}
.sp-specs-group-title i { margin-right: 0.5rem; font-size: 0.9rem; opacity: .6; }
.sp-specs-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem 2rem;
}
.sp-spec-item-label {
  color: rgba(255,255,255,.45);
  font-family: var(--fb);
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 3px;
}
.sp-spec-item-val {
  color: #fff;
  font-family: var(--fh);
  font-size: 1rem;
  font-weight: 400;
}

.sp-specs-images {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 3rem;
  border-top: 1px solid rgba(255,255,255,.1);
  padding-top: 2rem;
}
.sp-specs-images img {
  width: 100%;
  aspect-ratio: 1;
  object-fit: contain;
  background: rgba(255,255,255,.04);
  padding: 1rem;
  border: 1px solid rgba(255,255,255,.08);
}

/* ======================================================
   OUR MARKETS (carousel)
   ====================================================== */
.sp-markets-wrap { background: #fff; padding: 6rem 3rem; }
.sp-markets-inner { max-width: var(--mw); margin: 0 auto; }
.sp-markets-inner h2 {
  font-family: var(--fh); font-size: 2.5rem; font-weight: 400;
  text-transform: uppercase; color: var(--navy); margin-bottom: 0.75rem;
}
.sp-markets-inner p { color: #555; font-size: 1rem; margin-bottom: 2.5rem; max-width: 700px; }

.sp-market-swiper { position: relative; }
.sp-market-card {
  display: block; text-decoration: none;
  border: 1px solid var(--border);
  overflow: hidden;
}
.sp-market-card img { width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block; }
.sp-market-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1rem 1.2rem;
  border-top: 1px solid var(--border);
}
.sp-market-footer h4 {
  font-family: var(--fh); font-size: 1rem; font-weight: 400;
  text-transform: uppercase; color: var(--navy); margin: 0;
}
.sp-market-footer a {
  font-family: var(--fb); font-size: 0.8rem; color: var(--blue); text-transform: uppercase;
}

.sp-market-swiper .swiper-button-prev,
.sp-market-swiper .swiper-button-next { color: var(--navy); }
.sp-market-swiper .swiper-button-prev::after,
.sp-market-swiper .swiper-button-next::after { font-size: 1rem; }

/* ======================================================
   BIG CTA SECTION
   ====================================================== */
.sp-cta-section {
  position: relative;
  min-height: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  text-align: center;
  padding: 6rem 3rem;
}
.sp-cta-video {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: cover; z-index: 0;
}
.sp-cta-overlay {
  position: absolute; inset: 0;
  background: rgba(23,55,108,.75);
  z-index: 1;
}
.sp-cta-content {
  position: relative; z-index: 2;
  max-width: 700px;
}
.sp-cta-content h2 {
  color: #fff; font-family: var(--fh); font-size: 4rem; font-weight: 400;
  text-transform: uppercase; line-height: 1; margin-bottom: 1.5rem;
}
.sp-cta-content p { color: rgba(255,255,255,.8); font-size: 1.1rem; margin-bottom: 2rem; }

/* ======================================================
   TESTIMONIALS
   ====================================================== */
.rt-testimonials-wrap { background: var(--navy); padding: 4rem 3rem 5rem; }
.rt-testimonials-inner { max-width: var(--mw); margin: 0 auto; }
.rt-reviews-swiper { padding-bottom: 3rem; }
.rt-review { border: 1px solid rgba(255,255,255,.1); overflow: hidden; background: rgba(255,255,255,.04); }
.rt-review-head {
  background: rgba(255,255,255,.08);
  display: flex; align-items: center; gap: 1rem; padding: 1.2rem;
}
.rt-review-logo {
  width: 54px; height: 54px; object-fit: contain; flex-shrink: 0;
  background: #fff; padding: 4px;
}
.rt-review-name {
  color: #fff; font-family: var(--fh); font-size: .7rem;
  text-transform: uppercase; letter-spacing: 0.05em; line-height: 1.4;
}
.rt-stars { color: var(--yellow); font-size: 0.9rem; margin-top: .3rem; }
.rt-review-body { padding: 1.5rem; }
.rt-review-body p { font-size: 0.95rem; color: rgba(255,255,255,.75); margin: 0; line-height: 1.6; }
.rt-reviews-swiper .swiper-pagination-bullet { background: rgba(255,255,255,.4); }
.rt-reviews-swiper .swiper-pagination-bullet-active { background: var(--yellow); }

/* ======================================================
   FOOTER
   ====================================================== */
.rt-footer-wrap { background: var(--bg); padding: 4rem 3rem; border-top: 1px solid var(--border); }
.rt-footer-inner { max-width: var(--mw); margin: 0 auto; }
.rt-footer-cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3rem; margin-bottom: 2rem; }
.rt-footer-col h4 {
  font-family: var(--fh); font-size: 1.1rem; font-weight: 400;
  text-transform: uppercase; color: var(--navy); margin-bottom: 1rem;
}
.rt-footer-col p { font-size: 0.95rem; color: #555; }
.rt-footer-col ul { list-style: none; }
.rt-footer-col ul li { margin-bottom: .5rem; }
.rt-footer-col ul li a { color: #555; font-size: 0.95rem; }
.rt-footer-col ul li a:hover { color: var(--blue); }
.rt-footer-bottom {
  display: flex; justify-content: space-between; align-items: center;
  font-size: .85rem; color: #555; flex-wrap: wrap; gap: 1rem;
}
.rt-footer-bottom a { color: #555; margin-left: 1.5rem; }
.rt-footer-bottom a:hover { color: var(--blue); }

/* ======================================================
   MOBILE
   ====================================================== */
@media (max-width: 1024px) {
  .sp-hero-inner { flex-direction: column; min-height: auto; }
  .sp-gallery { flex: none; }
  .sp-value-cols { grid-template-columns: 1fr; }
  .sp-eng-cols { grid-template-columns: 1fr; gap: 2rem; }
  .sp-specs-grid { grid-template-columns: repeat(2, 1fr); }
  .sp-specs-images { grid-template-columns: repeat(2, 1fr); }
  .sp-eng-cards { grid-template-columns: 1fr; }
  .rt-footer-cols { grid-template-columns: 1fr 1fr; }
  .rt-nav { display: none; }
  .rt-nav.open {
    display: flex; flex-direction: column; position: fixed; top: 70px; left: 0;
    width: 100%; background: var(--navy); padding: 1rem 0; z-index: 199;
  }
  .rt-nav > li > a { height: auto; padding: 1rem 2rem; }
  .rt-mobile-toggle { display: block; }
  .rt-phone-btn { display: none; }
}
@media (max-width: 767px) {
  .sp-info h1 { font-size: 1.8rem; }
  .sp-specs-grid { grid-template-columns: 1fr 1fr; }
  .sp-specs-images { grid-template-columns: repeat(3, 1fr); }
  .rt-footer-cols { grid-template-columns: 1fr; }
  .sp-cta-content h2 { font-size: 2.5rem; }
  .rt-topbar { display: none; }
}
</style>
</head>

<body class="woocommerce single-product">

<!-- ============================
     HEADER
     ============================ -->
<div class="rt-header-wrap">
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

  <div class="rt-header" id="rt-header">
    <div class="rt-header-inner">
      <a href="<?php echo $site_url; ?>" class="rt-logo">Rutherford &amp; Titan</a>

      <ul class="rt-nav" id="rt-nav">
        <li>
          <a>Solutions <i class="fas fa-chevron-down" style="font-size:.6rem;margin-left:3px;"></i></a>
          <div class="rt-dropdown">
            <div>
              <h4>LN2 Generators</h4>
              <ul>
                <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/">Start Here</a></li>
                <li><a href="<?php echo $site_url; ?>/product-category/liquid-nitrogen-generators/">Our Generators</a></li>
                <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/membrane-and-pressure-swing-adsorbtion-comparison/">Membrane vs PSA</a></li>
                <li><a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/">LN2 Prices in the US</a></li>
              </ul>
            </div>
            <div>
              <h4>Storage &amp; Safety</h4>
              <ul>
                <li><a href="<?php echo $site_url; ?>/product-category/bulk-storage-tanks/">Bulk Storage Tanks</a></li>
                <li><a href="<?php echo $site_url; ?>/product-category/cryogenic-hoses-pipes/">Cryogenic Hoses &amp; Pipes</a></li>
                <li><a href="<?php echo $site_url; ?>/product-category/gas-safety-systems/">Safety Systems</a></li>
                <li><a href="<?php echo $site_url; ?>/product-category/accessories/">Accessories</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li><a href="<?php echo $site_url; ?>/industrial-gas-solutions/">Clients &amp; Applications</a></li>
        <li><a href="<?php echo $site_url; ?>/about-rutherford-titan/">About Us</a></li>
        <li><a href="<?php echo $site_url; ?>/contact/">Contact</a></li>
      </ul>

      <a href="tel:+12819403597" class="rt-phone-btn rt-btn">Call (281) 940-3597</a>
      <button class="rt-mobile-toggle" id="rt-toggle" aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>
</div>

<!-- ============================
     PRODUCT HERO
     ============================ -->
<section class="sp-hero">
  <div class="sp-hero-inner">

    <!-- LEFT: image gallery -->
    <div class="sp-gallery">
      <?php
      $gallery_srcs = [];
      foreach ( $gallery_ids as $img_id ) {
        $src = wp_get_attachment_image_url( $img_id, 'large' );
        if ( $src ) $gallery_srcs[] = $src;
      }
      $first_src = $gallery_srcs[0] ?? '';
      ?>
      <div class="sp-main-img">
        <?php if ( $first_src ) : ?>
          <img src="<?php echo esc_url( $first_src ); ?>"
               alt="<?php echo esc_attr( $title ); ?>"
               id="sp-main-img-tag">
        <?php endif; ?>
      </div>
      <!-- dots on white area -->
      <div class="sp-gallery-dots">
        <?php foreach ( $gallery_srcs as $i => $src ) : ?>
          <div class="sp-gallery-dot<?php echo $i === 0 ? ' active' : ''; ?>"
               data-src="<?php echo esc_url( $src ); ?>"></div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- RIGHT: product info -->
    <div class="sp-info">

      <!-- BLUE AREA: title, subtitle, divider, made in USA -->
      <p class="sp-hero-title">Titan 10 L/Day</p>
      <p class="sp-hero-subtitle">10 Liquid Nitrogen Generator</p>
      <hr class="sp-hero-hr">

      <div class="sp-made-usa">
        <img class="sp-made-flag"
             src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg"
             alt="USA Flag">
        <div>
          <span class="sp-made-title">Made in USA</span>
          <span class="sp-made-sub">Used by NASA, FBI, SOCOM, and Air Force</span>
        </div>
      </div>

      <!-- WHITE AREA: specs, description, price+cta -->
      <div class="sp-hero-specs">
        <div class="sp-hero-spec">
          <i class="fas fa-tint sp-hero-spec-icon"></i>
          <div>
            <span class="sp-hero-spec-label">Capacity</span>
            <span class="sp-hero-spec-val">Produce up to 10 liters per day</span>
          </div>
        </div>
        <div class="sp-hero-spec">
          <i class="fas fa-database sp-hero-spec-icon"></i>
          <div>
            <span class="sp-hero-spec-label">Storage</span>
            <span class="sp-hero-spec-val">Large 55 liters tank included</span>
          </div>
        </div>
      </div>

      <?php if ( $short_desc ) : ?>
        <div class="sp-short-desc"><?php echo wp_kses_post( $short_desc ); ?></div>
      <?php endif; ?>

      <div class="sp-price-cta">
        <div class="sp-price-block">
          <span class="sp-from-label">From</span>
          <div class="sp-price-line">
            <span class="sp-price-currency">USD</span>
            <span class="sp-price-amount"><?php echo number_format( (float) $price_raw, 0, '.', ',' ); ?></span>
          </div>
        </div>
        <a href="<?php echo $site_url; ?>/contact/" class="sp-contact-btn">Contact Us</a>
      </div>

    </div>

  </div>
</section>

<!-- ============================
     CLIENT LOGOS
     ============================ -->
<div class="rt-clients-wrap">
  <div class="rt-clients-inner">
    <h3>Trusted choice of leading U.S. laboratories</h3>
    <div class="swiper rt-client-swiper">
      <div class="swiper-wrapper">
        <?php
        $logos = [
          ['ln2-generator-client-logo-air-force.jpeg',               'U.S. Air Force'],
          ['ln2-generator-client-logo-fbi.jpeg',                     'FBI'],
          ['ln2-generator-client-logo-lockhead-martins.jpeg',        'Lockheed Martin'],
          ['ln2-generator-client-logo-morgan-dermatology.jpeg',      'Morgan Dermatology'],
          ['ln2-generator-client-logo-nasa.jpeg',                    'NASA'],
          ['ln2-generator-client-logo-north-arizona-university.jpeg','NAU Arizona'],
          ['ln2-generator-client-logo-pharmative.jpeg',              'Pharmative'],
          ['ln2-generator-client-logo-socom.jpeg',                   'SOCOM'],
          ['ln2-generator-client-logo-toshiba.jpeg',                 'Toshiba'],
          ['ln2-generator-client-logo-university-of-hawai.jpeg',     'University of Hawaii'],
        ];
        foreach ( $logos as $l ) : ?>
        <div class="swiper-slide">
          <img src="<?php echo $uploads_url . '/' . $l[0]; ?>" alt="<?php echo esc_attr($l[1]); ?>" loading="lazy">
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</div>

<!-- ============================
     VALUE PROPOSITION
     ============================ -->
<section class="sp-value-wrap">
  <div class="sp-value-inner">
    <div class="sp-value-header">
      <span class="rt-label rt-label--yellow" style="text-align:center;">Save Money &amp; Gain Control</span>
      <h2>Produce the LN2 You Need at The Best Cost</h2>
      <p>Traditional nitrogen delivery services charge premium rates and often impose delays, shortages, hidden fees, and delivery costs.</p>
    </div>
    <div class="sp-value-cols">
      <div class="sp-value-card">
        <img class="sp-value-card-img" src="<?php echo $uploads_url; ?>/freepik__person-proudly-presenting-a-new-liquid-nitrogen-ge__88993-1024x585.png" alt="Pay 13 Cents Per Liter" loading="lazy" onerror="this.style.display='none'">
        <div class="sp-value-card-body">
          <div class="sp-value-card-label">Less cost</div>
          <h3>Pay 13 Cents Per Liter</h3>
          <p>With lower operational expenses and no delivery fees, you save thousands annually.</p>
          <a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/" class="rt-btn rt-btn--outline-white">Learn More</a>
        </div>
      </div>
      <div class="sp-value-card">
        <img class="sp-value-card-img" src="<?php echo $uploads_url; ?>/freepik__person-using-a-new-liquid-nitrogen-generator-in-a-__88996-1024x585.png" alt="Always Available Supply" loading="lazy" onerror="this.style.display='none'">
        <div class="sp-value-card-body">
          <div class="sp-value-card-label">More freedom</div>
          <h3>Always Available Supply</h3>
          <p>Our system comes with a 55L storage capacity so you always have a backup supply.</p>
          <a href="<?php echo $site_url; ?>/liquid-nitrogen-generators/liquid-nitrogen-price-usa/free-supply-audit/" class="rt-btn rt-btn--outline-white">Free LN2 Supply Audit</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================
     AMERICAN ENGINEERING
     ============================ -->
<section class="sp-eng-wrap">
  <div class="sp-eng-inner">
    <div class="sp-eng-header">
      <h2>American Engineering</h2>
      <p>Smart Technology. Continuous Performance. Guaranteed Reliability.</p>
    </div>
    <div class="sp-eng-cols">
      <!-- Left: full description -->
      <div class="sp-eng-desc">
        <?php if ( $description ) :
          echo wp_kses_post( $description );
        else : ?>
          <p>The Titan 10 liquid nitrogen generator provides a dependable, efficient, and fully automated on-site cryogenic solution. With its compact design, low energy usage, and minimal cooling water requirements, the Titan 10 stands out as one of the most advanced and cost-effective liquid nitrogen systems available today.</p>
          <h3>Engineered for versatility</h3>
          <p>The Titan 10 is built to perform in demanding environments, capable of operating in ambient temperatures up to +125°F when connected to a cooling water supply or compatible chiller — ensuring reliable performance in virtually any climate around the world.</p>
          <h3>Effortless operation</h3>
          <p>Simply connect the unit to power and press start. The system automatically begins producing liquid nitrogen as needed, with an intelligent level-sensing system that controls production by starting and stopping output as required.</p>
          <p>Equipped with an integrated Pressure Boost system, the Titan 10 increases liquid nitrogen yield without additional power or cooling water. Combined with its 'No Loss' pressure maintenance feature, it delivers maximum efficiency.</p>
        <?php endif; ?>
      </div>
      <!-- Right: feature cards -->
      <div class="sp-eng-cards">
        <div class="sp-eng-card">
          <div class="sp-eng-card-icon"><i class="fas fa-sync-alt"></i></div>
          <h4>FlowSync<span class="sp-trademark">™</span> Technology</h4>
          <p>An intelligent control system that continuously monitors internal LN₂ storage levels and automatically adjusts production. LN₂ generation only occurs when storage drops below a set threshold, ensuring optimal efficiency, reduced energy consumption, and extended component lifespan.</p>
        </div>
        <div class="sp-eng-card">
          <div class="sp-eng-card-icon"><i class="fas fa-shield-alt"></i></div>
          <h4>1-Year Warranty</h4>
          <p>Comprehensive warranty coverage includes all parts, labor, and technical support for 12 months from the date of installation. Our U.S.-based service team provides direct assistance, remote diagnostics, and rapid replacement of any defective components.</p>
        </div>
        <div class="sp-eng-card">
          <div class="sp-eng-card-icon"><i class="fas fa-wifi"></i></div>
          <h4>SmartConnect<span class="sp-trademark">™</span> Monitoring</h4>
          <p>Built-in remote access capability allows authorized engineers to monitor and diagnose system performance in real time via Wi-Fi or Ethernet. This enables predictive maintenance, quick troubleshooting, and minimized downtime — all without requiring on-site service calls.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================
     SPECIFICATIONS
     ============================ -->
<section class="sp-specs-wrap" id="sp-specs">
  <div class="sp-specs-inner">
    <div class="sp-specs-header">
      <h2>Product Specifications</h2>
      <p>For technical questions, please <a href="<?php echo $site_url; ?>/contact/">contact our team</a>.</p>
    </div>

    <!-- Features group -->
    <div class="sp-specs-group">
      <div class="sp-specs-group-title"><i class="fas fa-microchip"></i> Features</div>
      <div class="sp-specs-grid">
        <div><div class="sp-spec-item-label">Production Capacity</div><div class="sp-spec-item-val">10 L/Day</div></div>
        <div><div class="sp-spec-item-label">Weight</div><div class="sp-spec-item-val">450 lbs</div></div>
        <div><div class="sp-spec-item-label">Connectivity</div><div class="sp-spec-item-val">Wi-Fi / Ethernet</div></div>
        <div><div class="sp-spec-item-label">Storage Tank</div><div class="sp-spec-item-val">55 L</div></div>
        <div><div class="sp-spec-item-label">Noise Level</div><div class="sp-spec-item-val">60–65 dBA (at 2 ft)</div></div>
        <div><div class="sp-spec-item-label">FlowSync</div><div class="sp-spec-item-val">Included</div></div>
        <div><div class="sp-spec-item-label">Purity</div><div class="sp-spec-item-val">Greater than 99%</div></div>
        <div><div class="sp-spec-item-label">Mobility</div><div class="sp-spec-item-val">Yes, equipped with rollers</div></div>
        <div><div class="sp-spec-item-label">Dimensions</div><div class="sp-spec-item-val">63″ H × 36″ W × 25″ D</div></div>
        <div><div class="sp-spec-item-label">SmartConnect</div><div class="sp-spec-item-val">Included</div></div>
        <div><div class="sp-spec-item-label">Warranty</div><div class="sp-spec-item-val">1-year</div></div>
      </div>
    </div>

    <!-- Cooling group -->
    <div class="sp-specs-group">
      <div class="sp-specs-group-title"><i class="fas fa-snowflake"></i> Cooling</div>
      <div class="sp-specs-grid">
        <div><div class="sp-spec-item-label">Cooling System</div><div class="sp-spec-item-val">Air cooled</div></div>
        <div><div class="sp-spec-item-label">Air Compressor Output</div><div class="sp-spec-item-val">1.7 CFM</div></div>
        <div><div class="sp-spec-item-label">Technology</div><div class="sp-spec-item-val">PSA</div></div>
      </div>
    </div>

    <!-- Electrical group -->
    <div class="sp-specs-group">
      <div class="sp-specs-group-title"><i class="fas fa-bolt"></i> Electrical</div>
      <div class="sp-specs-grid">
        <div><div class="sp-spec-item-label">Power Supply</div><div class="sp-spec-item-val">120V – 60Hz | 20 Amps</div></div>
        <div><div class="sp-spec-item-label">Power Consumption</div><div class="sp-spec-item-val">2.2 kW/H</div></div>
        <div><div class="sp-spec-item-label">Machine Heat Output</div><div class="sp-spec-item-val">3 kW</div></div>
      </div>
    </div>

    <!-- Product images at bottom of specs -->
    <?php if ( count( $all_img_ids ) >= 2 ) : ?>
    <div class="sp-specs-images">
      <?php foreach ( array_slice( $all_img_ids, 0, 3 ) as $img_id ) :
        $src = wp_get_attachment_image_url( $img_id, 'medium_large' );
        if ( ! $src ) continue;
      ?>
      <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- ============================
     OUR MARKETS
     ============================ -->
<section class="sp-markets-wrap">
  <div class="sp-markets-inner">
    <span class="rt-label">Applications</span>
    <h2>Our Markets</h2>
    <p>We design and manufacture compact liquid nitrogen generators for a wide range of industries. Our systems deliver reliable, on-demand nitrogen right where it's needed.</p>

    <div class="swiper sp-market-swiper">
      <div class="swiper-wrapper">
        <?php
        $markets = [
          ['Research',                  'research-768x514.jpg'],
          ['Laboratory',                'labs-industrial-gas-768x519.jpg'],
          ['Industry',                  'electronic-industry-768x432.jpg'],
          ['Health Industry',           'pharmacy-industry-industrial-gas-768x430.jpg'],
          ['Food Industry',             'food-industry-768x512.jpg'],
          ['IVF &amp; Fertility',       'fertinily-768x512.jpg'],
          ['Dermatology',               '45735.jpg'],
          ['Defense Industry',          'defense-industry-industrial-gas-768x432.jpeg'],
          ['Aerospace',                 'Branding-RT-768x512.jpg'],
          ['Electronic Industry',       'electronic-industry-768x432.jpg'],
        ];
        foreach ( $markets as $m ) :
          $img = $uploads_url . '/' . $m[1];
        ?>
        <div class="swiper-slide">
          <div class="sp-market-card">
            <img src="<?php echo esc_url($img); ?>" alt="<?php echo strip_tags($m[0]); ?>" loading="lazy" onerror="this.style.display='none'">
            <div class="sp-market-footer">
              <h4><?php echo $m[0]; ?></h4>
              <a href="<?php echo $site_url; ?>/contact/">Contact us</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>

<!-- ============================
     BIG CTA / VIDEO SECTION
     ============================ -->
<section class="sp-cta-section">
  <video class="sp-cta-video" autoplay muted playsinline loop>
    <source src="<?php echo $uploads_url; ?>/RT-factory-video.mp4" type="video/mp4">
  </video>
  <div class="sp-cta-overlay"></div>
  <div class="sp-cta-content">
    <h2>Rutherford &amp; Titan</h2>
    <p>RT is American industrial gas solution provider based in Washington State. We specialize in the production, transfer, and store of industrial gases.</p>
    <a href="tel:+12819403597" class="rt-btn">Call (281) 940-3597</a>
  </div>
</section>

<!-- ============================
     TESTIMONIALS
     ============================ -->
<section class="rt-testimonials-wrap">
  <div class="rt-testimonials-inner">
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
              <img src="<?php echo $uploads_url . '/' . $r[0]; ?>" alt="<?php echo esc_attr($r[1]); ?>" class="rt-review-logo">
              <div class="rt-review-info">
                <div class="rt-review-name"><?php echo esc_html($r[1]); ?></div>
                <div class="rt-stars">★★★★★</div>
              </div>
            </div>
            <div class="rt-review-body">
              <p><?php echo esc_html($r[2]); ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<!-- ============================
     FOOTER
     ============================ -->
<footer class="rt-footer-wrap">
  <div class="rt-footer-inner">
    <div class="rt-footer-cols">
      <div class="rt-footer-col">
        <h4>Rutherford &amp; Titan</h4>
        <p>RT is American industrial gas solution provider based in Washington State. We specialize in the production, transfer, and store of industrial gases.</p>
        <p style="margin-top:1rem;"><strong>Follow us</strong></p>
        <a href="https://www.linkedin.com/company/rtcryo" target="_blank" rel="noopener" style="color:var(--navy);font-size:1.5rem;">
          <i class="fab fa-linkedin"></i>
        </a>
      </div>
      <div class="rt-footer-col">
        <h4>LN2 Generators</h4>
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

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* Sticky header */
  var header = document.getElementById('rt-header');
  var topbar = document.getElementById('rt-topbar');
  function onScroll() {
    if (window.scrollY >= 50) {
      header.classList.add('scrolled');
      if (topbar) { topbar.style.opacity = '0'; topbar.style.visibility = 'hidden'; }
    } else {
      header.classList.remove('scrolled');
      if (topbar) { topbar.style.opacity = '1'; topbar.style.visibility = 'visible'; }
    }
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* Mobile nav */
  var toggle = document.getElementById('rt-toggle');
  var nav = document.getElementById('rt-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
      toggle.querySelector('i').className = nav.classList.contains('open') ? 'fas fa-times' : 'fas fa-bars';
    });
  }

  /* Gallery dot switcher */
  var mainImg = document.getElementById('sp-main-img-tag');
  document.querySelectorAll('.sp-gallery-dot').forEach(function(dot) {
    dot.addEventListener('click', function() {
      if (mainImg) mainImg.src = this.getAttribute('data-src');
      document.querySelectorAll('.sp-gallery-dot').forEach(function(d){ d.classList.remove('active'); });
      this.classList.add('active');
    });
  });

  /* Client logos */
  new Swiper('.rt-client-swiper', {
    slidesPerView: 6, spaceBetween: 24, loop: true, speed: 500,
    navigation: { nextEl: '.rt-client-swiper .swiper-button-next', prevEl: '.rt-client-swiper .swiper-button-prev' },
    breakpoints: { 320: { slidesPerView: 2 }, 768: { slidesPerView: 4 }, 1024: { slidesPerView: 6 } }
  });

  /* Markets carousel */
  new Swiper('.sp-market-swiper', {
    slidesPerView: 3, spaceBetween: 16, loop: true, speed: 500,
    navigation: { nextEl: '.sp-market-swiper .swiper-button-next', prevEl: '.sp-market-swiper .swiper-button-prev' },
    breakpoints: { 320: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
  });

  /* Testimonials */
  new Swiper('.rt-reviews-swiper', {
    slidesPerView: 3, spaceBetween: 24, loop: true, speed: 500,
    pagination: { el: '.rt-reviews-swiper .swiper-pagination', clickable: true },
    breakpoints: { 320: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
  });

});

</script>

<?php wp_footer(); ?>
</body>
</html>
