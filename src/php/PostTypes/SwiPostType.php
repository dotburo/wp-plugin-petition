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
    public function __construct( SwiHookLoader $loader ) {

        $this->loader = $loader;

        $this->loader->add_action( 'init', $this, 'init' );

        if ( defined('DOING_AJAX') && DOING_AJAX ) {
            //$this->registerAjaxHooks();
        } elseif ( is_admin() ) {
            $this->registerAdminHooks();
        } else {
            $this->registerPublicHooks();
        }
    }

    /**
     * @return SwiHookLoader
     */
    public function getLoader(): SwiHookLoader {
        return $this->loader;
    }

    /**
     * WPML support: attempt to return the translated post id.
     *
     * @param int $postId
     *
     * @return int
     */
    public static function resolveTranslatedPostId( int $postId ): int {
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            $defaultLang = apply_filters( 'wpml_default_language', null );

            return apply_filters( 'wpml_object_id', $postId, static::TYPE, true, $defaultLang );
        }

        return $postId;
    }

    /**
     * Return all post ids with a chosen key.
     *
     * @param string $keyBy
     *
     * @return array
     */
    public static function getPostIds( string $keyBy = '' ): array {
        $posts = get_posts( [
            'post_type'   => static::TYPE,
            'numberposts' => - 1,
        ] );

        if ( $keyBy ) {
            $posts = array_column( $posts, null, $keyBy );
        }

        return array_map( function ( $post ) {
            return $post->ID;
        }, $posts );
    }

    /**
     * Return all signatories.
     *
     * @param int $postId
     *
     * @return array
     */
    public function getAll( int $postId = 0 ): array {
        return [];
    }
}
