<?php
/**
 * Static page template
 */
get_header(); ?>
<main class="full-width-height">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <div class="content">
                <?php wp_link_pages(); ?>
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p>No content found.</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>