<?php

if ( ! class_exists( 'TB_VC_GDropdown_Field' ) ) {

    class TB_VC_GDropdown_Field {

        public function __construct() {
            add_action( 'vc_before_init', array( $this, 'register_vc_gdropdown_field' ) );
        }

        public function prepare_vc_gdropdown_field( $settings, $value ) {


            $html = "<div class='tb_style_gdropdown_field'><select name='%s' class='gdropdown wpb_vc_param_value'>";
            foreach($settings['options'] as $label=>$optiongroup){
                $html .= "<optgroup label='{$label}'>";
                foreach($optiongroup as $label=>$item){
                    if($value==$item){
                        $html .= "<option selected='true' value='{$item}'>{$label}</option>";
                    } else {
                        $html .= "<option value='{$item}'>{$label}</option>";
                    }
                }
                $html .= "</optgroup>";
            }

            $html .= "</select></div>";

            return sprintf( $html,
                esc_attr( $settings['param_name'] )
            );
        }

        public function register_vc_gdropdown_field() {
            vc_add_shortcode_param( 'gdropdown', array( $this, 'prepare_vc_gdropdown_field' ) );
        }

    }

    new TB_VC_GDropdown_Field;
}
