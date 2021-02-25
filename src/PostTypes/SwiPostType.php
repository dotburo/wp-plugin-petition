<?php

namespace Dotburo\PostTypes;

use Dotburo\SwiHookLoader;

abstract class SwiPostType {

	/** @var string */
	const TYPE = 'post';

    /** @var SwiHookLoader */
    protected $loader;

	/** @var array */
    protected $meta = [];

    /**
	 * @return mixed
	 * @return void
	 */
	abstract public function register();

    /**
     * @return void
     */
    abstract protected function registerAdminHooks();

    /**
     * @return void
     */
    abstract protected function registerPublicHooks();

    /**
     * SwiPostType constructor.
     *
     * @param SwiHookLoader $loader
     */
	public function __construct(SwiHookLoader $loader) {

        $this->loader = $loader;

        if (is_admin()) {
            $this->registerAdminHooks();
        } else {
            $this->registerPublicHooks();
        }
    }

	/**
	 * @param int $id
	 * @return array
	 */
	public function getMeta( int $id ): array {
		$meta = (array) get_metadata( 'post', $id );

		foreach ( $meta as $k => $v ) {
			$meta[ $k ] = $v[0];
		}

		//$meta['permalink'] = get_permalink($id);

		return $meta;
	}
}
