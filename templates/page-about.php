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
			<?php get_template_part( 'partials/hero' ); ?>
			<?php get_template_part( 'partials/about-values' ); ?>

			<section class="mx-auto max-w-4xl px-6 text-left">
				<h2 class="text-2xl font-semibold text-primary">
					<?php esc_html_e( 'Hero configuration overview', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</h2>
				<p class="mt-2 text-sm text-text/70">
					<?php esc_html_e( 'Populate these fields on the page editor (ACF meta box) to personalise the hero section.', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</p>
				<dl class="mt-6 grid gap-4 rounded-2xl border border-text/10 bg-white/60 p-6 shadow-sm md:grid-cols-2">
					<?php
					$hero_fields = array(
						'hero_headline'     => __( 'Headline', AURIEL_THEME_TEXT_DOMAIN ),
						'hero_subheading'   => __( 'Subheading', AURIEL_THEME_TEXT_DOMAIN ),
						'hero_button_label' => __( 'Button label', AURIEL_THEME_TEXT_DOMAIN ),
						'hero_button_url'   => __( 'Button URL', AURIEL_THEME_TEXT_DOMAIN ),
					);
					foreach ( $hero_fields as $field_key => $label ) :
						$value = auriel_theme_get_field( $field_key, __( 'Not set', AURIEL_THEME_TEXT_DOMAIN ) );
						?>
						<div>
							<dt class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary">
								<?php echo esc_html( $label ); ?>
							</dt>
							<dd class="mt-2 text-sm text-text/80 break-words">
								<?php echo esc_html( (string) $value ); ?>
							</dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</section>

			<section class="mx-auto max-w-4xl px-6 text-left">
				<article class="prose prose-slate max-w-none">
					<?php the_content(); ?>
				</article>
			</section>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
