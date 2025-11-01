<?php
/**
 * Template Name: Package Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="min-h-[90vh]">
  <?php get_template_part('partials/generic-hero'); ?>
  <?php get_template_part('partials/caravan'); ?>
  <?php get_template_part('partials/contact-us'); ?>
</main>
<?php
get_footer();