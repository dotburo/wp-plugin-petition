<?php

namespace Dotburo\AdminArea;

use Dotburo\PostTypes\SwiPetitionPostType;
use Dotburo\PostTypes\SwiPostType;

class SwiAdminPostFilter {

    /** @var SwiPostType */
    protected $postType;

    public function __construct( SwiPostType $postType ) {

        $this->postType = $postType;

        $postType->getLoader()->add_action( 'restrict_manage_posts', $this, 'restrictManagePosts' );

        $postType->getLoader()->add_action( 'parse_query', $this, 'parseQuery' );
    }

    public function restrictManagePosts( $post_type ) {
        if ( $post_type === $this->postType::TYPE ) {
            $options = SwiPetitionPostType::getPostIds( 'post_title' );

            $this->view( $options );
        }
    }

    /**
     * Update WP's query to filter by meta values.
     *
     * @param $query
     *
     * @return void
     */
    public function parseQuery( $query ){
        global $pagenow;

        if ( $pagenow ==='edit.php' && !empty($_GET['swi_petition'])) {
            $query->query_vars['meta_key'] = 'swi_signatory_petition';
            $query->query_vars['meta_value'] = $_GET['swi_petition'];
        }
    }

    /**
     * HTML for the filter.
     *
     * @param $options
     *
     * @return void
     */
    protected function view( $options ) {
        ?>
        <select name="swi_petition">
            <option value=""><?php _e( 'Select' ); ?></option>
            <?php
            $current_v = isset( $_GET['swi_petition'] ) ? $_GET['swi_petition'] : '';
            foreach ( $options as $label => $value ) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    $value,
                    $value == $current_v ? ' selected="selected"' : '',
                    $label
                );
            }
            ?>
        </select>
        <?php
    }

}
