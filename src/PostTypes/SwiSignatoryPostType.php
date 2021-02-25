<?php

namespace Dotburo\PostTypes;

use Dotburo\SwiAdminPostFilter;
use Dotburo\SwiPetition;

class SwiSignatoryPostType extends SwiPostType {

	const TYPE = 'signatory';

	/** @inheritDoc */
    protected function registerAdminHooks() {
        $type = static::TYPE;

        $this->loader->add_action( 'init', $this, 'register' );

        $this->loader->add_filter( "bulk_actions-edit-{$type}", '__return_empty_array', null, PHP_INT_MAX );

        $this->loader->add_filter( "manage_{$type}_posts_columns", $this, 'setAdminColumns' );
        $this->loader->add_action( "manage_{$type}_posts_custom_column", $this, 'echoAdminColumnValues', 10, 2 );
        $this->loader->add_filter( "manage_edit-{$type}_sortable_columns", $this,'setSortableAdminColumns' );
        $this->loader->add_action( "pre_get_posts", $this, 'sortAdminColumns', 10, 2 );

        $filter = new SwiAdminPostFilter($this, SwiPetitionPostType::getPostIds('post_title'));

        $this->loader->add_action( 'restrict_manage_posts', $filter, 'restrictManagePosts' );
    }

    /** @inheritDoc */
    protected function registerPublicHooks() {
        // TODO: Implement registerPublicHooks() method.
    }

    public function getAdminHeadCss(): string {
        return '.post-type-signatory .row-actions { display: inline-block; margin-left: .5em }';
    }

    public function setAdminColumns( $columns ) {
		unset( $columns['title'], $columns['date'] );

        $columns['swi_signatory_fname_column'] = __( 'First Name' );
		$columns['swi_signatory_lname_column'] = __( 'Last Name' );
		$columns['swi_signatory_petition_column'] = __( 'Petition', SwiPetition::TEXT_DOMAIN );
		$columns['swi_signatory_email_column'] = __( 'Email' );
        $columns['swi_signatory_date_column'] = __( 'Date' );

		return $columns;
	}

    public function setSortableAdminColumns( $columns ) {
		$columns['swi_signatory_lname_column'] = 'swi_signatory_lname_column';
		$columns['swi_signatory_fname_column'] = 'swi_signatory_fname_column';
		$columns['swi_signatory_petition_column'] = 'swi_signatory_petition_column';
        $columns['swi_signatory_date_column'] = 'swi_signatory_date_column';

		return $columns;
	}

	public function echoAdminColumnValues( $columnName, $postId ) {
        if ($columnName !== 'swi_signatory_date_column') {
            $this->meta = $this->meta ?: $this->getMeta( $postId );

            echo $this->meta[ str_replace( '_column', '', $columnName ) ] ?? '';
        } else {
            $modTime = get_the_modified_date();
            echo date_i18n(get_option('date_format'), $modTime )
                . ' at ' . date_i18n(get_option('time_format'), $modTime );
        }
	}

    public function sortAdminColumns( $query ) {
        $orderBy = $query->get( 'orderby' );

        if ( 'swi_signatory_lname_column' === $orderBy ) {
            $query->set( 'meta_query', [
                'relation' => 'OR',
                [
                    'key'     => 'swi_signatory_lname',
                    'compare' => 'NOT EXISTS',
                ],
                [ 'key' => 'swi_signatory_lname', ],
            ] );
            $query->set( 'orderby', 'meta_value' );
        }
    }

	/** @inheritDoc */
	public function register() {
		$textDomain = SwiPetition::TEXT_DOMAIN;

		$labels = [
			'name'                  => _x( 'Signatories', 'Post Type General Name', $textDomain ),
			'singular_name'         => _x( 'Signatory', 'Post Type Singular Name', $textDomain ),
			'menu_name'             => __( 'Signatories', $textDomain ),
			'name_admin_bar'        => __( 'Signatory', $textDomain ),
			'archives'              => __( 'Signatory Archives', $textDomain ),
			'attributes'            => __( 'Signatory Attributes', $textDomain ),
			'parent_item_colon'     => __( 'Parent Signatory:', $textDomain ),
			'all_items'             => __( 'All Signatories', $textDomain ),
			'add_new_item'          => __( 'Add New Signatory', $textDomain ),
			'add_new'               => __( 'Add New', $textDomain ),
			'new_item'              => __( 'New Signatory', $textDomain ),
			'edit_item'             => __( 'Edit Signatory', $textDomain ),
			'update_item'           => __( 'Update Signatory', $textDomain ),
			'view_item'             => __( 'View Signatory', $textDomain ),
			'view_items'            => __( 'View Signatories', $textDomain ),
			'search_items'          => __( 'Search Signatories', $textDomain ),
			'items_list'            => __( 'Signatories list', $textDomain ),
			'items_list_navigation' => __( 'Signatories list navigation', $textDomain ),
			'filter_items_list'     => __( 'Filter Signatory list', $textDomain ),
		];

		$args = [
			'label'               => __( 'Signatory', $textDomain ),
			'description'         => __( 'Signatory post type', $textDomain ),
			'labels'              => $labels,
			'supports'            => [ 'custom-fields' ],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 27,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
            'show_in_rest'        => false,
			'capability_type'     => 'post',
            # Remove signatories creation and "Add New" buttons from admin
            'capabilities' => [
                'create_posts' => false,
            ],
            # Do not allowed to edit/delete existing signatories
            'map_meta_cap' => false,

		];

		register_post_type( static::TYPE, $args );

	}
}
