<?php

namespace Dotburo\AdminArea;

use Dotburo\PostTypes\SwiPostType;
use Exception;

/**
 * Export the signatories to a downloadable CSV.
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/AdminArea
 * @author     dotburo <code@dotburo.org>
 */
class SwiCsvExporter {

    /** @var SwiPostType */
    protected $postType;

    /**
     * SwiCsvExporter constructor.
     *
     * @param SwiPostType $postType
     */
    public function __construct( SwiPostType $postType ) {
        $this->postType = $postType;

        $postType->getLoader()->add_action( 'restrict_manage_posts', $this, 'restrictManagePosts' );

        $postType->getLoader()->add_action( 'parse_query', $this, 'export' );
    }

    /**
     * @throws Exception
     */
    public function export( $query ) {
        global $pagenow;

        if ( !($pagenow === 'edit.php' && isset( $_GET['swi_signatories_export'] ) ) ) {
            return $query;
        }

        $petitionId = !empty( $_GET['swi_petition'] ) ? (int)$_GET['swi_petition'] : 0;

        $data = $this->postType->getAll( $petitionId );

        if ( empty( $data ) ) {
            throw new Exception( __( 'There are no signatories for this petition yet.' ) );
        }

        $filename = strtolower( __( 'Signatories', 'swi-petition' ) ) . '-' . strtotime( 'now' );

        header( 'Content-Type: text/csv; charset=utf-8' );
        header( "Content-Disposition: attachment; filename=$filename.csv" );
        header( 'Cache-Control: no-cache, no-store, must-revalidate' );
        header( 'Pragma: no-cache' );
        header( 'Expires: 0' );

        $output = fopen( 'php://output', 'w' );

        $headings = array_keys( $data[0] );

        fputcsv( $output, $headings );

        foreach ( $data as $row ) {
            fputcsv( $output, $row );
        }

        fclose( $output );

        exit();
    }

    /**
     * @param $post_type
     */
    public function restrictManagePosts( $post_type ) {
        if ( $post_type === $this->postType::TYPE ) {
            $this->view();
        }
    }

    /**
     * HTML for the export button.
     *
     * @return void
     */
    protected function view() {
        echo '<button type="submit" class="button" name="swi_signatories_export" style="margin-right:6px;">',
        __( 'Export' ),
        '</button>';
    }
}
