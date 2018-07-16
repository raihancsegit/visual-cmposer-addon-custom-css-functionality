<?php
/**
 * Whost shortcode base class
 *
 * 
 * @package  Whost Engine
 * @author  ThemeBucket <themebucket@gmail.com>
 */

abstract class Whost_Shortcode {

    /**
     * Shortcode class directory path
     * @var string
     */
    protected $dir;

    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'init', array($this, 'setup_shortcode') );
        add_action( 'vc_before_init', array($this, 'add_shortcode_map') );
    }

    public function setup_shortcode() {
        $this->dir = $this->set_dir();

        add_shortcode( $this->get_tag(), array($this, 'render') );
    }

    /**
     * Generate shortcode tag from inherited class name
     * @return string Shortcode tag
     */
    protected function get_tag() {
        return strtolower( get_called_class() );
    }

    /**
     * Map shortcode to Visual Composer
     * @return void
     */
    public function add_shortcode_map() {
        vc_map( $this->map() );
    }

    /**
     * Get shortcode view file
     * @param string $view Shortcode view name
     * @return string
     */
    protected function get_view( $view = '' ) {
        $dir = trailingslashit( $this->dir );
        return trailingslashit( $dir . 'views' ) . trim( $view ) . '.php';
    }

    /**
     * Generate unique id
     * @param  array $params
     * @return string
     */
    protected function get_uid( $params ) {
        $str = get_called_class();
        if ( is_array( $params ) ) {
            $params['uid'] = '';
            $str .= http_build_query( $params );
        }
        return 'Whost' . md5( $str );
    }

    /**
     * Create icon url
     * @param $name          Shortcode icon name
     * @param string $ext    Icon extension
     * @return string        Shortcode icon url
     */
    protected function get_icon( $name, $ext = 'png' ) {
        $dir = trailingslashit( WHOST_ENGINE_URL . 'assets/icons' );
        return esc_url( $dir . $name . ".{$ext}" );
    }

    /**
     * Get shortcode map for Visual Composer
     * @return array Shortcode map
     */
    abstract protected function map();

    /**
     * Set shortcode directory path
     * @return string
     */
    abstract protected function set_dir();

    /**
     * Render shortcode html output
     * @param  array $atts     Shortcode attributes
     * @param  string $content Shortcode content
     * @return string          Shortcode output
     */
    abstract public function render( $atts, $content = NULL );

}
