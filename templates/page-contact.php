<?php
/**
 * Template Name: Contact Page
 * Description: Lightweight contact layout leveraging theme tokens.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main space-y-16 bg-surface py-12">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'partials/hero' ); ?>
			<?php get_template_part( 'partials/contact-details' ); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
