<?php
/**
 * Template Name: Gallery Page
 * Description: Lightweight contact layout leveraging theme tokens.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main bg-surface">
  <?php get_template_part('partials/generic-hero'); ?>
  <?php get_template_part('partials/gallery-own'); ?>
  <?php get_template_part('partials/contact-us'); ?>
</main>
<?php
get_footer();
