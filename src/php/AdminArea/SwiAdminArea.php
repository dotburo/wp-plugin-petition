<?php

namespace Dotburo\AdminArea;

use Dotburo\SwiArea;
use Dotburo\SwiHookLoader;
use Dotburo\SwiPetition;

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://dotburo.org
 * @since      1.0.0
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/PublicArea
 */

/**
 * The admin-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-facing stylesheet and JavaScript.
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/AdminArea
 * @author     dotburo <code@dotburo.org>
 */
class SwiAdminArea extends SwiArea {

    public function __construct( SwiHookLoader $loader, array $postTypes ) {
        parent::__construct( $loader, $postTypes );

        $this->loader->add_action( 'admin_head', $this, 'echoAdminHeadCss', PHP_INT_MAX, 0);
    }

    /**
     * Echo styles directly in the admin `<head>` if post types require it.
     *
     * @return void
     */
    public function echoAdminHeadCss() {
        foreach ($this->postTypes as $post_type) {
            if (method_exists($post_type, 'getAdminHeadCss')) {
                $css[] = $post_type->getAdminHeadCss();
            }
        }

        if (!empty($css)) {
            echo "<style>" . implode( '', $css ) . "</style>";
        }
    }

    /** @inheritDoc */
	public function enqueue_scripts() {
	    $handle = SwiPetition::createEnqueueHandle();

        $assetPath = $this->loader->getPluginBuildPath('index.asset.php');

        $script_asset = require( $assetPath );

        wp_register_script(
            $handle,
            plugins_url( 'build/index.js', $this->loader->getPluginBuildPath() ),
            $script_asset['dependencies'],
            $script_asset['version']
        );

        wp_set_script_translations( $handle, 'swi-petition', $this->loader->getPluginPath('languages') );

        register_block_type(
            'swi-petition/form-block',
            [
                'editor_script' => $handle,
                'editor_style'  => $handle,
                'style'         => SwiPetition::PLUGIN_NAME,
            ]
        );

        register_block_type(
            'swi-petition/counter-block',
            [
                'editor_script' => $handle,
                'editor_style'  => $handle,
                'style'         => SwiPetition::PLUGIN_NAME,
            ]
        );

	}

    /** @inheritDoc */
    public function enqueue_styles() {

        $file = $this->loader->getPluginPath( 'build/index.css' );

        wp_enqueue_style(
            SwiPetition::PLUGIN_NAME,
            plugins_url( 'index.css', $file ),
            [],
            filemtime( $file )
        );

    }

}
