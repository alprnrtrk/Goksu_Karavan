<?php

declare(strict_types=1);

$test_partial_fields = auriel_theme_get_fields(
  array(
    'test_partial_title',
    'test_partial_subtitle',
  )
);

$test_partial_title = (string) ($test_partial_fields['test_partial_title'] ?? '');
$test_partial_subtitle = (string) ($test_partial_fields['test_partial_subtitle'] ?? '');

?>

<section>
  <h2><?php echo esc_html($test_partial_title); ?></h2>
  <p><?php echo esc_html($test_partial_subtitle); ?></p>
</section>