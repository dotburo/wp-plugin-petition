<?php

namespace Dotburo;

use Dotburo\AdminArea\SwiAdminArea;
use Dotburo\PostTypes\SwiPetitionPostType;
use Dotburo\PostTypes\SwiSignatoryPostType;
use Dotburo\PublicArea\SwiPublicArea;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://dotburo.org
 * @since      1.0.0
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 * @author     dotburo <code@dotburo.org>
 */
class SwiPetition {

    /** @var string */
    const PLUGIN_NAME = 'swi-petition';

    /** @var string */
    const PLUGIN_VERSION = '1.0.0';

	/** @var string */
	const TXT_DOMAIN = 'swi-petition';

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      SwiHookLoader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

	/** @var array */
	protected $postTypes = [];

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @param SwiHookLoader $loader
     *
     * @since    1.0.0
     */
	public function __construct(SwiHookLoader $loader) {
	    $isAdmin = is_admin();

		$this->loader = $loader;

		$this->setLocale();

		$this->registerPostTypes();

		if ($isAdmin) {
            $this->configureAdminArea( $this->loader, $this->postTypes );
        }

		// ajax needs is_admin()
        $this->configurePublicArea( $this->loader, $this->postTypes );
	}

	private function registerPostTypes() {

		$this->postTypes = [
            SwiSignatoryPostType::TYPE => new SwiSignatoryPostType($this->loader),
            SwiPetitionPostType::TYPE  => new SwiPetitionPostType($this->loader),
		];

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Swi_Petition_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function setLocale() {

		$plugin_i18n = new SwiLocalisation($this->loader);

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'loadTextDomain' );

	}

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @param SwiHookLoader $loader
     * @param array $postTypes
     *
     * @return SwiAdminArea
     * @since    1.0.0
     * @access   private
     */
	private function configureAdminArea( SwiHookLoader $loader, array $postTypes): SwiAdminArea {

        return new SwiAdminArea( $loader, $postTypes );

	}


    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @param SwiHookLoader $loader
     * @param array $postTypes
     *
     * @return SwiPublicArea
     * @since    1.0.0
     * @access   private
     */
	private function configurePublicArea( SwiHookLoader $loader, array $postTypes ): SwiPublicArea {

		return new SwiPublicArea( $loader, $postTypes );

	}

    /**
     * @param string $suffix
     *
     * @return string
     */
	public static function createEnqueueHandle( string $suffix = ''): string {
	    return static::PLUGIN_NAME . ( $suffix ? '-' . ltrim($suffix, '-') : '' );
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    SwiHookLoader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function getLoader(): SwiHookLoader {
		return $this->loader;
	}

}
