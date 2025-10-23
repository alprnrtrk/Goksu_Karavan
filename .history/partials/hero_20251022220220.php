<?php
declare(strict_types=1);

auriel_partials_enqueue_script('hero');
$fields = auriel_partials_get_fields('hero');
$heading = (string) ($fields['heading'] ?? '');
$image_id = (int) ($fields['image'] ?? 0);
?>

<section data-partial="hero" class="relative w-screen h-screen bg-blue-500">
</section>