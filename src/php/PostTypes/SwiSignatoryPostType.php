<?php

namespace Dotburo\PostTypes;

use Dotburo\AdminArea\SwiAdminPostFilter;
use Dotburo\AdminArea\SwiCsvExporter;
use WP_Error;
use WP_Query;

class SwiSignatoryPostType extends SwiPostType {

    const TYPE = 'signatory';

    /** @inheritDoc */
    protected function registerAdminHooks() {
        $type = static::TYPE;

        $this->loader->add_filter( "bulk_actions-edit-{$type}", '__return_empty_array', null, PHP_INT_MAX );

        $this->loader->add_filter( "manage_{$type}_posts_columns", $this, 'setAdminColumns' );
        $this->loader->add_action( "manage_{$type}_posts_custom_column", $this, 'echoAdminColumnValues', 10, 2 );
        $this->loader->add_filter( "manage_edit-{$type}_sortable_columns", $this, 'setSortableAdminColumns' );
        $this->loader->add_action( "pre_get_posts", $this, 'sortAdminColumns', 10, 2 );

        new SwiAdminPostFilter( $this );

        new SwiCsvExporter( $this );
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

        $columns['swi_signatory_fname_column']          = __( 'First Name' );
        $columns['swi_signatory_lname_column']          = __( 'Last Name' );
        $columns['swi_signatory_petition_column']       = __( 'Petition', 'swi-petition' );
        $columns['swi_signatory_email_column']          = __( 'Email' );
        $columns['swi_signatory_newsletter_column']     = __( 'Newsletter' );
        $columns['swi_signatory_date_column']           = __( 'Date' );

        return $columns;
    }

    public function setSortableAdminColumns( $columns ) {
        $columns['swi_signatory_lname_column']    = 'swi_signatory_lname_column';
        $columns['swi_signatory_fname_column']    = 'swi_signatory_fname_column';
        $columns['swi_signatory_petition_column'] = 'swi_signatory_petition_column';
        $columns['swi_signatory_date_column']     = 'swi_signatory_date_column';

        return $columns;
    }

    public function echoAdminColumnValues( $columnName, $postId ) {
        switch ( $columnName ) {
            case 'swi_signatory_date_column':
                echo $this->getPostDate( $postId );
                break;
            case 'swi_signatory_petition_column':
                $petitionId = (int)get_metadata( 'post', $postId, 'swi_signatory_petition', true );
                echo $petitionId ? get_post_field( 'post_title', (int)$petitionId ) : '';
                break;
            case 'swi_signatory_newsletter_column':
                $newsletter = (int)get_metadata( 'post', $postId, 'swi_signatory_newsletter', true );
                echo $newsletter ? '✓' : '×';
                break;
            default:
                $key = str_replace( '_column', '', $columnName );
                echo get_metadata( 'post', $postId, $key, true );
        }
    }

    protected function getPostDate( int $id ) {
        $modTime = get_post_time( 'U', false, $id );

        return date_i18n( get_option( 'date_format' ), $modTime )
               . ' at ' . date_i18n( get_option( 'time_format' ), $modTime );
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

    public static function isZipAllowed(int $postId, $zip): bool {
        $zips = get_post_meta($postId, 'swi_petition_allowed_zips', true);
        $zips = explode(',', $zips);
        return in_array($zip, $zips);
    }

    /**
     * Insert a new signatory into the database.
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $zip
     * @param int $petitionId
     *
     * @return int|WP_Error
     */
    public static function create(int $petitionId, string $firstName, string $lastName, string $email, string $zip = null, bool $newsletter) {
        return wp_insert_post([
            'post_status' => 'private',
            'post_type' => static::TYPE,
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'meta_input' => [
                'swi_signatory_fname' => $firstName,
                'swi_signatory_lname' => $lastName,
                'swi_signatory_email' => $email,
                'swi_signatory_zip' => $zip,
                'swi_signatory_petition' => $petitionId,
                'swi_signatory_newsletter' => (int)$newsletter,
            ]
        ]);
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return bool
     */
    public static function exists( string $key, $value ): bool {
        $query = new WP_Query( [
            'post_type'      => static::TYPE,
            'fields'         => 'ids',
            'posts_per_page' => - 1,
            'post_status'    => 'private',
            'meta_key'       => $key,
            'meta_value'     => $value,
            'meta_compare'   => '=',
        ] );

        return (bool)$query->found_posts;
    }

    /**
     * Count all posts of a given type.
     *
     * @param int $petitionId
     * @param string $status
     *
     * @return int
     */
    public static function countPosts( int $petitionId, string $status = 'publish' ): int {
        global $wpdb;

        $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} as p"
                 . " INNER JOIN {$wpdb->postmeta} as pm ON p.ID = pm.post_id and pm.meta_key = 'swi_signatory_petition'"
                 . " WHERE post_type = %s and meta_value = %d"
                 . " GROUP BY post_status";

        $results = (array)$wpdb->get_results( $wpdb->prepare( $query, static::TYPE, $petitionId ) );

        return !empty($results) ? $results[0]->num_posts : 0;
    }

    /** @inheritDoc */
    public function getAll( int $petitionId = 0 ): array {
        global $wpdb;

        $fn = __( 'First Name' );
        $ln = __( 'Last Name' );
        $em = __( 'Email' );
        $zi = __( 'Zip Code' );
        $da = __( 'Date' );
        $nl = __( 'Newsletter' );

        $query = "SELECT fn.meta_value as '{$fn}', ln.meta_value as '{$ln}', em.meta_value as '{$em}', zi.meta_value as '{$zi}',"
                 . "nl.meta_value as '{$nl}', p.post_date as '{$da}'"
                 . " FROM {$wpdb->posts} as p"
                 . " INNER JOIN {$wpdb->postmeta} as fn ON p.ID = fn.post_id and fn.meta_key = 'swi_signatory_fname'"
                 . " INNER JOIN {$wpdb->postmeta} as ln ON p.ID = ln.post_id and ln.meta_key = 'swi_signatory_lname'"
                 . " INNER JOIN {$wpdb->postmeta} as em ON p.ID = em.post_id and em.meta_key = 'swi_signatory_email'"
                 . " INNER JOIN {$wpdb->postmeta} as zi ON p.ID = zi.post_id and zi.meta_key = 'swi_signatory_zip'"
                 . " INNER JOIN {$wpdb->postmeta} as pe ON p.ID = pe.post_id and pe.meta_key = 'swi_signatory_petition'"
                 . " LEFT JOIN {$wpdb->postmeta} as nl ON p.ID = nl.post_id and nl.meta_key = 'swi_signatory_newsletter'"
                 . " WHERE p.post_type = %s AND p.post_status = 'private'"
                 . ( $petitionId ? " AND pe.meta_value = $petitionId" : '' );

        return (array)$wpdb->get_results( $wpdb->prepare( $query, static::TYPE ), ARRAY_A );
    }

    /** @inheritDoc */
    public function init() {

        $labels = [
            'name'                  => _x( 'Signatories', 'Post Type General Name', 'swi-petition' ),
            'singular_name'         => _x( 'Signatory', 'Post Type Singular Name', 'swi-petition' ),
            'menu_name'             => __( 'Signatories', 'swi-petition' ),
            'name_admin_bar'        => __( 'Signatory', 'swi-petition' ),
            'all_items'             => __( 'All Signatories', 'swi-petition' ),
            'view_items'            => __( 'View Signatories', 'swi-petition' ),
            'items_list'            => __( 'Signatories list', 'swi-petition' ),
            'items_list_navigation' => __( 'Signatories list navigation', 'swi-petition' ),
            'filter_items_list'     => __( 'Filter Signatory list', 'swi-petition' ),
        ];

        $args = [
            'label'               => __( 'Signatory', 'swi-petition' ),
            'description'         => __( 'Holds the signing data', 'swi-petition' ),
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
            'capabilities'        => [
                'create_posts' => false,
            ],
            # Do not allowed to edit/delete existing signatories
            'map_meta_cap'        => false,

        ];

        register_post_type( static::TYPE, $args );

    }
}
