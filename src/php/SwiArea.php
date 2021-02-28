<?php

namespace Dotburo;

abstract class SwiArea {

    /** @var SwiHookLoader */
    protected $loader;

    /** @var array */
    protected $postTypes;

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    abstract public function enqueue_styles();

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    abstract public function enqueue_scripts();

    /**
     * Initialize the class and set its properties.
     *
     * @param SwiHookLoader $loader
     * @param array $postTypes
     *
     * @since    1.0.0
     */
    public function __construct( SwiHookLoader $loader, array $postTypes ) {

        $this->loader = $loader;

        $this->postTypes = $postTypes;

        $this->enqueue();

    }

    protected function enqueue() {
        $hook = !is_admin() ? 'wp_enqueue_scripts' : 'init';

        $this->loader->add_action( $hook, $this, 'enqueue_styles' );

        $this->loader->add_action( $hook, $this, 'enqueue_scripts' );

    }

}
