<?php

namespace Dotburo\PostTypes;

abstract class SwiPostType {

	/** @var string */
	const TYPE = 'post';

	/**
	 * @return mixed
	 * @return void
	 */
	abstract public function register();

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