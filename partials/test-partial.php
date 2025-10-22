<?php
declare(strict_types=1);

$fields = auriel_test_partial_get_fields();

$heading       = isset( $fields['dev_heading'] ) ? (string) $fields['dev_heading'] : '';
$intro         = isset( $fields['dev_intro'] ) ? (string) $fields['dev_intro'] : '';
$button_label  = isset( $fields['dev_button_label'] ) ? (string) $fields['dev_button_label'] : '';
$button_url    = isset( $fields['dev_button_url'] ) ? (string) $fields['dev_button_url'] : '';
$stat_number   = isset( $fields['dev_stat_number'] ) ? (int) $fields['dev_stat_number'] : 0;
$feature_image = isset( $fields['dev_feature_image'] ) ? (int) $fields['dev_feature_image'] : 0;
$video_url     = isset( $fields['dev_video_url'] ) ? (string) $fields['dev_video_url'] : '';

$cards = array();
if ( ! empty( $fields['dev_cards'] ) && is_array( $fields['dev_cards'] ) ) {
	foreach ( $fields['dev_cards'] as $card ) {
		if ( ! is_array( $card ) ) {
			continue;
		}

		$cards[] = array(
			'title'       => isset( $card['title'] ) ? (string) $card['title'] : '',
			'description' => isset( $card['description'] ) ? (string) $card['description'] : '',
			'link_label'  => isset( $card['link_label'] ) ? (string) $card['link_label'] : '',
			'link_url'    => isset( $card['link_url'] ) ? (string) $card['link_url'] : '',
			'media'       => isset( $card['media_id'] ) ? auriel_theme_resolve_image_attributes( $card['media_id'], 'medium' ) : auriel_theme_resolve_image_attributes( 0 ),
		);
	}
}

$feature_attributes = auriel_theme_resolve_image_attributes( $feature_image, 'large' );
$brand_logo_id      = auriel_theme_get_design_token( 'brand_logo', '' );
$brand_attributes   = auriel_theme_resolve_image_attributes( $brand_logo_id, 'medium' );

$primary_color = sanitize_hex_color( auriel_theme_get_design_token( 'primary_color', '#3b82f6' ) ) ?: '#3b82f6';
$surface_color = sanitize_hex_color( auriel_theme_get_design_token( 'surface_color', '#ffffff' ) ) ?: '#ffffff';

$inline_style = sprintf(
	'--developer-primary:%1$s; --developer-surface:%2$s;',
	$primary_color,
	$surface_color
);

$video_embed = '';
if ( '' !== $video_url ) {
	$video_embed = wp_oembed_get( $video_url );
}

?>
<section class="auriel-dev-harness relative overflow-hidden bg-[var(--developer-surface)] py-16" data-partial="test-harness" style="<?php echo esc_attr( $inline_style ); ?>">
	<div class="mx-auto flex max-w-6xl flex-col gap-12 px-6">
		<header class="space-y-6 text-center">
			<?php if ( '' !== $heading ) : ?>
				<h2 class="text-3xl font-semibold text-[var(--developer-primary)] md:text-4xl">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( '' !== $intro ) : ?>
				<div class="mx-auto max-w-3xl text-base text-slate-600">
					<?php echo wp_kses_post( wpautop( $intro ) ); ?>
				</div>
			<?php endif; ?>

			<div class="flex flex-wrap items-center justify-center gap-4 text-sm font-semibold uppercase tracking-[0.3em] text-[var(--developer-primary)]">
				<span class="rounded-full border border-[var(--developer-primary)]/30 px-4 py-1">
					<?php esc_html_e( 'auriel_partial_field_* helpers', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</span>
				<span class="rounded-full border border-[var(--developer-primary)]/30 px-4 py-1">
					<?php esc_html_e( 'auriel_theme_get_design_token()', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</span>
				<span class="rounded-full border border-[var(--developer-primary)]/30 px-4 py-1">
					<?php esc_html_e( 'auriel_theme_resolve_image_attributes()', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</span>
			</div>

			<div class="flex flex-col items-center justify-center gap-6 rounded border border-[var(--developer-primary)]/20 bg-white/70 p-6 shadow-sm backdrop-blur md:flex-row">
				<div class="text-left">
					<p class="mb-2 text-xs font-semibold uppercase tracking-[0.25em] text-[var(--developer-primary)]">
						<?php esc_html_e( 'Theme tokens in action', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
					<ul class="space-y-1 text-xs text-slate-600">
						<li><code>auriel_theme_get_design_token( 'primary_color' )</code></li>
						<li><code>auriel_theme_get_design_token( 'surface_color' )</code></li>
						<li><code>auriel_theme_get_design_token( 'brand_logo' )</code></li>
					</ul>
				</div>
				<div class="flex items-center justify-center">
					<?php if ( ! empty( $brand_attributes['src'] ) ) : ?>
						<?php
						echo wp_kses_post(
							auriel_theme_render_image_from_attributes(
								$brand_attributes,
								array(
									'class'    => 'max-h-14 w-auto object-contain',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							)
						);
						?>
					<?php else : ?>
						<span class="text-sm text-slate-500">
							<?php esc_html_e( 'Set a Brand Logo in Theme Settings to preview it.', AURIEL_THEME_TEXT_DOMAIN ); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</header>

		<div class="grid gap-8 md:grid-cols-2">
			<div class="space-y-6 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm backdrop-blur">
				<h3 class="text-lg font-semibold text-[var(--developer-primary)]">
					<?php esc_html_e( 'Text, number & CTA fields', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</h3>
				<?php if ( $stat_number > 0 ) : ?>
					<p class="text-4xl font-semibold text-[var(--developer-primary)]">
						<?php echo esc_html( number_format_i18n( $stat_number ) ); ?>
						<span class="block text-sm font-medium text-slate-500">
							<?php esc_html_e( 'auriel_theme_get_field( \'dev_stat_number\' ) → (int)', AURIEL_THEME_TEXT_DOMAIN ); ?>
						</span>
					</p>
				<?php endif; ?>

				<?php if ( '' !== $button_label && '' !== $button_url ) : ?>
					<a class="inline-flex items-center gap-2 rounded-full border border-[var(--developer-primary)] bg-[var(--developer-primary)] px-5 py-2 text-sm font-semibold text-white transition hover:bg-[var(--developer-primary)]/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[var(--developer-primary)]/50" href="<?php echo esc_url( $button_url ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				<?php endif; ?>

				<code class="block rounded bg-slate-900/5 px-3 py-2 text-xs text-slate-500">
					<?php esc_html_e( 'auriel_theme_get_fields( [ \'dev_heading\', ... ] )', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</code>
			</div>

			<div class="space-y-6 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm backdrop-blur">
				<h3 class="text-lg font-semibold text-[var(--developer-primary)]">
					<?php esc_html_e( 'Media examples', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</h3>

				<?php if ( ! empty( $feature_attributes['src'] ) ) : ?>
					<div class="aspect-video overflow-hidden rounded-xl border border-slate-100">
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
					<p class="text-xs text-slate-500">
						<?php esc_html_e( 'auriel_theme_resolve_image_attributes( $id, \'large\' )', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
				<?php else : ?>
					<p class="text-sm text-slate-500">
						<?php esc_html_e( 'Select a Feature image to see the helper output.', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
				<?php endif; ?>

				<?php if ( '' !== $video_embed ) : ?>
					<div class="aspect-video overflow-hidden rounded-xl border border-slate-100">
						<?php echo wp_kses_post( $video_embed ); ?>
					</div>
					<p class="text-xs text-slate-500">
						<?php esc_html_e( 'wp_oembed_get( auriel_theme_get_field( \'dev_video_url\' ) )', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
				<?php elseif ( '' !== $video_url ) : ?>
					<p class="text-sm text-slate-500">
						<?php esc_html_e( 'Embed preview unavailable – check the URL format.', AURIEL_THEME_TEXT_DOMAIN ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( ! empty( $cards ) ) : ?>
			<div class="space-y-6">
				<h3 class="text-lg font-semibold text-[var(--developer-primary)] text-center">
					<?php esc_html_e( 'Repeater cards', AURIEL_THEME_TEXT_DOMAIN ); ?>
				</h3>
				<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
					<?php foreach ( $cards as $card ) : ?>
						<div class="flex h-full flex-col gap-4 rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm backdrop-blur">
							<?php if ( ! empty( $card['media']['src'] ) ) : ?>
								<div class="aspect-video overflow-hidden rounded-xl border border-slate-100">
									<?php
									echo wp_kses_post(
										auriel_theme_render_image_from_attributes(
											$card['media'],
											array(
												'class'   => 'h-full w-full object-cover',
												'loading' => 'lazy',
											)
										)
									);
									?>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $card['title'] ) : ?>
								<h4 class="text-base font-semibold text-[var(--developer-primary)]">
									<?php echo esc_html( $card['title'] ); ?>
								</h4>
							<?php endif; ?>

							<?php if ( '' !== $card['description'] ) : ?>
								<div class="text-sm text-slate-600">
									<?php echo wp_kses_post( wpautop( $card['description'] ) ); ?>
								</div>
							<?php endif; ?>

							<?php if ( '' !== $card['link_label'] && '' !== $card['link_url'] ) : ?>
								<a class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-[var(--developer-primary)] underline-offset-4 hover:underline" href="<?php echo esc_url( $card['link_url'] ); ?>">
									<?php echo esc_html( $card['link_label'] ); ?>
								</a>
							<?php endif; ?>

							<footer class="text-xs text-slate-400">
								<?php esc_html_e( 'auriel_theme_get_field( \'dev_cards\' ) → iterate entries', AURIEL_THEME_TEXT_DOMAIN ); ?>
							</footer>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
