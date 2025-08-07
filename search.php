<?php
/**
 * Search results template
 */
get_header(); ?>
<main class="container py-4">
    <h2 class="mb-4"><?php the_title(); ?></h2>
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h3>
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </article>
        <?php else : ?>
            <div class="col-12">
                <p>No results found. Please try a different search.</p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>