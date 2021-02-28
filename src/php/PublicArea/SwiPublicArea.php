<?php

namespace Dotburo\PublicArea;

use Dotburo\SwiArea;
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

	/** @inheritDoc */
	public function enqueue_styles() {

	    /*
		wp_enqueue_style(
		    SwiPetition::PLUGIN_NAME,
            plugins_url( 'build/swi-petition-public.min.css', $this->loader->getPluginPath() ),
            [],
            filemtime( $this->loader->getPluginPath( 'build/swi-petition-public.min.css' ) ),
        ); */

	}

    /** @inheritDoc */
	public function enqueue_scripts() {
	    $file = $this->loader->getPluginPath('build/swi-petition-public.min.js');

		wp_enqueue_script(
            SwiPetition::PLUGIN_NAME,
            plugins_url( '/swi-petition-public.min.js', $file ),
            [],
            filemtime( $file ),
            true
        );

	}

}
