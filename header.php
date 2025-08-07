<?php
/**
 * Header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="text-center">
        <div class="container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <h1><?php bloginfo('name'); ?></h1>
            <?php endif; ?>
            <p><?php bloginfo('description'); ?></p>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primary-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu-nav',
                    'container' => false,
                    'menu_class' => 'navbar-nav mx-auto',
                    'fallback_cb' => 'stpaulsdillsburg_fallback_menu',
                    'walker' => class_exists('WP_Bootstrap_Navwalker') ? new WP_Bootstrap_Navwalker() : null,
                    'depth' => 2,
                ));
                ?>
            </div>
        </div>
    </nav>