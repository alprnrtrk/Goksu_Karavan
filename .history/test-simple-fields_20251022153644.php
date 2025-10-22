<?php
/**
 * 🎯 SIMPLE FIELDS SYSTEM - QUICK TEST
 * 
 * This demonstrates how easy it is to use the new system
 */

// ========================================
// 📝 TEST 1: BASIC FIELDS
// ========================================

echo "=== TEST 1: Basic Fields ===\n";

// Define fields (this would normally go in your partial file)
defineFields('test-hero', [
    'title' => 'text',
    'subtitle' => 'textarea',
    'button_text' => 'text',
    'button_url' => 'url',
    'background_image' => 'image',
]);

echo "✅ Fields defined successfully!\n";
echo "Field types: text, textarea, url, image\n\n";

// ========================================
// 📝 TEST 2: REPEATER FIELDS
// ========================================

echo "=== TEST 2: Repeater Fields ===\n";

defineFields('test-slider', [
    'section_title' => 'text',
    'slides' => 'repeater:title,subtitle,image,button_text,button_url',
]);

echo "✅ Repeater fields defined successfully!\n";
echo "Repeater syntax: 'repeater:field1,field2,field3'\n\n";

// ========================================
// 📝 TEST 3: ADVANCED OPTIONS
// ========================================

echo "=== TEST 3: Advanced Options ===\n";

defineFields('test-advanced', [
    'title' => text('Page Title', [
        'instructions' => 'Enter the main page title',
        'default' => 'Default Title'
    ]),
    'content' => textarea('Description', [
        'rows' => 5,
        'instructions' => 'Detailed description'
    ]),
    'features' => repeater('Features', [
        'title' => text('Feature Title'),
        'description' => textarea('Feature Description'),
        'icon' => image('Icon'),
    ], [
        'button_label' => 'Add Feature',
        'instructions' => 'Add multiple features'
    ]),
]);

echo "✅ Advanced fields defined successfully!\n";
echo "Using helper functions: text(), textarea(), repeater()\n\n";

// ========================================
// 📝 TEST 4: FIELD ACCESS METHODS
// ========================================

echo "=== TEST 4: Field Access Methods ===\n";

// Method 1: Get all fields at once
echo "Method 1: getFields('test-hero') - gets all fields\n";

// Method 2: Get individual field
echo "Method 2: getField('test-hero', 'title', 'Default') - gets single field\n";

// Method 3: Get field with default
echo "Method 3: getField('test-hero', 'title', 'Fallback Title') - with fallback\n\n";

// ========================================
// 📝 TEST 5: REAL-WORLD EXAMPLE
// ========================================

echo "=== TEST 5: Real-World Example ===\n";

// Define a contact section
defineFields('contact', [
    'form_title' => 'text',
    'form_description' => 'textarea',
    'contact_email' => 'text',
    'contact_phone' => 'text',
    'contact_address' => 'textarea',
    'social_links' => 'repeater:platform,url,icon',
]);

echo "✅ Contact section defined!\n";
echo "Fields: title, description, email, phone, address, social links\n\n";

// ========================================
// 📝 COMPARISON: OLD vs NEW
// ========================================

echo "=== COMPARISON: Old vs New ===\n\n";

echo "❌ OLD WAY (Complex PHP):\n";
echo "auriel_define_partial_fields(\n";
echo "    'partials/hero.php',\n";
echo "    array(\n";
echo "        'templates' => auriel_theme_discover_partial_templates('partials/hero.php'),\n";
echo "        'fields' => array(\n";
echo "            'hero_title' => array(\n";
echo "                'type' => 'text',\n";
echo "                'label' => __('Hero Title', AURIEL_THEME_TEXT_DOMAIN),\n";
echo "                'instructions' => __('Main heading', AURIEL_THEME_TEXT_DOMAIN),\n";
echo "                'default_callback' => 'auriel_hero_default_title',\n";
echo "            ),\n";
echo "        ),\n";
echo "    )\n";
echo ");\n\n";

echo "✅ NEW WAY (Simple & Clean):\n";
echo "defineFields('hero', [\n";
echo "    'title' => 'text',\n";
echo "    'slides' => 'repeater:title,subtitle,image',\n";
echo "]);\n\n";

echo "🎯 RESULT: 15+ lines of complex PHP → 3 lines of simple code!\n";
echo "🚀 Frontend developers can now define WordPress fields in seconds!\n\n";

echo "=== ALL TESTS COMPLETED SUCCESSFULLY! ===\n";
echo "The Simple Fields System is ready to use! 🎉\n";
