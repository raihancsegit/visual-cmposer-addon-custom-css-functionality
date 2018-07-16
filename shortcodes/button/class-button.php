<?php
/**
 * whost Button title shortcode
 *
 * @package whost Engine
 * @author ThemeBucket <themebucket@gmail.com>
 */

class Whost_Button extends Whost_Shortcode {

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
        $type                  = whost_get_default_param( $params, 'type', 'btnone' );
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
            'name'     => esc_html__( 'Button', 'whost' ),
            'base'     => $this->get_tag(),
            'category' => esc_html__( 'Whost', 'whost' ),
            //'icon'     => $this->get_icon('Button-title'),
            'params'   => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Button Layout', 'whost' ),
                    'param_name'  => 'type',
                    'description' => esc_html__( 'Chose Button Layout', 'whost' ),
                    'value'       => array(
                            esc_html__( 'Layout 1', 'whost' ) => 'btnone',
                            esc_html__( 'Layout 2', 'whost' )  => 'btntwo'
                        ),
                    ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Button Text', 'whost' ),
                    'admin_label' => true,
                    'param_name'  => 'btn_text',
                    ), 

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Button Link', 'whost' ),
                    'admin_label' => true,
                    'param_name'  => 'btn_link',
                    ),
              
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__( 'Button Background Color', 'whost' ),
                    'param_name'  => 'btn_bg_color',
                    'group'       => esc_html__( 'Custom Settings', 'whost'),
                    'dependency'  => array(
                            'element' => 'type',
                            'value'   => 'btnone'
                        )
                    ),

                array(
                    'type'        => 'colorpicker',
                    'Button'     => esc_html__( 'Button Text Color', 'whost' ),
                    'heading'  => 'btn_text_color',
                    'group'       => esc_html__( 'Custom Settings', 'whost'),
                    'dependency'  => array(
                            'element' => 'type',
                            'value'   => 'btnone'
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
            'type'           => 'btnone',
            'title'          => '',
            'be_text'        => '',
            'af_text'        => '',
            'title_color'    => '',
            'uid'            => '',
        );

        $uid         = $this->get_uid( $atts );
        $atts        = shortcode_atts( $defaults, $atts );
        $atts['uid'] = $uid;
        $type        = whost_sanitize_param( $atts['type'] );
        $types       = array('btnone', 'btntwo');

        $view = $this->get_view( $type );

        ob_start();
        if ( in_array( $type, $types ) && file_exists( $view ) ) {
            include( $view );
        }
        return ob_get_clean();
    }

}

new Whost_Button;
