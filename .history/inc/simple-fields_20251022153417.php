<?php
declare(strict_types=1);

/**
 * 🎯 SIMPLE FIELDS SYSTEM FOR FRONTEND DEVELOPERS
 * 
 * This makes WordPress fields as easy as React props or Vue data!
 * No more complex PHP arrays or callback functions.
 */

class SimpleFields {
    
    private static array $fields = [];
    private static array $partials = [];
    
    /**
     * 📝 Define fields for a partial - SUPER SIMPLE!
     * 
     * Usage:
     * SimpleFields::define('hero', [
     *     'title' => 'text',
     *     'description' => 'textarea',
     *     'button_text' => 'text',
     *     'button_url' => 'url',
     *     'slides' => 'repeater:title,subtitle,image'
     * ]);
     */
    public static function define(string $partial_name, array $field_definitions): void {
        $normalized_partial = self::normalizePartialName($partial_name);
        
        // Convert simple definitions to complex field configs
        $fields = [];
        foreach ($field_definitions as $field_name => $field_type) {
            $fields[$field_name] = self::parseFieldDefinition($field_name, $field_type);
        }
        
        self::$partials[$normalized_partial] = $fields;
        
        // Register with WordPress
        self::registerPartialFields($normalized_partial, $fields);
    }
    
    /**
     * 🔍 Get field value - SUPER EASY!
     * 
     * Usage:
     * $title = SimpleFields::get('hero', 'title');
     * $slides = SimpleFields::get('hero', 'slides');
     */
    public static function get(string $partial_name, string $field_name, $default = '') {
        $normalized_partial = self::normalizePartialName($partial_name);
        
        // Get the field definition
        $field_config = self::$partials[$normalized_partial][$field_name] ?? null;
        if (!$field_config) {
            return $default;
        }
        
        // Get the value from WordPress
        $value = get_post_meta(get_the_ID(), $field_name, true);
        
        // Return default if empty
        if (empty($value)) {
            return $field_config['default'] ?? $default;
        }
        
        return $value;
    }
    
    /**
     * 📦 Get all fields for a partial - ONE LINE!
     * 
     * Usage:
     * $hero = SimpleFields::all('hero');
     * echo $hero['title'];
     * echo $hero['description'];
     */
    public static function all(string $partial_name): array {
        $normalized_partial = self::normalizePartialName($partial_name);
        $fields = self::$partials[$normalized_partial] ?? [];
        
        $values = [];
        foreach ($fields as $field_name => $config) {
            $values[$field_name] = self::get($partial_name, $field_name);
        }
        
        return $values;
    }
    
    /**
     * 🔧 Parse simple field definitions into complex configs
     */
    private static function parseFieldDefinition(string $field_name, $definition): array {
        // Handle simple string types
        if (is_string($definition)) {
            return self::parseStringDefinition($field_name, $definition);
        }
        
        // Handle array definitions
        if (is_array($definition)) {
            return array_merge([
                'type' => 'text',
                'label' => self::humanizeFieldName($field_name),
            ], $definition);
        }
        
        return [
            'type' => 'text',
            'label' => self::humanizeFieldName($field_name),
        ];
    }
    
    /**
     * 📝 Parse string definitions like "repeater:title,subtitle,image"
     */
    private static function parseStringDefinition(string $field_name, string $definition): array {
        $parts = explode(':', $definition);
        $type = $parts[0];
        
        $config = [
            'type' => $type,
            'label' => self::humanizeFieldName($field_name),
        ];
        
        // Handle repeater fields
        if ($type === 'repeater' && isset($parts[1])) {
            $sub_fields = explode(',', $parts[1]);
            $config['fields'] = [];
            
            foreach ($sub_fields as $sub_field) {
                $sub_field = trim($sub_field);
                $config['fields'][$sub_field] = [
                    'type' => 'text',
                    'label' => self::humanizeFieldName($sub_field),
                ];
            }
        }
        
        return $config;
    }
    
    /**
     * 🏷️ Convert field_name to "Field Name"
     */
    private static function humanizeFieldName(string $name): string {
        return ucwords(str_replace(['_', '-'], ' ', $name));
    }
    
    /**
     * 📁 Normalize partial name
     */
    private static function normalizePartialName(string $name): string {
        $name = trim($name);
        if (!str_ends_with($name, '.php')) {
            $name .= '.php';
        }
        return 'partials/' . ltrim($name, '/');
    }
    
    /**
     * 🔗 Register fields with WordPress
     */
    private static function registerPartialFields(string $partial_name, array $fields): void {
        auriel_define_partial_fields(
            $partial_name,
            [
                'templates' => auriel_theme_discover_partial_templates($partial_name),
                'fields' => $fields,
            ],
            [
                'title' => self::humanizeFieldName(basename($partial_name, '.php')),
            ]
        );
    }
}

/**
 * 🎯 EVEN SIMPLER GLOBAL FUNCTIONS
 * 
 * For developers who want the absolute simplest syntax
 */

/**
 * Define fields for a partial
 */
function defineFields(string $partial, array $fields): void {
    SimpleFields::define($partial, $fields);
}

/**
 * Get a single field value
 */
function getField(string $partial, string $field, $default = '') {
    return SimpleFields::get($partial, $field, $default);
}

/**
 * Get all fields for a partial
 */
function getFields(string $partial): array {
    return SimpleFields::all($partial);
}

/**
 * 🎨 FIELD TYPE HELPERS
 * 
 * These make field definitions even more readable
 */

function text(string $label = '', array $options = []): array {
    return array_merge(['type' => 'text', 'label' => $label], $options);
}

function textarea(string $label = '', array $options = []): array {
    return array_merge(['type' => 'textarea', 'label' => $label], $options);
}

function url(string $label = '', array $options = []): array {
    return array_merge(['type' => 'url', 'label' => $label], $options);
}

function image(string $label = '', array $options = []): array {
    return array_merge(['type' => 'image', 'label' => $label], $options);
}

function number(string $label = '', array $options = []): array {
    return array_merge(['type' => 'number', 'label' => $label], $options);
}

function repeater(string $label, array $sub_fields, array $options = []): array {
    return array_merge([
        'type' => 'repeater',
        'label' => $label,
        'fields' => $sub_fields,
    ], $options);
}
