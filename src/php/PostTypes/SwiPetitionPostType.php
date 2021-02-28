<?php

namespace Dotburo\PostTypes;

use Dotburo\SwiPetition;

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
        register_post_meta( static::TYPE, 'swi_petition_allowed_zips', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ] );

        register_post_meta( static::TYPE, 'swi_petition_zip_pattern', [
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
            [ 'create-block/starter-block' ]
        ];
    }

    /**
     * Register the post type.
     * @return void
     */
    protected function registerPostType () {
        $textDomain = SwiPetition::TEXT_DOMAIN;

        $labels = [
            'name'                  => _x( 'Petitions', 'Post Type General Name', $textDomain ),
            'singular_name'         => _x( 'Petition', 'Post Type Singular Name', $textDomain ),
            'menu_name'             => __( 'Petitions', $textDomain ),
            'name_admin_bar'        => __( 'Petition', $textDomain ),
            'archives'              => __( 'Petition Archives', $textDomain ),
            'attributes'            => __( 'Petition Attributes', $textDomain ),
            'parent_item_colon'     => __( 'Parent Petition:', $textDomain ),
            'all_items'             => __( 'All Petitions', $textDomain ),
            'add_new_item'          => __( 'Add New Petition', $textDomain ),
            'add_new'               => __( 'Add New', $textDomain ),
            'new_item'              => __( 'New Petition', $textDomain ),
            'edit_item'             => __( 'Edit Petition', $textDomain ),
            'update_item'           => __( 'Update Petition', $textDomain ),
            'view_item'             => __( 'View Petition', $textDomain ),
            'view_items'            => __( 'View Petitions', $textDomain ),
            'search_items'          => __( 'Search Petition', $textDomain ),
            'not_found'             => __( 'Not found' ),
            'not_found_in_trash'    => __( 'Not found in Trash' ),
            'featured_image'        => __( 'Featured Image' ),
            'set_featured_image'    => __( 'Set featured image' ),
            'remove_featured_image' => __( 'Remove featured image' ),
            'use_featured_image'    => __( 'Use as featured image' ),
            'insert_into_item'      => __( 'Insert into item' ),
            'uploaded_to_this_item' => __( 'Uploaded to this petition', $textDomain ),
            'items_list'            => __( 'Petitions list', $textDomain ),
            'items_list_navigation' => __( 'Petitions list navigation', $textDomain ),
            'filter_items_list'     => __( 'Filter Petition list', $textDomain ),
        ];
        $args = [
            'label'                 => __( 'Petition', $textDomain ),
            'description'           => __( 'Petition post type', $textDomain ),
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
