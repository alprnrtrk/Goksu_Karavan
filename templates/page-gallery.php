<?php
/**
 * Template Name: Gallery Page
 * Description: Lightweight contact layout leveraging theme tokens.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main bg-surface">
  <?php get_template_part('partials/generic-hero2'); ?>
  <?php get_template_part('partials/gallery-own'); ?>
  <?php get_template_part('partials/contact-us2'); ?>
</main>
<?php
get_footer();
