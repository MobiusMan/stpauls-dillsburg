<?php
/**
 * Single post/page template
 */
get_header(); ?>
<main class="full-width-height">
	<div class="container-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h2 class="mb-4"><?php the_title(); ?></h2>
            <div class="content">
				<p class="m-0 p-0">By: <?php echo get_the_author(); ?></p>
				<p class="m-0 p-0"><?php echo get_the_date('F j, Y'); ?></p>
                <?php wp_link_pages(); ?>
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p>No content found.</p>
    <?php endif; ?>
	</div>	
</main>
<?php get_footer(); ?>