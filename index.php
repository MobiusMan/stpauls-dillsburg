<?php
/**
 * Main template file
 */
get_header(); ?>
<main class="full-width-height">
	<div class="container-page">
    <h2 class="mb-4">Sermons</h2>
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h3>
						<?php echo get_the_date('F j, Y'); ?>
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </article>
        <?php endwhile; else : ?>
            <p class="col-12">No content found.</p>
        <?php endif; ?>
    </div>
	</div>
	
</main>
<?php get_footer(); ?>