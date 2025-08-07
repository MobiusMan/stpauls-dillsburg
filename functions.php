<?php
/**
 * Theme setup and functionality
 */

// Enqueue styles and scripts
function stpaulsdillsburg_enqueue_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css', array(), '5.3.5');

    // Enqueue Bootstrap Icons CSS
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');

    // Enqueue theme stylesheet
    wp_enqueue_style('stpaulsdillsburg-style', get_stylesheet_uri(), array('bootstrap-css'), '3.2');

    // Enqueue Bootstrap JS (includes Popper.js)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js', array(), '5.3.5', true);

    // Add custom CSS for single post and card images
    wp_add_inline_style('stpaulsdillsburg-style', '
        .single-post .post-thumbnail img {
            max-width: 100%;
            max-height: 400px;
            height: auto;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto 1rem;
            border-radius: 0.25rem;
        }
        .single-post .post-thumbnail {
            text-align: center;
        }
        .single-post .content img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto 1rem;
            border-radius: 0.25rem;
        }
        .card-img-top {
            max-width: 100%;
            max-height: 200px;
            height: auto;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border-radius: 0.25rem;
        }
    ');
}
add_action('wp_enqueue_scripts', 'stpaulsdillsburg_enqueue_scripts', 999);

// Add debug script to confirm Bootstrap JS is loaded
function stpaulsdillsburg_add_debug_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap JavaScript is not loaded. Check if bootstrap.bundle.min.js is included in the page.');
        } else {
            console.log('Bootstrap JavaScript loaded successfully:', bootstrap);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'stpaulsdillsburg_add_debug_script');

// Theme setup
function stpaulsdillsburg_setup() {
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 200,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register primary menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'stpaulsdillsburg'),
    ));

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'stpaulsdillsburg_setup');

// Fallback menu
function stpaulsdillsburg_fallback_menu() {
    echo '<ul class="navbar-nav mx-auto">';
    echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '</ul>';
}

// Include the nav walker
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

// Shortcode for Worship Times Button
function stpaulsdillsburg_worship_times_button_shortcode() {
    ob_start();
    ?>
    <div class="container my-5 text-center">
        <button type="button" class="btn btn-worship-times" id="worshipTimesButton">
            View Worship Times
        </button>

        <!-- Modal -->
        <div class="modal fade" id="worshipTimesModal" tabindex="-1" aria-labelledby="worshipTimesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="worshipTimesModalLabel">Worship Times</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Sunday Worship Service with Full Liturgy and Music</strong><br>Held on each Sunday at 10:30AM</p>
                        <p>We livestream the 10:30AM service each week through our <a href="https://www.facebook.com/StPaulsDillsburg/" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook me-2"></i> Facebook Page</a></p>
                        <p class="pt-3"><strong>Saturday Worship Service of the Spoken Word</strong><br>Held on the 2nd & 4th Saturdays of each month at 6:30PM</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('worshipTimesButton');
        const modalElement = document.getElementById('worshipTimesModal');
        let isModalOpen = false;

        if (button && modalElement) {
            console.log('Worship times button and modal found.');

            // Function to close the modal
            function closeModal() {
                console.log('Closing modal.');
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                modalElement.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                isModalOpen = false;
            }

            // Function to open the modal
            function openModal() {
                if (isModalOpen) {
                    console.log('Modal is already open, skipping.');
                    return;
                }
                console.log('Opening modal.');
                modalElement.classList.add('show');
                modalElement.style.display = 'block';
                modalElement.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                isModalOpen = true;
            }

            // Handle button click to open modal
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                console.log('Button clicked.');
                openModal();
            });

            // Close modal when clicking outside
            modalElement.addEventListener('click', function(e) {
                if (e.target === modalElement) {
                    console.log('Clicked outside modal.');
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isModalOpen) {
                    console.log('Escape key pressed.');
                    closeModal();
                }
            });

            // Handle modal close via buttons (with fallback)
            function attachCloseButtonListeners() {
                const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
                console.log('Found close buttons:', closeButtons.length);
                closeButtons.forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Close button clicked.');
                        closeModal();
                    });
                });
            }

            // Initial attach
            attachCloseButtonListeners();

            // Fallback: Retry attaching listeners after a short delay
            setTimeout(attachCloseButtonListeners, 1000);
        } else {
            console.error('Button or modal element not found.');
        }
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('worship_times_button', 'stpaulsdillsburg_worship_times_button_shortcode');

// Shortcode to display the latest blog post with featured image
function stpaulsdillsburg_latest_post_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $latest_post = new WP_Query($args);

    ob_start();

    if ($latest_post->have_posts()) {
        while ($latest_post->have_posts()) {
            $latest_post->the_post();
            ?>
            <div class="latest-post container my-3">
                <div class="row align-items-center">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-4">
                            <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid rounded mb-2', 'style' => 'max-height: 150px; width: auto; object-fit: cover;')); ?>
                        </div>
                        <div class="col-md-8">
                    <?php else : ?>
                        <div class="col-md-12">
                    <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="post-meta">
                                <p>Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
                            </div>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-purple">Read More</a>
                        </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('latest_post', 'stpaulsdillsburg_latest_post_shortcode');

// Shortcode for Latest Sermon (by category)
function stpaulsdillsburg_latest_sermon_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'category_name'  => 'sermons', // Adjust to your Sermons category slug
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $latest_sermon = new WP_Query($args);

    ob_start();

    if ($latest_sermon->have_posts()) {
        while ($latest_sermon->have_posts()) {
            $latest_sermon->the_post();
            // Debugging: Log post categories to console
            $categories = wp_get_post_categories(get_the_ID(), array('fields' => 'all'));
            $cat_names = array_map(function($cat) { return $cat->name . ' (slug: ' . $cat->slug . ')'; }, $categories);
            ?>
            <script>
            console.log('Sermon Post: <?php echo esc_js(get_the_title()); ?>', 'Categories: <?php echo esc_js(implode(", ", $cat_names)); ?>');
            </script>
            <div class="latest-sermon container my-3">
                <div class="row align-items-center">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-4">
                            <?php the_post_thumbnail('medium', array('class' => 'img-fluid rounded mb-2', 'style' => 'max-height: 200px; width: auto; object-fit: contain;')); ?>
                        </div>
                        <div class="col-md-8">
                    <?php else : ?>
                        <div class="col-md-12">
                    <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="post-meta">
                                <p>Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
                            </div>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-purple">Read More</a>
                        </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No sermons found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('latest_sermon', 'stpaulsdillsburg_latest_sermon_shortcode');

// Shortcode for Latest Outreach News (by category)
function stpaulsdillsburg_latest_outreach_news_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'category_name'  => 'outreach-news', // Adjust to your Outreach News category slug
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $latest_outreach = new WP_Query($args);

    ob_start();

    if ($latest_outreach->have_posts()) {
        while ($latest_outreach->have_posts()) {
            $latest_outreach->the_post();
            // Debugging: Log post categories to console
            $categories = wp_get_post_categories(get_the_ID(), array('fields' => 'all'));
            $cat_names = array_map(function($cat) { return $cat->name . ' (slug: ' . $cat->slug . ')'; }, $categories);
            ?>
            <script>
            console.log('Outreach Post: <?php echo esc_js(get_the_title()); ?>', 'Categories: <?php echo esc_js(implode(", ", $cat_names)); ?>');
            </script>
            <div class="latest-outreach-news container my-3">
                <div class="row align-items-center">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-4">
                            <?php the_post_thumbnail('medium', array('class' => 'img-fluid rounded mb-2', 'style' => 'max-height: 200px; width: auto; object-fit: contain;')); ?>
                        </div>
                        <div class="col-md-8">
                    <?php else : ?>
                        <div class="col-md-12">
                    <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="post-meta">
                                <p>Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
                            </div>
                            <div class="post-excerpt">
                                <?php echo wp_trim_words(get_the_content(), 30); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-purple">Read More</a>
                        </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>No outreach news found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('latest_outreach_news', 'stpaulsdillsburg_latest_outreach_news_shortcode');

// Shortcode to display all Sermons
function stpaulsdillsburg_all_sermons_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, // Retrieve all posts
        'post_status'    => 'publish',
        'category_name'  => 'sermons', // Adjust to your Sermons category slug
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $sermons = new WP_Query($args);

    ob_start();

    if ($sermons->have_posts()) {
        ?>
        <div class="container my-3">
            <div class="row">
                <?php while ($sermons->have_posts()) : $sermons->the_post(); ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100" style="padding: 0.5rem;">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'card-img-top mb-2')); ?>
                            <?php endif; ?>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p class="card-text mb-2"><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-purple btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
    } else {
        echo '<p>No sermons found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('all_sermons', 'stpaulsdillsburg_all_sermons_shortcode');

// Shortcode to display all Outreach News
function stpaulsdillsburg_all_outreach_news_shortcode() {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, // Retrieve all posts
        'post_status'    => 'publish',
        'category_name'  => 'outreach-news', // Adjust to your Outreach News category slug
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $outreach_news = new WP_Query($args);

    ob_start();

    if ($outreach_news->have_posts()) {
        ?>
        <div class="container my-3">
            <div class="row">
                <?php while ($outreach_news->have_posts()) : $outreach_news->the_post(); ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100" style="padding: 0.5rem;">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'card-img-top mb-2')); ?>
                            <?php endif; ?>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p class="card-text mb-2"><?php echo wp_trim_words(get_the_content(), 30); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-purple btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
    } else {
        echo '<p>No outreach news found.</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('all_outreach_news', 'stpaulsdillsburg_all_outreach_news_shortcode');
?>