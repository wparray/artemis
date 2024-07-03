<?php
/**
 * Menus Configuration Class
 * -------------------------------------------------------------
 * This class is responsible for defining and registering navigation menus within the Artemis theme framework.
 * It utilizes WordPress capabilities to register various menu locations identified in the Bootstrap configurations,
 * allowing theme developers to implement multiple customized navigation options for different parts of the theme.
 * The class provides a structured method to manage these menus efficiently, enhancing the site's usability and
 * ensuring an organized navigation system. This approach makes it easier for site administrators to customize
 * and manage these menus through the WordPress admin panel.
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

class Menus implements Registrable {

	/**
	 * Registers the menu configuration action with WordPress
	 */
	public function register() {
		\add_action( 'after_setup_theme', [ $this, 'configMenus' ] );
	}

	/**
	 * Registers navigation menus based on configuration
	 */
	public function configMenus() {
		if ( ! empty( Bootstrap::$menus ) ) {
			array_walk( Bootstrap::$menus, function ($menu) {
				\register_nav_menu( $menu['location'], $menu['description'] );
			} );
		}
	}
}
