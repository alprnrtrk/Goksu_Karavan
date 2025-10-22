<?php
declare(strict_types=1);

/**
 * 🎯 SUPER SIMPLE FIELD EXAMPLES
 *
 * These examples show how easy it is now to create WordPress fields!
 * Perfect for frontend developers who hate complex PHP.
 */

// ========================================
// 📝 EXAMPLE 1: SIMPLE HERO SECTION
// ========================================

// Define fields - ONE LINE PER FIELD!
defineFields('hero', [
    'title' => 'text',
    'subtitle' => 'textarea',
    'button_text' => 'text',
    'button_url' => 'url',
    'background_image' => 'image',
]);

// Use in template - SUPER EASY!
function renderHero()
{
    $hero = getFields('hero');

    echo '<section class="hero">';
    echo '<h1>' . esc_html($hero['title']) . '</h1>';
    echo '<p>' . esc_html($hero['subtitle']) . '</p>';

    if ($hero['button_text'] && $hero['button_url']) {
        echo '<a href="' . esc_url($hero['button_url']) . '" class="btn">';
        echo esc_html($hero['button_text']);
        echo '</a>';
    }
    echo '</section>';
}

// ========================================
// 🔄 EXAMPLE 2: REPEATER FIELD (SLIDES)
// ========================================

// Define repeater - STILL SUPER SIMPLE!
defineFields('slider', [
    'title' => 'text',
    'slides' => 'repeater:title,subtitle,image,button_text,button_url',
]);

// Use repeater data
function renderSlider()
{
    $slider = getFields('slider');
    $slides = $slider['slides'] ?? [];

    echo '<div class="slider">';
    echo '<h2>' . esc_html($slider['title']) . '</h2>';

    foreach ($slides as $slide) {
        echo '<div class="slide">';
        echo '<h3>' . esc_html($slide['title']) . '</h3>';
        echo '<p>' . esc_html($slide['subtitle']) . '</p>';

        if ($slide['image']) {
            echo wp_get_attachment_image($slide['image'], 'large');
        }

        if ($slide['button_text'] && $slide['button_url']) {
            echo '<a href="' . esc_url($slide['button_url']) . '">';
            echo esc_html($slide['button_text']);
            echo '</a>';
        }
        echo '</div>';
    }
    echo '</div>';
}

// ========================================
// 🎨 EXAMPLE 3: ADVANCED WITH OPTIONS
// ========================================

// Using helper functions for more control
defineFields('feature-grid', [
    'title' => text('Section Title', ['instructions' => 'Main heading for the feature grid']),
    'subtitle' => textarea('Description', ['rows' => 3]),
    'features' => repeater('Features', [
        'title' => text('Feature Title'),
        'description' => textarea('Feature Description', ['rows' => 2]),
        'icon' => image('Icon'),
        'link' => url('Link URL'),
    ], ['button_label' => 'Add Feature']),
]);

// ========================================
// 🚀 EXAMPLE 4: SINGLE FIELD ACCESS
// ========================================

// Sometimes you just need one field
function renderPageTitle()
{
    $title = getField('hero', 'title', 'Default Title');
    echo '<h1>' . esc_html($title) . '</h1>';
}

// ========================================
// 📱 EXAMPLE 5: RESPONSIVE CONTENT
// ========================================

defineFields('responsive-section', [
    'mobile_title' => 'text',
    'desktop_title' => 'text',
    'mobile_content' => 'textarea',
    'desktop_content' => 'textarea',
    'mobile_image' => 'image',
    'desktop_image' => 'image',
]);

function renderResponsiveSection()
{
    $section = getFields('responsive-section');

    echo '<section class="responsive-section">';

    // Mobile version
    echo '<div class="mobile-only">';
    echo '<h2>' . esc_html($section['mobile_title']) . '</h2>';
    echo '<p>' . esc_html($section['mobile_content']) . '</p>';
    if ($section['mobile_image']) {
        echo wp_get_attachment_image($section['mobile_image'], 'medium');
    }
    echo '</div>';

    // Desktop version
    echo '<div class="desktop-only">';
    echo '<h2>' . esc_html($section['desktop_title']) . '</h2>';
    echo '<p>' . esc_html($section['desktop_content']) . '</p>';
    if ($section['desktop_image']) {
        echo wp_get_attachment_image($section['desktop_image'], 'large');
    }
    echo '</div>';

    echo '</section>';
}

// ========================================
// 🎯 COMPARISON: OLD vs NEW
// ========================================

/*
❌ OLD WAY (Complex PHP - Frontend devs hate this!):
auriel_define_partial_fields(
    'partials/hero.php',
    array(
        'templates' => auriel_theme_discover_partial_templates('partials/hero.php'),
        'fields' => array(
            'hero_title' => array(
                'type' => 'text',
                'label' => __('Hero Title', AURIEL_THEME_TEXT_DOMAIN),
                'instructions' => __('Main heading for hero section', AURIEL_THEME_TEXT_DOMAIN),
                'default_callback' => 'auriel_hero_default_title',
            ),
            'hero_slides' => array(
                'type' => 'repeater',
                'label' => __('Hero Slides', AURIEL_THEME_TEXT_DOMAIN),
                'button_label' => __('Add Slide', AURIEL_THEME_TEXT_DOMAIN),
                'fields' => array(
                    'title' => array(
                        'type' => 'text',
                        'label' => __('Slide Title', AURIEL_THEME_TEXT_DOMAIN),
                    ),
                    'subtitle' => array(
                        'type' => 'textarea',
                        'label' => __('Slide Subtitle', AURIEL_THEME_TEXT_DOMAIN),
                        'rows' => 2,
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => __('Hero Section', AURIEL_THEME_TEXT_DOMAIN),
    )
);

✅ NEW WAY (Simple & Clean - Frontend devs love this!):
defineFields('hero', [
    'title' => 'text',
    'slides' => 'repeater:title,subtitle,image',
]);

$hero = getFields('hero');
echo $hero['title'];
*/
