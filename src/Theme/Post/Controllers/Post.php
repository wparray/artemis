<?php

namespace Theme\Post;

use Theme\Core\Registrable;

class Post implements Registrable {
	public function register() {
		\add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		\add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Theme Styles.
	 *
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 */
	public function styles() {
	}

	/**
	 * Theme Scripts.
	 *
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 */
	public function scripts() {
	}
}
