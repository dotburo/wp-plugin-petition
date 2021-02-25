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
	const TEXT_DOMAIN = 'swi-petition';

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
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

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
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version = SWI_PETITION_VERSION;

		$this->plugin_name = 'swi-petition';

		$this->load_dependencies();

		$this->loader = new SwiHookLoader();;

		$this->set_locale();

		$this->register_post_types();

		//$this->define_admin_hooks();
		//$this->define_public_hooks();

	}

	private function register_post_types() {
		$typeSignatory = SwiSignatoryPostType::TYPE;
		$typePetition = SwiPetitionPostType::TYPE;

		$this->post_types = [
			$typeSignatory => $signatory = new SwiSignatoryPostType(),
			$typePetition  => $petition = new SwiPetitionPostType(),
		];

		$this->loader->add_action( 'init', $signatory, 'register' );
		$this->loader->add_action( 'init', $petition, 'register' );

		if (is_admin()) {
			$this->loader->add_filter( "manage_{$typeSignatory}_posts_columns", $signatory, 'setAdminColumns' );
			$this->loader->add_action( "manage_{$typeSignatory}_posts_custom_column", $signatory, 'echoAdminColumnValues', 10, 2 );
			$this->loader->add_filter( "manage_edit-{$typeSignatory}_sortable_columns", $signatory,'setSortableAdminColumns' );
			$this->loader->add_filter("post_row_actions",$signatory, 'removeAdminColumnActions', 10, 2);
			$this->loader->add_action( "pre_get_posts", $signatory, 'sortAdminColumns', 10, 2 );
			$this->loader->add_filter( 'user_has_cap', $signatory, 'preventEdit', 10, 3 );

		}

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - SwiHookLoader. Orchestrates the hooks of the plugin.
	 * - Swi_Petition_i18n. Defines internationalization functionality.
	 * - Swi_Petition_Admin. Defines all hooks for the admin area.
	 * - Swi_Petition_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		$pluginDir = plugin_dir_path( dirname( __FILE__ ) );

		# The class responsible for defining all actions that occur in the admin area.
		//require_once "{$pluginDir}admin/class-swi-petition-admin.php";

		# The class responsible for defining all actions that occur in the public-facing side of the site.
		///require_once "{$pluginDir}public/class-swi-petition-public.php";
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
	private function define_admin_hooks() {

		$plugin_admin = new Swi_Petition_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

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
		return $this->plugin_name;
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
