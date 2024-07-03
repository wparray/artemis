<?php
/**
 * Theme Assets Handler
 * -------------------------------------------------------------
 * This class manages the integration and handling of styles and scripts within
 * the Artemis WordPress theme. It serves to simplify the process of enqueuing,
 * dependencies, and versions control for all theme-related assets like CSS and JavaScript files.
 * Orchestrating these resources utilizing WordPress hooks, the class aims to optimize
 * performance and ensure that assets are correctly loaded in the appropriate contexts
 * (e.g., loading specific scripts only on pages where they are needed). It is central
 * to maintaining a clean and efficient loading order and avoiding potential conflicts
 * between scripts or stylesheets.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Setup;

use Artemis\Core\Bootstrap;
use Artemis\Core\Registrable;

/**
 * Class responsible for handling theme assets like styles and scripts.
 */
class Assets implements Registrable {
	/**
	 * Registers styles and scripts hooks with WordPress.
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueStyles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );
	}

	/**
	 * Enqueues theme styles.
	 */
	public function enqueueStyles() {
		$this->enqueueAssets( Bootstrap::$styles, 'style' );
	}

	/**
	 * Enqueues theme scripts.
	 */
	public function enqueueScripts() {
		if ( Bootstrap::$config['jquery'] && ! in_array( 'jquery', wp_scripts()->registered ) ) {
			wp_enqueue_script( 'jquery' );
		}

		$this->enqueueAssets( Bootstrap::$scripts, 'script', [ 'jquery' => Bootstrap::$config['jquery'] ] );
	}

	/**
	 * General asset enqueuing method for styles and scripts.
	 *
	 * @param array $assets Array of assets to enqueue.
	 * @param string $type Type of asset ('style' or 'script').
	 * @param array $deps_map Optional. Map of handle dependencies.
	 */
	private function enqueueAssets( array $assets, string $type, array $deps_map = [] ) {

		foreach ( $assets as $handle => $path ) {

			$uri          = \get_stylesheet_directory_uri() . $path;
			$dependencies = $type === 'script' && isset( $deps_map[ $handle ] ) && $deps_map[ $handle ] ? [ 'jquery' ] : [];
			$version      = Bootstrap::$config['version'] ?? false;
			$in_footer    = ( $type === 'script' ); // Scripts in footer by default

			if ( $type === 'style' ) {
				\wp_enqueue_style( $handle, $uri, $dependencies, $version );
			} elseif ( $type === 'script' ) {
				\wp_enqueue_script( $handle, $uri, $dependencies, $version, $in_footer );
			}
		}
	}
}
