<?php
declare(strict_types=1);

/**
 * Enhance single post content with consistent utility classes.
 */
function auriel_theme_enhance_single_post_content(string $content): string
{
  if (!is_singular('post')) {
    return $content;
  }

  if ('' === trim($content)) {
    return $content;
  }

  if (!class_exists('DOMDocument')) {
    return $content;
  }
  $previous_state = libxml_use_internal_errors(true);
  $dom = new \DOMDocument('1.0', 'UTF-8');

  $wrapped_content = '<div>' . $content . '</div>';
  $options = 0;
  if (defined('LIBXML_HTML_NOIMPLIED')) {
    $options |= LIBXML_HTML_NOIMPLIED;
  }
  if (defined('LIBXML_HTML_NODEFDTD')) {
    $options |= LIBXML_HTML_NODEFDTD;
  }

  $loaded = $dom->loadHTML(
    '<?xml encoding="utf-8" ?>' . $wrapped_content,
    $options
  );

  if (false === $loaded) {
    libxml_clear_errors();
    libxml_use_internal_errors($previous_state);
    return $content;
  }

  $targets = array(
    'ul' => array('list-disc', 'pl-6', 'space-y-2'),
    'ol' => array('list-decimal', 'pl-6', 'space-y-2'),
    'li' => array('leading-relaxed'),
    'p' => array('leading-relaxed'),
    'img' => array('rounded-3xl', 'shadow-xl', 'max-w-full', 'transition'),
    'blockquote' => array('border-l-4', 'border-primary/50', 'pl-6', 'italic', 'text-lg', 'text-text/80'),
    'figure' => array('my-12', 'space-y-4'),
    'figcaption' => array('text-sm', 'text-text/60', 'text-center'),
    'table' => array('w-full', 'border-separate', 'border-spacing-y-2'),
    'thead' => array('bg-primary/5'),
    'th' => array('text-left', 'font-semibold', 'pt-4', 'pb-2', 'px-4', 'text-text'),
    'td' => array('bg-surface', 'px-4', 'py-3', 'rounded-2xl', 'shadow-sm', 'text-text/80'),
    'h2' => array('text-3xl', 'font-semibold', 'text-text', 'mt-16', 'mb-6'),
    'h3' => array('text-2xl', 'font-semibold', 'text-text', 'mt-12', 'mb-5'),
    'h4' => array('text-xl', 'font-semibold', 'text-text', 'mt-10', 'mb-4'),
  );

  foreach ($targets as $tag => $classes) {
    $node_list = $dom->getElementsByTagName($tag);
    for ($index = $node_list->length - 1; $index >= 0; $index--) {
      $node = $node_list->item($index);
      if ($node instanceof \DOMElement) {
        auriel_theme_dom_append_classes($node, $classes);
      }
    }
  }

  libxml_clear_errors();
  libxml_use_internal_errors($previous_state);

  $container = $dom->getElementsByTagName('div')->item(0);
  if (!$container instanceof \DOMElement) {
    return $content;
  }

  $html = '';
  foreach ($container->childNodes as $child) {
    $html .= $dom->saveHTML($child);
  }

  return $html;
}
add_filter('the_content', 'auriel_theme_enhance_single_post_content', 15);

/**
 * Append classes to a DOMElement, avoiding duplicates.
 *
 * @param \DOMElement $element Element to modify.
 * @param array<int, string> $classes Classes to append.
 */
function auriel_theme_dom_append_classes(\DOMElement $element, array $classes): void
{
  $current = trim($element->getAttribute('class'));
  $existing = array();

  if ('' !== $current) {
    $existing = preg_split('/\s+/', $current) ?: array();
  }

  foreach ($classes as $class) {
    if (!in_array($class, $existing, true)) {
      $existing[] = $class;
    }
  }

  $element->setAttribute('class', implode(' ', $existing));
}
