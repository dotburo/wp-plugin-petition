<?php

namespace Dotburo\PublicArea;

use Dotburo\PostTypes\SwiPostType;
use Dotburo\PostTypes\SwiSignatoryPostType;
use Dotburo\SwiArea;
use Dotburo\SwiHookLoader;
use Dotburo\SwiPetition;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://dotburo.org
 * @since      1.0.0
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/PublicArea
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/PublicArea
 * @author     dotburo <code@dotburo.org>
 */
class SwiPublicArea extends SwiArea {

    public function __construct( SwiHookLoader $loader, array $postTypes ) {

        parent::__construct( $loader, $postTypes );

        $this->loader->add_action( 'wp_ajax_swi_petition_poll', $this, 'ajaxCountPoll', 0, 0 );
        $this->loader->add_action( 'wp_ajax_nopriv_swi_petition_poll', $this, 'ajaxCountPoll', 0, 0 );

        $this->loader->add_action( 'wp_ajax_swi_petition_submit', $this, 'ajaxSubmitSignatory', 0, 0 );
        $this->loader->add_action( 'wp_ajax_nopriv_swi_petition_submit', $this, 'ajaxSubmitSignatory', 0, 0 );
    }

    /**
     * Ajax hook: return the total count of signatories.
     *
     * @return void
     */
    public function ajaxCountPoll() {

        $petitionId = (int)$_GET['swi_petition'];

        $petitionId = SwiPostType::resolveTranslatedPostId( $petitionId );

        wp_send_json( SwiSignatoryPostType::countPosts($petitionId,'private') );

    }

    /**
     * Ajax hook: add a signatory to the petition.
     *
     * @return void
     */
    public function ajaxSubmitSignatory() {

        $nonceCheck = check_ajax_referer( 'swi_petition_submit', '_ajax_nonce', false);

        if (!$nonceCheck) {
            wp_send_json_error(['error' => __( 'You\'re not allowed to do this.', 'swi-petition' )], 500);
        }

        $firstName = sanitize_text_field(trim($_POST['swi_petition_fname']));
        $lastName = sanitize_text_field(trim($_POST['swi_petition_lname']));
        $petitionId = (int)$_POST['swi_petition'];
        $email = sanitize_email(trim($_POST['swi_petition_email']));
        $newsletter = $_POST['swi_petition_newsletter'] === 'true';

        if ( empty($petitionId) || empty($email) || empty($firstName) || empty($lastName) ) {
            wp_send_json_error(['error' => __( 'We\'re missing some data...', 'swi-petition' )], 500);
        }

        if (SwiSignatoryPostType::exists('swi_signatory_email', $email)) {
            wp_send_json_error(['error' => __( 'You already signed the petition!', 'swi-petition' )], 500);
        }

        if (isset($_POST['swi_petition_age']) && $_POST['swi_petition_age'] !== 'true') {
            wp_send_json_error(['error' => __( 'Please confirm your age.', 'swi-petition' )], 500);
        }

        if (isset($_POST['swi_petition_zip'])) {
            $zip = sanitize_text_field($_POST['swi_petition_zip']);

            if (!SwiSignatoryPostType::isZipAllowed($petitionId, $zip)) {
                wp_send_json_error(['error' => __( 'This zip code is not allowed.', 'swi-petition' )], 500);
            }
        }

        $result = SwiSignatoryPostType::create($petitionId, $firstName, $lastName, $email, $zip ?? null, $newsletter);

        is_int($result)
            ? wp_send_json(1)
            : wp_send_json_error(['error' => __( 'We could not save your signature, please try again later.', 'swi-petition' )], 500);
    }

    /** @inheritDoc */
    public function enqueue_styles() {
        $file = $this->loader->getPluginPath( 'src/css/public.css' );

        wp_enqueue_style(
            SwiPetition::PLUGIN_NAME,
            plugins_url( 'public.css', $file ),
            [],
            filemtime( $file )
        );

    }

    /** @inheritDoc */
    public function enqueue_scripts() {
        global $post;

        $handle = SwiPetition::createEnqueueHandle();

        $file = $this->loader->getPluginPath( 'build/swi-petition-public.min.js' );

        wp_enqueue_script(
            $handle,
            plugins_url( '/swi-petition-public.min.js', $file ),
            [],
            filemtime( $file ),
            true
        );

        wp_set_script_translations( $handle, 'swi-petition', $this->loader->getPluginPath('languages') );

        # Support for petitions translated by WPML. If present this will return the original post ID, so
        # that all signatures collected under the same petition. If WPML is not installed or the post not translated,
        # this will return the current post ID.
        # TODO this will resolve to an incorrect post ID if using the form in a widget...
        $originalId = $post ? SwiPostType::resolveTranslatedPostId( $post->ID ) : 0;

        wp_localize_script(
            $handle,
            'swiPetition',
            [
                'url'    => admin_url( 'admin-ajax.php' ),
                'nonce'  => wp_create_nonce( 'swi_petition_submit' ),
                'id'     => $originalId,
                'goal'   => $post ? (int)get_post_meta( $originalId, 'swi_petition_goal', true ) : 0,
                'count'  => $post ? SwiSignatoryPostType::countPosts( $originalId, 'private' ) : 0,
                'redirect' => $post ? esc_url( get_post_meta( $post->ID, 'swi_petition_redirect', true ) ) : 0,
            ]
        );

    }

}
