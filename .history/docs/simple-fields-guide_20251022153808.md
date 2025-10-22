# 🎯 Simple Fields System - Developer Guide

## The Problem We Solved

**Before:** Frontend developers had to write complex PHP arrays and callback functions just to add a simple text field.

**After:** Frontend developers can define fields in seconds using simple, readable syntax.

## 🚀 Quick Start

### 1. Define Fields (Super Simple!)

```php
// Define fields for any partial
defineFields('hero', [
    'title' => 'text',
    'description' => 'textarea',
    'button_text' => 'text',
    'button_url' => 'url',
    'background_image' => 'image',
]);
```

### 2. Get Field Values (One Line!)

```php
// Get all fields at once
$hero = getFields('hero');
echo $hero['title'];

// Or get individual fields
$title = getField('hero', 'title', 'Default Title');
echo $title;
```

### 3. Use in Templates (Clean!)

```php
<section class="hero">
    <h1><?php echo esc_html(getField('hero', 'title')); ?></h1>
    <p><?php echo esc_html(getField('hero', 'description')); ?></p>

    <?php if (getField('hero', 'button_text')): ?>
        <a href="<?php echo esc_url(getField('hero', 'button_url')); ?>" class="btn">
            <?php echo esc_html(getField('hero', 'button_text')); ?>
        </a>
    <?php endif; ?>
</section>
```

## 📝 Field Types

### Basic Types

```php
defineFields('example', [
    'title' => 'text',           // Text input
    'description' => 'textarea',  // Textarea
    'website' => 'url',          // URL input
    'logo' => 'image',           // Image picker
    'count' => 'number',         // Number input
]);
```

### Repeater Fields (The Magic!)

```php
defineFields('slider', [
    'title' => 'text',
    'slides' => 'repeater:title,subtitle,image,button_text,button_url',
]);

// Use repeater data
$slider = getFields('slider');
foreach ($slider['slides'] as $slide) {
    echo '<div class="slide">';
    echo '<h3>' . esc_html($slide['title']) . '</h3>';
    echo '<p>' . esc_html($slide['subtitle']) . '</p>';
    echo '</div>';
}
```

### Advanced Options

```php
defineFields('advanced', [
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
```

## 🎨 Real-World Examples

### Example 1: Simple Contact Form

```php
// Define fields
defineFields('contact', [
    'form_title' => 'text',
    'form_description' => 'textarea',
    'email' => 'text',
    'phone' => 'text',
    'address' => 'textarea',
]);

// Use in template
$contact = getFields('contact');
?>
<section class="contact">
    <h2><?php echo esc_html($contact['form_title']); ?></h2>
    <p><?php echo esc_html($contact['form_description']); ?></p>

    <div class="contact-info">
        <p>Email: <?php echo esc_html($contact['email']); ?></p>
        <p>Phone: <?php echo esc_html($contact['phone']); ?></p>
        <p>Address: <?php echo esc_html($contact['address']); ?></p>
    </div>
</section>
```

### Example 2: Product Grid

```php
// Define fields
defineFields('products', [
    'section_title' => 'text',
    'products' => 'repeater:name,price,description,image,link',
]);

// Use in template
$products = getFields('products');
?>
<section class="products">
    <h2><?php echo esc_html($products['section_title']); ?></h2>

    <div class="product-grid">
        <?php foreach ($products['products'] as $product): ?>
            <div class="product-card">
                <h3><?php echo esc_html($product['name']); ?></h3>
                <p class="price">$<?php echo esc_html($product['price']); ?></p>
                <p><?php echo esc_html($product['description']); ?></p>

                <?php if ($product['image']): ?>
                    <?php echo wp_get_attachment_image($product['image'], 'medium'); ?>
                <?php endif; ?>

                <?php if ($product['link']): ?>
                    <a href="<?php echo esc_url($product['link']); ?>" class="btn">View Product</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
```

### Example 3: Team Section

```php
// Define fields
defineFields('team', [
    'title' => 'text',
    'subtitle' => 'textarea',
    'members' => 'repeater:name,position,photo,bio,linkedin',
]);

// Use in template
$team = getFields('team');
?>
<section class="team">
    <h2><?php echo esc_html($team['title']); ?></h2>
    <p><?php echo esc_html($team['subtitle']); ?></p>

    <div class="team-grid">
        <?php foreach ($team['members'] as $member): ?>
            <div class="team-member">
                <?php if ($member['photo']): ?>
                    <?php echo wp_get_attachment_image($member['photo'], 'medium'); ?>
                <?php endif; ?>

                <h3><?php echo esc_html($member['name']); ?></h3>
                <p class="position"><?php echo esc_html($member['position']); ?></p>
                <p><?php echo esc_html($member['bio']); ?></p>

                <?php if ($member['linkedin']): ?>
                    <a href="<?php echo esc_url($member['linkedin']); ?>" target="_blank">LinkedIn</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
```

## 🔧 Migration Guide

### Converting Old Complex Fields

**❌ Old Way:**

```php
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
        ),
    )
);
```

**✅ New Way:**

```php
defineFields('hero', [
    'title' => 'text',
]);
```

### Converting Old Field Usage

**❌ Old Way:**

```php
$hero_fields = auriel_theme_get_fields([
    'hero_title',
    'hero_subtitle',
    'hero_button_label',
    'hero_button_url',
]);

$hero_title = (string) ($hero_fields['hero_title'] ?? '');
$hero_subtitle = (string) ($hero_fields['hero_subtitle'] ?? '');
```

**✅ New Way:**

```php
$hero = getFields('hero');
// Or individual fields:
$title = getField('hero', 'title');
```

## 🎯 Best Practices

### 1. Use Descriptive Field Names

```php
// Good
defineFields('hero', [
    'main_title' => 'text',
    'subtitle_text' => 'textarea',
    'cta_button_text' => 'text',
]);

// Avoid
defineFields('hero', [
    'title' => 'text',
    'text' => 'textarea',
    'btn' => 'text',
]);
```

### 2. Group Related Fields

```php
// Good - logical grouping
defineFields('contact', [
    'form_title' => 'text',
    'form_description' => 'textarea',
    'contact_email' => 'text',
    'contact_phone' => 'text',
    'contact_address' => 'textarea',
]);
```

### 3. Use Defaults for Better UX

```php
defineFields('hero', [
    'title' => text('Hero Title', ['default' => 'Welcome to Our Site']),
    'subtitle' => textarea('Subtitle', ['default' => 'Discover amazing content']),
]);
```

### 4. Keep Repeater Fields Simple

```php
// Good - clear, simple repeater
defineFields('testimonials', [
    'section_title' => 'text',
    'testimonials' => 'repeater:name,company,quote,photo',
]);
```

## 🚀 Advanced Usage

### Conditional Fields

```php
$hero = getFields('hero');

if ($hero['show_button']) {
    echo '<a href="' . esc_url($hero['button_url']) . '">';
    echo esc_html($hero['button_text']);
    echo '</a>';
}
```

### Field Validation

```php
$email = getField('contact', 'email');

if (!is_email($email)) {
    echo '<p class="error">Please enter a valid email address</p>';
} else {
    echo '<p>Email: ' . esc_html($email) . '</p>';
}
```

### Dynamic Content

```php
$slides = getField('slider', 'slides', []);

if (count($slides) > 1) {
    echo '<div class="slider-controls">';
    echo '<button class="prev">Previous</button>';
    echo '<button class="next">Next</button>';
    echo '</div>';
}
```

## 🎉 Benefits

1. **⚡ Speed**: Define fields in seconds, not minutes
2. **🧠 Simple**: No complex PHP arrays or callbacks
3. **📖 Readable**: Code is self-documenting
4. **🔄 Consistent**: Same pattern for all field types
5. **🎯 Focused**: Frontend devs can focus on design, not PHP complexity
6. **🚀 Scalable**: Easy to add new fields and partials

## 🤝 Need Help?

- Check the examples in `examples/simple-fields-examples.php`
- Look at `partials/hero-simple.php` for a real implementation
- The system automatically handles WordPress integration - no need to worry about meta boxes, sanitization, or saving!

---

**Happy coding! 🎯**
