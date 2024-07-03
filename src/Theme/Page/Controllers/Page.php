<?php

namespace Artemis\Page;

use Artemis\Core\Registrable;

class Page implements Registrable {
	/**
	 * Registers theme's styles and scripts.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}

	/**
	 * Enqueues theme's styles and scripts.
	 *
	 * Hooks to 'wp_enqueue_scripts' action.
	 *
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return void
	 */
	public function enqueueAssets() {
		// Enqueue styles here using wp_enqueue_style()
		// Enqueue scripts here using wp_enqueue_script()
	}
}
