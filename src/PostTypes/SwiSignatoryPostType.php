<?php

namespace Dotburo\PostTypes;

use Dotburo\SwiPetition;

class SwiSignatoryPostType extends SwiPostType {

	const TYPE = 'signatory';

	public function setAdminColumns( $columns ) {
		$date = $columns['date'];

		unset( $columns['title'], $columns['date'] );

		$columns['swi_signatory_lname_column'] = __( 'Last Name', SwiPetition::TEXT_DOMAIN );
		$columns['swi_signatory_fname_column'] = __( 'First Name', SwiPetition::TEXT_DOMAIN );
		$columns['swi_signatory_petition_column'] = __( 'Petition', SwiPetition::TEXT_DOMAIN );
		$columns['swi_signatory_email_column'] = __( 'Email', SwiPetition::TEXT_DOMAIN );

		$columns['date'] = $date;

		return $columns;
	}

	function setSortableAdminColumns( $columns ) {
		$columns['swi_signatory_lname_column'] = 'swi_signatory_lname_column';
		$columns['swi_signatory_fname_column'] = 'swi_signatory_fname_column';
		$columns['swi_signatory_petition_column'] = 'swi_signatory_petition_column';

		return $columns;
	}

	function sortAdminColumns( $query ) {
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

	public function echoAdminColumnValues( $columnName, $postId ) {
		$meta = $this->getMeta( $postId );

		echo $meta[ str_replace( '_column', '', $columnName ) ] ?? '';
	}

	function removeAdminColumnActions( $actions, $post ) {

		if ( $post->post_type === self::TYPE ) {
			unset(
				$actions['edit'],
				$actions['inline hide-if-no-js'],
				//$actions['trash'],
				$actions['view'],
			);
		}

		return $actions;
	}

	/**
	 * @param $userCaps
	 * @param $reqCap
	 * @param $args
	 *
	 * @return mixed
	 */
	function preventEdit( $userCaps, $reqCap, $args ) {

		# Bail out if we're not asking to edit a post or user already cannot edit the post.
		if ( 'edit_post' !== $args[0] || empty( $userCaps['edit_posts'] ) ) {
			return $userCaps;
		}

		if ( get_post_type( $args[2] ) === self::TYPE ) {
			$userCaps[ $reqCap[0] ] = false;
		}

		return $userCaps;
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
			'search_items'          => __( 'Search Signatory', $textDomain ),
			'not_found'             => __( 'Not found', $textDomain ),
			'not_found_in_trash'    => __( 'Not found in Trash', $textDomain ),
			'featured_image'        => __( 'Featured Image', $textDomain ),
			'set_featured_image'    => __( 'Set featured image', $textDomain ),
			'remove_featured_image' => __( 'Remove featured image', $textDomain ),
			'use_featured_image'    => __( 'Use as featured image', $textDomain ),
			'insert_into_item'      => __( 'Insert into signatory', $textDomain ),
			'uploaded_to_this_item' => __( 'Uploaded to this signatory', $textDomain ),
			'items_list'            => __( 'Signatories list', $textDomain ),
			'items_list_navigation' => __( 'Signatories list navigation', $textDomain ),
			'filter_items_list'     => __( 'Filter Signatory list', $textDomain ),
		];

		$args = [
			'label'               => __( 'Signatory', $textDomain ),
			'description'         => __( 'Signatory post type', $textDomain ),
			'labels'              => $labels,
			'supports'            => array( 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 27,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => false,
		];

		register_post_type( self::TYPE, $args );

	}
}