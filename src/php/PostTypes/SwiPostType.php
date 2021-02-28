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
	abstract public function init();

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

        $this->loader->add_action( 'init', $this, 'init' );

        if (is_admin()) {
            $this->registerAdminHooks();
        } else {
            $this->registerPublicHooks();
        }
    }

    public static function getPostIds(string $keyBy = '') {
        $posts = get_posts([
            'post_type' => static::TYPE,
            'numberposts' => -1,
        ]);

        if ($keyBy) {
            $posts = array_column($posts, null, $keyBy);
        }

        return array_map(function ($post) {
            return $post->ID;
        }, $posts);
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
