<?php
/**
 * 404 template
 */
get_header(); ?>
<main class="container py-4">
    <h2 class="mb-4">Page Not Found</h2>
    <p>We’re sorry, the page you’re looking for cannot be found. Please check the URL or return to the <a href="<?php echo esc_url(home_url('/')); ?>">homepage</a>.</p>
</main>
<?php get_footer(); ?>