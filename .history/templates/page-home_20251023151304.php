<?php
/**
 * Template Name: Home Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main h-[500vh]">
  <?php get_template_part('partials/hero'); ?>
</main>
<?php
get_footer();
