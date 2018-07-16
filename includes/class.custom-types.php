<?php

class Massive_Custom_Types {

    function __construct() {
        add_action( 'init', array( $this, 'register_cpts' ) );
    }

    public function register_cpts() {
        $this->register_banner_cpt();
        $this->register_portfolio_cpt();
        $this->register_portfolio_tax();
    }

    private function register_banner_cpt() {
        $labels = array(
            'name'                  => esc_html_x( 'Banners', 'Post Type General Name', 'massive-engine' ),
            'singular_name'         => esc_html_x( 'Banner', 'Post Type Singular Name', 'massive-engine' ),
            'menu_name'             => esc_html__( 'Banners', 'massive-engine' ),
            'name_admin_bar'        => esc_html__( 'Banners', 'massive-engine' ),
            'parent_item_colon'     => esc_html__( 'Parent Banner:', 'massive-engine' ),
            'all_items'             => esc_html__( 'All Banners', 'massive-engine' ),
            'add_new_item'          => esc_html__( 'Add New Banner', 'massive-engine' ),
            'add_new'               => esc_html__( 'Add Banner', 'massive-engine' ),
            'new_item'              => esc_html__( 'New Banner', 'massive-engine' ),
            'edit_item'             => esc_html__( 'Edit Banner', 'massive-engine' ),
            'update_item'           => esc_html__( 'Update Banner', 'massive-engine' ),
            'view_item'             => esc_html__( 'View Banner', 'massive-engine' ),
            'search_items'          => esc_html__( 'Search Banner', 'massive-engine' ),
            'not_found'             => esc_html__( 'Not found', 'massive-engine' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'massive-engine' ),
            'items_list'            => esc_html__( 'Banners list', 'massive-engine' ),
            'items_list_navigation' => esc_html__( 'Banners list navigation', 'massive-engine' ),
            'filter_items_list'     => esc_html__( 'Filter banners list', 'massive-engine' ),
        );

        $args = array(
            'label'                 => esc_html__( 'Banner', 'massive-engine' ),
            'description'           => esc_html__( 'Banner Post Type', 'massive-engine' ),
            'labels'                => $labels,
            'supports'              => array( 'title', ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-desktop',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'page',
        );

        //register_post_type( 'banner', $args );
    }

    private function register_portfolio_cpt() {
        $labels = array(
            'name'                  => esc_html_x( 'Portfolios', 'Post Type General Name', 'massive-engine' ),
            'singular_name'         => esc_html_x( 'Portfolio', 'Post Type Singular Name', 'massive-engine' ),
            'menu_name'             => esc_html__( 'Portfolios', 'massive-engine' ),
            'name_admin_bar'        => esc_html__( 'Portfolios', 'massive-engine' ),
            'parent_item_colon'     => esc_html__( 'Parent Portfolio:', 'massive-engine' ),
            'all_items'             => esc_html__( 'All Portfolios', 'massive-engine' ),
            'add_new_item'          => esc_html__( 'Add New Portfolio', 'massive-engine' ),
            'add_new'               => esc_html__( 'Add Portfolio', 'massive-engine' ),
            'new_item'              => esc_html__( 'New Portfolio', 'massive-engine' ),
            'edit_item'             => esc_html__( 'Edit Portfolio', 'massive-engine' ),
            'update_item'           => esc_html__( 'Update Portfolio', 'massive-engine' ),
            'view_item'             => esc_html__( 'View Portfolio', 'massive-engine' ),
            'search_items'          => esc_html__( 'Search Portfolio', 'massive-engine' ),
            'not_found'             => esc_html__( 'Not found', 'massive-engine' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'massive-engine' ),
            'items_list'            => esc_html__( 'Portfolios list', 'massive-engine' ),
            'items_list_navigation' => esc_html__( 'Portfolios list navigation', 'massive-engine' ),
            'filter_items_list'     => esc_html__( 'Filter Portfolios list', 'massive-engine' ),
        );

        $args = array(
            'label'               => esc_html__( 'Portfolio', 'massive-engine' ),
            'description'         => esc_html__( 'Portfolio Post Type', 'massive-engine' ),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'author', 'thumbnail'),
            'taxonomies'          => array( 'portfolio-tag', 'portfolio-category' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-images-alt2',
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'exclude_from_search' => true,
            'capability_type'     => 'post',
        );

        //register_post_type( 'portfolio', $args );
    }

    private function register_portfolio_tax() {
        $labels = array(
            'name'                       => esc_html_x( 'Portfolio Tags', 'Taxonomy General Name', 'massive-engine' ),
            'singular_name'              => esc_html_x( 'Portfolio Tag', 'Taxonomy Singular Name', 'massive-engine' ),
            'menu_name'                  => esc_html__( 'Portfolio Tags', 'massive-engine' ),
            'all_items'                  => esc_html__( 'All Tags', 'massive-engine' ),
            'parent_item'                => esc_html__( 'Parent Tag', 'massive-engine' ),
            'parent_item_colon'          => esc_html__( 'Parent Tag:', 'massive-engine' ),
            'new_item_name'              => esc_html__( 'New Tag Name', 'massive-engine' ),
            'add_new_item'               => esc_html__( 'Add New Tag', 'massive-engine' ),
            'edit_item'                  => esc_html__( 'Edit Tag', 'massive-engine' ),
            'update_item'                => esc_html__( 'Update Tag', 'massive-engine' ),
            'view_item'                  => esc_html__( 'View Tag', 'massive-engine' ),
            'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'massive-engine' ),
            'add_or_remove_items'        => esc_html__( 'Add or remove tag', 'massive-engine' ),
            'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'massive-engine' ),
            'popular_items'              => esc_html__( 'Popular Tags', 'massive-engine' ),
            'search_items'               => esc_html__( 'Search Tags', 'massive-engine' ),
            'not_found'                  => esc_html__( 'Not Found', 'massive-engine' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => true,
        );
        //register_taxonomy( 'portfolio-tag', array( 'portfolio' ), $args );
    }

}
new Massive_Custom_Types;


function massive_register_portfolio_category() {
    $labels = array(
        'name'                       => esc_html_x( 'Portfolio Categories', 'Taxonomy General Name', 'massive-engine' ),
        'singular_name'              => esc_html_x( 'Portfolio Category ', 'Taxonomy Singular Name', 'massive-engine' ),
        'menu_name'                  => esc_html__( 'Portfolio Category', 'massive-engine' ),
        'all_items'                  => esc_html__( 'All Categories', 'massive-engine' ),
        'parent_item'                => esc_html__( 'Parent Category', 'massive-engine' ),
        'parent_item_colon'          => esc_html__( 'Parent Category:', 'massive-engine' ),
        'new_item_name'              => esc_html__( 'New Category Name', 'massive-engine' ),
        'add_new_item'               => esc_html__( 'Add New Category', 'massive-engine' ),
        'edit_item'                  => esc_html__( 'Edit Category', 'massive-engine' ),
        'update_item'                => esc_html__( 'Update Category', 'massive-engine' ),
        'view_item'                  => esc_html__( 'View Category', 'massive-engine' ),
        'separate_items_with_commas' => esc_html__( 'Separate category with commas', 'massive-engine' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove category', 'massive-engine' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'massive-engine' ),
        'popular_items'              => esc_html__( 'Popular Category', 'massive-engine' ),
        'search_items'               => esc_html__( 'Search Category', 'massive-engine' ),
        'not_found'                  => esc_html__( 'Not Found', 'massive-engine' ),
        'no_terms'                   => esc_html__( 'No Category', 'massive-engine' ),
        'items_list'                 => esc_html__( 'Category list', 'massive-engine' ),
        'items_list_navigation'      => esc_html__( 'Category list navigation', 'massive-engine' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
    );
    register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );
}
//add_action( 'init', 'massive_register_portfolio_category', 0 );