<?php
/**
 * Custom Walker for Kaiyun Sports Utility Menu
 */
class Kaiyun_Utility_Menu_Walker extends Walker_Nav_Menu {
    
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
        $classes[] = 'utility-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="utility-item ' . esc_attr( $class_names ) . '"' : ' class="utility-item"';

        $id = apply_filters( 'nav_menu_item_id', 'utility-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        // Get icon based on menu item title
        $icon = $this->get_utility_icon($item->title);

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<img src="' . $icon . '" alt="icon" class="utility-icon" />';
        $item_output .= '<div class="utility-text">';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters( 'the_title', $item->title, $item->ID ) . (isset($args->link_after) ? $args->link_after : '');
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

    /**
     * Get utility icon based on menu item title
     */
    private function get_utility_icon($title) {
        $icons = array(
            '客服' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAnUExURUxpcXmBo3iBo3d/pHd/n3iAo29/n3iBo3mBpHiBo3h/ond/o3mBpJzE3UMAAAAMdFJOUwDfoWAgfBDPv++QQCPQQ9MAAACoSURBVEjHY2AYBcMOsHSeQQMnVVAUOJ7BAAcTkBXoYCo4E4CsYA4WBQLICs6MKhhkCoKNIUAHlwJYBK/BpaABypPBpeAohMOK25EQO2JwKzi+Acjegc+bB7WiNAdtUMtgUdCArCAGiwIDZAUcmPKHULO3kRIQwCyaBOJswFIIQPP48QScpQTEiDLc5YgjfgOgRpThK4oc8RsANqIMf2nmcSJhtEgfrAAAfMvbf+B1k00AAAAASUVORK5CYII=',
            '合营' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAMFBMVEVMaXFxf593f594f6J4gKN5gaR4gaN3f6N4gaN5gqR3f6N6gqR4gaR4gaV5f6R5gaQsYbKKAAAAD3RSTlMAECCQot/vP8+PY3+/z1Dxqzn3AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDUlEQVR4nO2V2Q6EIAxFpWwKaP//byczo5FKsegsT5wXk5NLraJlGDqdDovXFnE20OoPqAlXJtXiC8YthzhnSVXxBdOeQ5xkfwTyHKKXfIGhQS35szfwxEq+AA9I/vsFLM2Nki/QNGgkX+BpECQvtKBlX6CyDRuV7M960PRnqngGMCOi1b7V/wAVQlykuVEH0rrXcG8iLW57WW4hbZm2ieTz/fY3JpLNC9g9aRonUqCfbGAbO5tIiQYT28DZt+xo0LFPdmUixbeOR99cACO7/kIBjNz6KwUwMusvFWD5X4FALjcKDK+l4ZODJVgX/nky4acFXCVY881/Y2o92oDcyoHkmQpmjyWQfafTGTYelFs+1xc9oCwAAAAASUVORK5CYII=',
            '优惠' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAALVBMVEVMaXF4gaR3f593f6N3f6N3f6N4gaN4gKN4gaN5gaNvf595f6N4f6R/f595gaTTZVnuAAAADnRSTlMAvyBgQIDvmc/fEFBwEF8XaQMAAAAJcEhZcwAACxMAAAsTAQCanBgAAADqSURBVHic7ZbRDoMgDEULSBFh/f/PXRwaJ2hb47KHjfMmkUO5aBWg0+kcMwXEYJvhwWD0qswCzZi0k2bzGs0aAS1Et5YxeVzGRsV8uwqIyk6GsnhBIXisqy01lx1dqADyfsa7D9tsj7B+w0LaLvIEX8AKCEWkSBIjl0MSpwtJGo2AwrmAVDAPA6oE5lwQVAJ3LnjEexEAgDMCgVn/Q0wDizjf7zeMpoolCi+kqxKzzdPFHOLM2N5dO/ldkCzgj4G6AHoG8IMZoG0b5SUBxdB8K64JDuAFhkT4ljTc7OoAqepJFaj70+t0/pAnjH45u8gzxqUAAAAASUVORK5CYII=',
            'APP' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAPUExURUxpcXd/n3iBpHiBo3mBpHNl0+MAAAAEdFJOUwAgt+8Q7+fsAAAAVklEQVRIx2NgGAWDDzAqu8CBkwAWBcIuSMAQiwIVoDhYIyPICCwKXJAVOONQgACjCkYVjCoYLAooB5S7wQRagjDiUqCCrMCJnEKMUQUhbyQwWi0MQgAA4UmGJWExm/IAAAAASUVORK5CYII=',
        );

        return isset($icons[$title]) ? $icons[$title] : $icons['APP'];
    }
}

