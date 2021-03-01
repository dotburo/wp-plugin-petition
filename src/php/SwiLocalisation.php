<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://dotburo.org
 * @since      1.0.0
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 */

namespace Dotburo;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 * @author     dotburo <code@dotburo.org>
 */
class SwiLocalisation {

    /** @var SwiHookLoader */
    private $loader;

    /**
     * SwiLocalisation constructor.
     *
     * @param SwiHookLoader $loader
     */
    public function __construct(SwiHookLoader $loader) {

        $this->loader = $loader;
    }

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function loadTextDomain() {

		load_plugin_textdomain(
			'swi-petition',
			false,
            basename( $this->loader->getPluginPath() ). '/languages'
		);

	}

}
