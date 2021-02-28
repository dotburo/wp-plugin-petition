<?php

namespace Dotburo\AdminArea;

use Dotburo\PostTypes\SwiPostType;

class SwiAdminPostFilter {

    /** @var SwiPostType */
    protected $postType;

    /** @var array */
    protected $values;

    public function __construct( SwiPostType $postType, array $values = [] ) {

        $this->postType = $postType;

        $this->values = $values;

        if (is_admin()) {
            add_filter( 'parse_query', [$this, 'parseQuery'] );
        }
    }

    public function restrictManagePosts( $post_type ) {
        if ( $post_type === $this->postType::TYPE ) {
            $this->view( $this->values );
        }
    }

    public function parseQuery( $query ){
        global $pagenow;

        if ( $pagenow ==='edit.php' && !empty($_GET['ADMIN_FILTER_FIELD_VALUE'])) {
            //var_dump($query);
            //exit();
            $query->query_vars['meta_key'] = 'n_de_ldition';
            $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
        }
    }

    protected function view( $values ) {
        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
            <option value=""><?php _e( 'Filter By ', 'wose45436' ); ?></option>
            <?php
            $current_v = isset( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) ? $_GET['ADMIN_FILTER_FIELD_VALUE'] : '';
            foreach ( $values as $label => $value ) {
                printf
                (
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
