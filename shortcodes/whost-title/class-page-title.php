<?php
/**
 * whost Heading title shortcode
 *
 * @package whost Engine
 * @author ThemeBucket <themebucket@gmail.com>
 */

class Whost_Heading_Title extends Whost_Shortcode {

    /**
     * Set shortcode directory
     * @return string Directory path
     */
    protected function set_dir() {
        return __DIR__;
    }

    /**
     * Map shortcode dynamic styles
     * @param  array $params
     * @return string
     */
    public function map_dynamic_styles( $params ) {
        $tree                  = array();
        $type                  = whost_get_default_param( $params, 'type', 'default' );
        $title_color           = whost_get_default_param( $params, 'title_color' );
        $af_color              = whost_get_default_param( $params, 'af_title_color' );

        
        $uid                   = $this->get_uid( $params );
        $title_id              = $uid . ' h2';
        $af_color_id           = $uid . ' .af';

        
            $tree[$title_id] = array(
                'color'            => $title_color,
            );
            $tree[$af_color_id] = array(
                'color'            => $af_color,
            );

        return $tree;
    }

    /**
     * Map this shortcode with visual composer
     * @return array
     */
    protected function map() {
        return array(
            'name'     => esc_html__( 'Heading', 'whost' ),
            'base'     => $this->get_tag(),
            'category' => esc_html__( 'Whost', 'whost' ),
            //'icon'     => $this->get_icon('Heading-title'),
            'params'   => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Heading Layout', 'whost' ),
                    'param_name'  => 'type',
                    'description' => esc_html__( 'Chose Heading Layout', 'whost' ),
                    'value'       => array(
                            esc_html__( 'Layout 1', 'whost' ) => 'default',
                            esc_html__( 'Layout 2', 'whost' )  => 'custom'
                        ),
                    ),

                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Heading Title Style', 'whost' ),
                    'param_name'  => 'style',
                    'description' => esc_html__( 'Chose Heading title style', 'whost' ),
                    'value'       => array(
                            esc_html__( 'Style 1', 'whost' ) => 'styleone',
                            esc_html__( 'Style 2', 'whost' )  => 'styletwo'
                        ),
                    ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title Text', 'whost' ),
                    'admin_label' => true,
                    'param_name'  => 'title',
                    'dependency'  => array(
                            'element' => 'style',
                            'value'   => 'styleone'
                        )
                    ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Before Text', 'whost' ),
                    'admin_label' => true,
                    'param_name'  => 'be_text',
                    'dependency'  => array(
                            'element' => 'style',
                            'value'   => 'styletwo'
                        )
                    ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'After Text', 'whost' ),
                    'admin_label' => true,
                    'param_name'  => 'af_text',
                    'dependency'  => array(
                            'element' => 'style',
                            'value'   => 'styletwo'
                        )
                    ),
                
              
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__( 'Title Color', 'whost' ),
                    'param_name'  => 'title_color',
                    'group'       => esc_html__( 'Custom Settings', 'whost'),
                    ),

                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__( 'After Title Color', 'whost' ),
                    'param_name'  => 'af_title_color',
                    'group'       => esc_html__( 'Custom Settings', 'whost'),
                    'dependency'  => array(
                            'element' => 'style',
                            'value'   => 'styletwo'
                        )
                    ),
                )
            );
    }

    /**
     * Render this shortcode
     * @param  array $atts
     * @param  string $content
     * @return string
     */
    public function render( $atts, $content = null ) {
        $defaults = array(
            'type'           => 'default',
            'title'          => '',
            'be_text'        => '',
            'af_text'        => '',
            'title_color'    => '',
            'style'          => 'styleone',
            'uid'            => '',
        );

        $uid         = $this->get_uid( $atts );
        $atts        = shortcode_atts( $defaults, $atts );
        $atts['uid'] = $uid;
        $type        = whost_sanitize_param( $atts['type'] );
        $types       = array('default', 'custom');

        $view = $this->get_view( $type );

        ob_start();
        if ( in_array( $type, $types ) && file_exists( $view ) ) {
            include( $view );
        }
        return ob_get_clean();
    }

}

new Whost_Heading_Title;
