<?php

namespace Artemis\Blocks;

use Artemis\Core\Registrable;

class Blocks implements Registrable {
	/**
	 * Registers blocks hooks with WordPress.
	 */
	public function register() {
		add_action( 'init', [ $this, 'registerBlocks' ] );
	}

	/**
	 * Registers blocks with WordPress.
	 */
	public function registerBlocks() {
		\register_block_type( __DIR__ . '/../Static/blocks/sample-block' );
	}
}
