<?php

namespace Dotburo;

use Dotburo\PostTypes\SwiPetitionPostType;
use Dotburo\PostTypes\SwiSignatoryPostType;

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
	const TEXT_DOMAIN = 'swi-petition';

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version = '1.0.0';

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      SwiHookLoader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

	/**
	 * @var array
	 */
	protected $post_types = [];

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
		$this->loader = $loader;;

		$this->set_locale();

		$this->register_post_types();

		$this->configureAdmin();
		//$this->define_public_hooks();

	}

	private function register_post_types() {

		$this->post_types = [
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
	private function set_locale() {

		$plugin_i18n = new SwiLocalisation();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function configureAdmin() {

        $this->loader->add_action( 'admin_head', $this, 'echoAdminHeadCss', PHP_INT_MAX, 0);


		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	public function echoAdminHeadCss() {
        foreach ($this->post_types as $post_type) {
            if (method_exists($post_type, 'getAdminHeadCss')) {
                $css[] = $post_type->getAdminHeadCss();
            }
        }

        if (!empty($css)) {
            echo "<style>" . implode( '', $css ) . "</style>";
        }
    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Swi_Petition_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return self::PLUGIN_NAME;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    SwiHookLoader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

}
