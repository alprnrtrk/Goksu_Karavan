<?php
declare(strict_types=1);

$fields = auriel_text_partial_get_fields();

$heading     = isset( $fields['text_partial_heading'] ) ? (string) $fields['text_partial_heading'] : '';
$body        = isset( $fields['text_partial_body'] ) ? wp_kses_post( (string) $fields['text_partial_body'] ) : '';
$image_id    = isset( $fields['text_partial_image'] ) ? (int) $fields['text_partial_image'] : 0;

$feature_attributes = auriel_theme_resolve_image_attributes( $image_id, 'large' );
$brand_logo_id      = auriel_theme_get_design_token( 'brand_logo', '' );
$brand_attributes   = auriel_theme_resolve_image_attributes( $brand_logo_id, 'medium' );

?>
<section class="auriel-text-tester relative overflow-hidden bg-surface text-text" data-partial="text-tester">
	<div class="mx-auto flex max-w-5xl flex-col gap-10 px-6 py-16 md:flex-row md:items-center">
		<div class="flex-1 space-y-6">
			<?php if ( '' !== $heading ) : ?>
				<h2 class="text-3xl font-semibold text-primary md:text-4xl">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( '' !== $body ) : ?>
				<div class="prose prose-slate max-w-none text-text/80">
					<?php echo wp_kses_post( wpautop( $body ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $brand_attributes['src'] ) ) : ?>
				<div class="rounded border border-primary/20 bg-white/60 p-4 shadow-sm backdrop-blur">
					<p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-secondary">
						<?php esc_html_e( 'Theme Option Logo Preview', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
					<div class="flex items-center justify-center">
						<?php
						echo wp_kses_post(
							auriel_theme_render_image_from_attributes(
								$brand_attributes,
								array(
									'class'    => 'max-h-16 w-auto object-contain',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							)
						);
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $feature_attributes['src'] ) ) : ?>
			<div class="flex w-full max-w-md flex-col items-center gap-3 md:w-80">
				<div class="aspect-video w-full overflow-hidden rounded-2xl border border-primary/10 shadow-lg">
					<?php
					echo wp_kses_post(
						auriel_theme_render_image_from_attributes(
							$feature_attributes,
							array(
								'class'    => 'h-full w-full object-cover',
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						)
					);
					?>
				</div>
				<p class="text-xs text-text/60">
					<?php esc_html_e( 'Feature image rendered via auriel_theme_resolve_image_attributes().', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</p>
			</div>
		<?php endif; ?>
	</div>
</section>
