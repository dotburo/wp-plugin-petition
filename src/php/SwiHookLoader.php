<?php

namespace Dotburo;

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://dotburo.org
 * @since      1.0.0
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Swi_Petition
 * @subpackage Swi_Petition/includes
 * @author     dotburo <code@dotburo.org>
 */
class SwiHookLoader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions = [];

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters = [];

	/**
     * @var string
     */
    protected $pluginPath;

    public function __construct(string $pluginPath) {

        $this->pluginPath = $pluginPath;
    }

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object|callable      $object           A reference to the instance of the object on which the action is defined.
	 * @param    ?string              $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 *
	 * @since    1.0.0
	 */
	public function add_action( $hook, $object, $callback = null, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $object, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object|callable      $object           A reference to the instance of the object on which the filter is defined.
	 * @param    ?string              $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $object, $callback = null, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $object, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object|callable      $object           A reference to the instance of the object on which the filter is defined.
	 * @param    ?string              $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $object, $callback = null, $priority = 10, $accepted_args = 1 ) {

		$hooks[] = array(
			'hook'          => $hook,
			'object'        => $object,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter(
			    $hook['hook'],
                is_callable($hook['object']) ? $hook['object'] : [$hook['object'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
		}

		foreach ( $this->actions as $hook ) {
			add_action(
			    $hook['hook'],
                is_callable($hook['object']) ? $hook['object'] : [$hook['object'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
		}

	}

    /**
     * @param string $path
     *
     * @return string
     */
    public function getPluginPath(string $path = ''): string {
        return $this->pluginPath . '/' . ltrim($path, '/');
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getPluginBuildPath(string $path = ''): string {
        return $this->pluginPath . '/build/' . ltrim($path, '/');
    }

}
