<?php

if ( ! class_exists( 'TB_VC_Preview_Field' ) ) {

    class TB_VC_Preview_Field {

        public function __construct() {
            add_action( 'vc_before_init', array( $this, 'register_vc_preview_field' ) );
            add_filter( 'vc_mapper_attribute_preview', array( $this, 'set_default_group_for_preview_field' ) );
        }

        public function prepare_vc_preview_field( $settings, $value ) {
            $html =
                '<div class="tb_style_preview_field">' .
                    '<input name="%s" class="wpb_vc_param_value" type="hidden" value="%s" />' .
                    '<img src="%s" alt="%s" />' .
                '</div>';

            return sprintf( $html,
                    esc_attr( $settings['param_name'] ),
                    esc_url( $value ),
                    esc_url( $value ),
                    sprintf( esc_html__( '%s Preview Image.', 'massive-engine' ), $settings['heading'] )
                );
        }

        public function register_vc_preview_field() {
            vc_add_shortcode_param( 'preview', array( $this, 'prepare_vc_preview_field' ) );
        }

        public function set_default_group_for_preview_field( $attribute ) {
            $attribute['group'] = esc_html__( 'Preview', 'massive-engine' );
            return $attribute;
        }

    }

    new TB_VC_Preview_Field;
}
