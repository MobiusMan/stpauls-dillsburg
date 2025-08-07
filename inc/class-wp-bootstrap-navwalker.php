<?php
/**
 * WP_Bootstrap_Navwalker class
 */
if (!class_exists('WP_Bootstrap_Navwalker')) {
    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
        public function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">\n";
        }

        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'nav-item';
            if (in_array('menu-item-has-children', $classes)) {
                $classes[] = 'dropdown';
            }
            if ($item->current || $item->current_item_ancestor || $item->current_item_parent) {
                $classes[] = 'active';
            }

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $output .= $indent . '<li' . $class_names .'>';

            $atts = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target)     ? $item->target     : '';
            $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
            $atts['href']   = !empty($item->url)        ? $item->url        : '';

            if (in_array('menu-item-has-children', $classes)) {
                $atts['class'] = 'nav-link dropdown-toggle';
                $atts['id'] = 'navbarDropdown';
                $atts['role'] = 'button';
                $atts['data-bs-toggle'] = 'dropdown';
                $atts['aria-expanded'] = 'false';
            } else {
                $atts['class'] = 'nav-link';
            }

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters('the_title', $item->title, $item->ID);
            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a' . $attributes . '>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
            $item_output .= isset($args->after) ? $args->after : '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
}
?>
