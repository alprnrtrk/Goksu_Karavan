<?php
declare(strict_types=1);

/**
 * 🎯 SIMPLE HERO PARTIAL - UPDATED WITH NEW SYSTEM
 *
 * This shows how to convert existing complex partials to use the simple system
 */

// ========================================
// 📝 STEP 1: DEFINE FIELDS (SUPER SIMPLE!)
// ========================================

defineFields('hero', [
    'headline' => 'text',
    'subheading' => 'textarea',
    'button_label' => 'text',
    'button_url' => 'url',
    'slides' => 'repeater:title,subtitle,content,button_label,button_url,image_id',
]);

// ========================================
// 📝 STEP 2: GET FIELD DATA (ONE LINE!)
// ========================================

$hero = getFields('hero');

// Extract individual values for easier use
$hero_headline = $hero['headline'] ?: get_the_title();
$hero_subheading = $hero['subheading'] ?: get_bloginfo('description', 'display');
$hero_button_label = $hero['button_label'] ?: __('Explore more', AURIEL_THEME_TEXT_DOMAIN);
$hero_button_url = $hero['button_url'] ?: home_url();
$hero_slides = $hero['slides'] ?: [];

// ========================================
// 📝 STEP 3: RENDER THE PARTIAL (CLEAN HTML!)
// ========================================
?>

<section class="relative isolate overflow-hidden bg-surface text-text" data-partial="hero" data-hero-partial>
    <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-16 text-center">

        <!-- Main Hero Content -->
        <div class="space-y-4" data-hero-animate>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-secondary">
                <?php esc_html_e('Featured', AURIEL_THEME_TEXT_DOMAIN); ?>
            </p>

            <h1 class="text-4xl font-semibold text-primary md:text-5xl">
                <?php echo esc_html($hero_headline); ?>
            </h1>

            <?php if (!empty($hero_subheading)): ?>
                <p class="mx-auto max-w-2xl text-base text-text/80 md:text-lg">
                    <?php echo esc_html($hero_subheading); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($hero_button_label) && !empty($hero_button_url)): ?>
                <div class="flex justify-center">
                    <a class="inline-flex items-center gap-2 rounded-full border border-primary bg-primary px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" href="<?php echo esc_url($hero_button_url); ?>">
                        <?php echo esc_html($hero_button_label); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Slides Carousel -->
        <?php if (!empty($hero_slides)): ?>
            <div class="relative">
                <div class="swiper rounded-2xl border border-text/10 bg-white/70 p-6 shadow-xl backdrop-blur" data-hero-slider>
                    <div class="swiper-wrapper">
                        <?php foreach ($hero_slides as $index => $slide): ?>
                            <div class="swiper-slide">
                                <div class="grid gap-6 md:grid-cols-2 md:items-center">

                                    <!-- Slide Image -->
                                    <?php if (!empty($slide['image_id'])): ?>
                                        <div class="overflow-hidden rounded-2xl bg-surface shadow-inner">
                                            <?php echo wp_get_attachment_image($slide['image_id'], 'large', false, array('class' => 'h-full w-full object-cover', 'loading' => 'lazy')); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Slide Content -->
                                    <div class="text-left space-y-4">
                                        <p class="text-xs font-medium uppercase tracking-widest text-secondary">
                                            <?php
                                            printf(
                                                /* translators: %d is the slide index. */
                                                esc_html__('Slide %d', AURIEL_THEME_TEXT_DOMAIN),
                                                (int) $index + 1
                                            );
                                            ?>
                                        </p>

                                        <h2 class="text-2xl font-semibold text-primary">
                                            <?php echo esc_html($slide['title'] ?: __('Untitled slide', AURIEL_THEME_TEXT_DOMAIN)); ?>
                                        </h2>

                                        <?php if (!empty($slide['subtitle'])): ?>
                                            <p class="text-sm text-text/70">
                                                <?php echo esc_html($slide['subtitle']); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (!empty($slide['content'])): ?>
                                            <div class="prose prose-sm prose-slate max-w-none">
                                                <?php echo wp_kses_post(wpautop($slide['content'])); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($slide['button_label']) && !empty($slide['button_url'])): ?>
                                            <div>
                                                <a class="inline-flex items-center gap-2 rounded-full border border-accent bg-accent px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-accent/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/60" href="<?php echo esc_url($slide['button_url']); ?>">
                                                    <?php echo esc_html($slide['button_label']); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Slider Controls -->
                    <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-2">
                            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-primary/40 text-primary transition hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" data-hero-prev>
                                <span class="sr-only"><?php esc_html_e('Previous slide', AURIEL_THEME_TEXT_DOMAIN); ?></span>
                                &larr;
                            </button>
                            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-primary/40 text-primary transition hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" data-hero-next>
                                <span class="sr-only"><?php esc_html_e('Next slide', AURIEL_THEME_TEXT_DOMAIN); ?></span>
                                &rarr;
                            </button>
                        </div>
                        <div class="flex items-center justify-center gap-2" data-hero-pagination></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>