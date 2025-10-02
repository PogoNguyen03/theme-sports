<?php
/**
 * Custom Walker for Kaiyun Sports Menu
 */
class Kaiyun_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Start the list before the elements are added.
     */
    function start_lvl( &$output, $depth = 0, $args = null ) {
        // No submenu support for this design
    }

    /**
     * End the list after the elements are added.
     */
    function end_lvl( &$output, $depth = 0, $args = null ) {
        // No submenu support for this design
    }

    /**
     * Start the element output.
     */
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<div class="menu-item-content">';
        $item_output .= '<p>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters( 'the_title', $item->title, $item->ID ) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</p>';
        $item_output .= '</div>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * End the element output.
     */
    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

