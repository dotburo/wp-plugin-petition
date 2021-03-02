<?php

namespace Dotburo\PostTypes;

class SwiPetitionPostType extends SwiPostType {

	/** @var string */
	const TYPE = 'petition';

    protected function registerAdminHooks() {
        //
    }

    protected function registerPublicHooks() {
        //
    }

    /** @inheritDoc */
    public function init() {
        $this->registerPostType();
        $this->registerPostMeta();
        $this->registerBlockTemplate();
    }

    /**
     * Register the meta fields used by this post type.
     * @return void
     */
    protected function registerPostMeta() {
        register_post_meta( '', 'swi_petition_allowed_zips', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ] );

        register_post_meta( '', 'swi_petition_zip_pattern', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ] );

        register_post_meta( '', 'swi_petition_goal', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'number',
        ] );

        register_post_meta( '', 'swi_petition_redirect', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ] );
    }

    /**
     * Specify the default initial state for the post type.
     * @return void
     */
    protected function registerBlockTemplate() {
        $post_type_object = get_post_type_object( static::TYPE );
        $post_type_object->template = [
            [
                'swi-petition/form-block',
                'swi-petition/counter-block',
            ]
        ];
    }

    /**
     * Register the post type.
     * @return void
     */
    protected function registerPostType () {

        $labels = [
            'name'                  => _x( 'Petitions', 'Post Type General Name', 'swi-petition' ),
            'singular_name'         => _x( 'Petition', 'Post Type Singular Name', 'swi-petition' ),
            'menu_name'             => __( 'Petitions', 'swi-petition' ),
            'name_admin_bar'        => __( 'Petition', 'swi-petition' ),
            'archives'              => __( 'Petition Archives', 'swi-petition' ),
            'attributes'            => __( 'Petition Attributes', 'swi-petition' ),
            'all_items'             => __( 'All Petitions', 'swi-petition' ),
            'add_new_item'          => __( 'Add New Petition', 'swi-petition' ),
            'add_new'               => __( 'Add New' ),
            'new_item'              => __( 'New Petition', 'swi-petition' ),
            'edit_item'             => __( 'Edit Petition', 'swi-petition' ),
            'update_item'           => __( 'Update Petition', 'swi-petition' ),
            'view_item'             => __( 'View Petition', 'swi-petition' ),
            'view_items'            => __( 'View Petitions', 'swi-petition' ),
            'search_items'          => __( 'Search Petition', 'swi-petition' ),
            'not_found'             => __( 'Not found' ),
            'not_found_in_trash'    => __( 'Not found in Trash' ),
            'featured_image'        => __( 'Featured Image' ),
            'set_featured_image'    => __( 'Set featured image' ),
            'remove_featured_image' => __( 'Remove featured image' ),
            'use_featured_image'    => __( 'Use as featured image' ),
            'insert_into_item'      => __( 'Insert into item' ),
            'uploaded_to_this_item' => __( 'Uploaded to this petition', 'swi-petition' ),
            'items_list'            => __( 'Petitions list', 'swi-petition' ),
            'items_list_navigation' => __( 'Petitions list navigation', 'swi-petition' ),
            'filter_items_list'     => __( 'Filter Petition list', 'swi-petition' ),
        ];
        $args = [
            'label'                 => __( 'Petition', 'swi-petition' ),
            'description'           => __( 'Petition post type', 'swi-petition' ),
            'labels'                => $labels,
            'supports'              => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 26,
            'menu_icon'             => 'dashicons-edit-large',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        ];

        register_post_type( static::TYPE, $args );
    }
}
