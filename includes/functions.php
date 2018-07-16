<?php
/**
 * Get rid of permalink html from banner edit screen
 * @param  string $html
 * @param  int $id
 * @return string
 */
function whost_remove_banner_permalink_html( $html, $id ) {
    return ( 'banner' !== get_post_type( $id ) ) ? $html : '';
}
add_filter( 'get_sample_permalink_html', 'whost_remove_banner_permalink_html', 10, 2 );

/**
 * Get rid of shortlink html from banner edit screen
 * @param  string $html
 * @param  int $id
 * @return string
 */
function whost_remove_banner_shortlink_html( $html, $id ) {
    return ( 'banner' !== get_post_type( $id ) ) ? $html : '';
}
add_filter( 'pre_get_shortlink', 'whost_remove_banner_shortlink_html', 10, 2 );

if ( ! function_exists( 'whost_prepare_css_properties') ) {
    /**
     * Prepare array of css property value to inline css
     * @param  array $props
     * @return string
     */
    function whost_prepare_css_properties( $props ) {
        $prop_map = array();
        foreach ( $props as $prop => $value ) {
            $value = trim( $value );
            if ( $value === '' || $value === '!important' )
                continue;

            $prop_map[] = "\t{$prop}:{$value};";
        }
        return esc_attr( implode( "\n", $prop_map ) );
    }
}

if ( ! function_exists( 'whost_prepare_css_properties' ) ) {
    /**
     * Prepare array of css property value to inline css
     * @param  array $props
     * @return string
     */
    function whost_prepare_css_properties( $props ) {
        $prop_map = array();
        foreach ( $props as $prop => $value ) {
            $value = trim( $value );
            if ( $value === '' || $value === '!important' )
                continue;

            $prop_map[] = "\t{$prop}:{$value};";
        }
        return esc_attr( implode( "\n", $prop_map ) );
    }
}


if ( ! function_exists( 'whost_get_shortcode_dynamic_styles' ) ) {
    function whost_get_shortcode_dynamic_styles() {
        global $post;
        if ( ! empty( $post ) ) {
            $regex = get_shortcode_regex( whost_shortcode_tags() );
            preg_match_all( '/' . $regex . '/', $post->post_content, $matches );

            if ( $matches ) {
                $i =-1;
                $output = '';
                foreach( $matches[2] as $msc ) {
                    $i++;
                    $class  = new $msc();
                    $params = shortcode_parse_atts( $matches[3][$i] );
                    if ( method_exists( $class, 'map_dynamic_styles' ) ) {
                        $map = $class->map_dynamic_styles( $params );
                        $output .= whost_generate_css_rules( $map );
                    }

                    if ( isset( $matches[5][$i] ) && false !== stripos( $matches[5][$i], '[whost' ) ) {
                        $j =-1;
                        preg_match_all( '/' . $regex . '/', $matches[5][$i], $nested );
                        foreach( $nested[2] as $nestedMsc ) {
                            $j++;
                            $class  = new $nestedMsc();
                            $params = shortcode_parse_atts( $nested[3][$j] );
                            if ( method_exists( $class, 'map_dynamic_styles' ) ) {
                                $map = $class->map_dynamic_styles( $params );
                                $output .= whost_generate_css_rules( $map );
                            }
                        }
                    }
                }
                printf( "<style id='whost-dynamic-styles' type='text/css'>\n%s\n</style>", $output );
            }
        }
    }
    add_action( 'wp_head', 'whost_get_shortcode_dynamic_styles' );
}


if ( ! function_exists( 'whost_generate_css_rules' ) ) {
    function whost_generate_css_rules( $map ) {
        $rules = '';
        if ( ! empty( $map ) ) {
            foreach( $map as $selector => $props ) {
                if ( empty( $props ) )
                    continue;

                $rules .= sprintf( ".%s\n{\n%s\n}\n", esc_attr( $selector ), whost_prepare_css_properties( $props ) );
            }
        }
        return $rules;
    }
}


/**
 * Trim and lowercase param value
 * @param  string $param
 * @return string
 */
if ( ! function_exists( 'whost_sanitize_param' ) ) {
    function whost_sanitize_param( $param ) {
        return strtolower( trim( $param ) );
    }
}

/**
 * Check css units and set default if no unit
 * @param  string $value
 * @param  string $default
 * @return string
 */
if ( ! function_exists( 'whost_check_css_unit' ) ) {
    function whost_check_css_unit( $value, $default = 'px' ) {
        $value  = whost_sanitize_param( $value );
        
        if ( $value === 0 || $value === '0' || $value === '' )
            $value = '0px';

        $values = array_filter( explode( ' ', $value ) );
        $out = array();
        foreach ( $values as $val ) {
            $out[] = whost_sanitize_css_unit( $val, $default );
        }
        return implode( ' ', $out );
    }
}

if ( ! function_exists( 'whost_sanitize_css_unit' ) ) {
    function whost_sanitize_css_unit( $value, $default ) {
        $units = '/-?\d+[px|em|%|pt|cm|ex|mm|in|rem]/';
        if ( preg_match( $units, $value ) ) {
            return $value;
        } else {
            return $value . $default;
        }
    }
}

/**
 * Find out all whost shortcodes
 * @return array
 */
if ( ! function_exists( 'whost_shortcode_tags' ) ) {
    function whost_shortcode_tags() {
        global $shortcode_tags;
        $shortcodes = array_filter(
            array_keys( $shortcode_tags ),
            'whost_filter_whost_shortcodes'
            );
        return $shortcodes;
    }
}

/**
 * Filter only whost shortcodes
 * @param  string $shortcode
 * @return string
 */
if ( ! function_exists( 'whost_filter_whost_shortcodes' ) ) {
    function whost_filter_whost_shortcodes( $shortcode ) {
        return strstr( $shortcode, 'whost_' );
    }
}

/**
 * Generate html data attribute string
 * @param  array    $atts   list of data attributes
 * @return string           generated attributes
 */
if ( ! function_exists( 'whost_html_data_attr' ) ) {
    function whost_html_data_attr( $atts ) {
        $atts_str = '';
        foreach ( $atts as $prop => $val ) {
            $atts_str .= sprintf( 'data-%s="%s" ', $prop, esc_attr( $val ) );
        }
        return $atts_str;
    }
}

/**
 * Create a list of all registered sidebars
 * @return array list of registed sidebar key => name
 */
if ( ! function_exists( 'whost_get_sidebar_list' ) ) {
    function whost_get_sidebar_list() {
        global $wp_registered_sidebars;
        $sidebars = array();
        if ( ! empty( $wp_registered_sidebars ) ) {
            foreach ( $wp_registered_sidebars as $key => $data ) {
                $sidebars[$key] = $data['name'];
            }
        }
        return $sidebars;
    }
}

if ( ! function_exists( 'whost_parse_content_field' ) ) {
    function whost_parse_content_field( $content ) {
        return wpautop( do_shortcode( wp_kses_post( $content ) ) );
    }
}

if ( ! function_exists( 'whost_get_default_param' ) ) {
    function whost_get_default_param( $param_array, $param_name, $default = '' ) {
        return isset( $param_array[$param_name] ) && ! empty( $param_array[$param_name] ) ? $param_array[$param_name] : $default;
        // return tb_get_meta( $param_array, $param_name, $default = '' );
    }
}

if ( ! function_exists( 'tb_get_meta' ) ) {
    function tb_get_meta( $collection, $key, $default = '' ) {
        return ( ! empty( $collection[$key] ) ) ? $collection[$key] : $default;
    }
}

/**
 * List all created menus
 * @return array    menu list
 */
if ( ! function_exists( 'whost_get_all_menues' ) ) {
    function whost_get_all_menues() {
        return get_terms('nav_menu', array(
            'orderby' => 'name',
            'order'   => 'ASC',
            'fields'  => 'id=>name',
            ) );
    }
}

if ( ! function_exists( 'whost_get_font_variant' ) ) {
    function whost_get_font_variant( $variant ) {
        $v = array(
            'weight' => absint( $variant ),
            'style' => preg_replace('/[\d]+/', '', $variant)
            );

        if ( empty( $v['style'] ) ) {
            $v['style'] = 'normal';
        } else if ( $v['style'] === 'italic' && empty( $v['weight'] ) ) {
            $v['weight'] = 400;
            $v['style'] = 'italic';
        } else if ( $v['style'] === 'regular' && empty( $v['weight'] ) ) {
            $v['weight'] = 400;
            $v['style'] = 'normal';
        } elseif ( $v['style'] === 'inherit' ) {
            $v['weight'] = $v['style'];
        }

        return $v;
    }
}

if ( ! function_exists( 'whost_get_google_font_stack' ) ) {
    function whost_get_google_font_stack() {
        $tags = array('body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');
        $font_stack = array();

        foreach( $tags as $tag ) {
            $props = cs_get_option("typography_{$tag}");
            $font = isset( $props['font'] ) ? $props['font'] : 'websafe';
            $family = whost_get_default_param( $props, 'family' );
            $variant = whost_get_default_param( $props, 'variant' );

            if ( $font === 'websafe' ) {
                continue;
            }
            $font_stack[] = "{$family}:" . implode( '', whost_get_font_variant( $variant ) );
        }
        return implode( '|', $font_stack );
    }
}

if ( ! function_exists( 'whost_get_image_sizes' ) ) {
    function whost_get_image_sizes( $flip = false ) {
        global $_wp_additional_image_sizes;
        $output = array(
            'full' => esc_html__( 'Full Size', 'whost-engine' ),
            'large' => esc_html__( 'Large Size [1000x999999]', 'whost-engine' ),
            'medium' => esc_html__( 'Medium Size [650x999999]', 'whost-engine' ),
            );
        foreach( $_wp_additional_image_sizes as $name => $data ) {
            $output[$name] = ucwords( str_replace(array('-','_'), array(' ', ' '), $name) ) . ' [' . $data['width'] . 'x' . $data['height'] . ']';
        }
        if ( $flip ) {
            return array_flip( $output );
        }
        return $output;
    }
}

if ( ! function_exists( 'whost_get_revsliders' ) ) {
    function whost_get_revsliders() {
        if ( !class_exists('RevSliderSlider') ) {
            return array();
        }

        $sl = new RevSliderSlider();
        $sliders = $sl->getAllSliderForAdminMenu();
        $map = array();
        foreach ( $sliders as $slider ) {
            $map[$slider['alias']] = $slider['title'];
        }
        return $map;
    }
}

if ( ! function_exists( 'whost_has_woocommerce' ) ) {
    function whost_has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }
}

if ( ! function_exists( 'masssive_get_attachment' ) ) {
    function masssive_get_attachment( $attachment_id, $size = 'full' ) {
        $attachment = get_post( $attachment_id );
        $image_data = wp_get_attachment_image_src( $attachment_id, $size );
        return array(
            'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption'     => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href'        => get_permalink( $attachment->ID ),
            'link'        => get_post_meta( $attachment->ID, '_whost_attachement_link', true ),
            'src'         => $image_data[0],
            'tags'        => get_post_meta( $attachment->ID, '_whost_attachement_tags', true ),
            'title'       => $attachment->post_title,
        );
    }
}

// used only for empty css props
if ( ! function_exists( 'whost_get_for_empty' ) ) {
    function whost_get_for_empty( $collection, $key, $default = '' ) {
        return isset( $collection[$key] ) && '' !== $collection[$key] ? $collection[$key] : $default;
    }
}

if ( ! function_exists( 'whost_get_banners' ) ) {
    function whost_get_banners( $format = 'reverse' ) {
        $args = array(
            'order'          => 'ASC',
            'orderby'        => 'title',
            'post_type'      => 'banner',
            'posts_per_page' => -1,
            'status'         => 'publish',
            );

        $banners = get_posts( $args );
        $output  = array();

        foreach ( $banners as $banner ) {
            $id   = $banner->ID;

            $meta = get_post_meta( $id, '_whost_banner_type', true );
            $type = isset( $meta['type'] ) ? sprintf( esc_html__( 'Type: %s', 'whost' ), ucwords( $meta['type'] ) ) : '';

            $title = $banner->post_title;
            $title = ( $title ? esc_html( $title ) : esc_html__( 'Banner Default Title', 'whost' ) );

            if ( 'reverse' === $format ) {
                $output["{$title} { {$type} }"] = $id;
            } else {
                $output[$id] = "{$title} { {$type} }";
            }
        }
        return $output;
    }
}

if ( ! function_exists( 'whost_get_portfolio_categories' ) ) {
    /**
     * Get portfolio categorires to usages on vc & option's map
     * @return string
     */
    function whost_get_portfolio_categories($flip = false) {

        $args = array(
            'orderby' => 'name', 
            'order'   => 'ASC',
            'fields'  => 'id=>name',
        ); 
        $out = array();

        $terms = get_terms('portfolio-category', $args);
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $out = (array) $terms;
        }

        if ($flip) {
            return array_flip($out);
        }
        return $terms;

    }
}

if ( ! function_exists( 'whost_get_desc_for_portfolio_cats' ) ) {
    /**
     * Get vc map's description for portfolio categories checkbox 
     * @return string
     */
    function whost_get_desc_for_portfolio_cats() {

        $args = array(
            'orderby'           => 'name', 
            'order'             => 'ASC',
            'fields'            => 'id=>name',
        ); 
        $output = '';

        $terms = get_terms('portfolio-category', $args);
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $output = esc_html__( 'Select portfolio categories (Leave empty to display from all categories)', 'whost-engine' );
        } else{
            $output = sprintf( esc_html__( 'You may didn\'t added any portfolio category yet. You can add categories over here %s', 'whost-engine' ), '<a href="'. esc_url( admin_url("edit-tags.php?taxonomy=portfolio-category&post_type=portfolio") ).'" target="_blank">'. esc_html__( "Portfolio categories", "whost-engine") . '</a>');
        }

        return $output;

    }
}

/**
 * Format translatable string with allowed html tags.
 * Use this function to esc metabox, option and other fields.
 *
 * @param  string $translated_string Translatable format string using __() function
 * @param  array  $placeholdes       Placeholders for format string
 * @return string                    Formated string
 */
function mengine_esc_desc( $translated_string = '', array $placeholdes = array() ) {
    $allowed_tags = array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
        ),
        'br' => array(),
        'i' => array(),
        'em' => array(),
        'strong' => array(),
        'code' => array(),
    );

    return wp_kses( vsprintf( $translated_string, $placeholdes ), $allowed_tags );
}

if ( !function_exists( 'whost_get_attachment_image_url' ) ) {
    function whost_get_attachment_image_url( $attachment_id, $size = 'thumbnail', $icon = false ) {
        $image = wp_get_attachment_image_src( $attachment_id, $size, $icon );
        return isset( $image['0'] ) ? $image['0'] : false;
    }
}

/**
 * Update Visual Composer row shortcode params
 * @return void
 */
function whost_update_row_params() {
    // Update full width param
    vc_update_shortcode_param( 'vc_row', array(
        'type'        => 'dropdown',
        'heading'     => esc_html__( 'Container Type', 'whost-engine' ),
        'param_name'  => 'full_width',
        'std'         => 'boxed',
        'description' => sprintf( esc_html__( 'Fixed container width: %s and fluid container width: %s', 'whost-engine' ), '<code>1170px</code>', '<code>100%</code>' ),
        'value'       => array(
            esc_html__( 'Fluid Container (100%)', 'whost-engine' ) => 'without',
            esc_html__( 'Fixed Container (1170px)', 'whost-engine' ) => 'boxed',
            )
    ) );
}
add_action( 'vc_before_init', 'whost_update_row_params' );
