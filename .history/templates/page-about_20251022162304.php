<?php
/**
 * Template Name: About Page
 * Description: Focuses on hero field values alongside content.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main space-y-16 bg-surface py-12">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'partials/feature-showcase' ); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
