<?php
/**
 * Widgets Registration Class
 * -------------------------------------------------------------
 * This class manages the registration and setup of widget areas (sidebars) within the Artemis theme.
 * It dynamically registers multiple sidebars based on predefined configurations in the Bootstrap class,
 * facilitating the customization and widget management of the theme. Through the WordPress Widgets API,
 * it provides a structured way to add, manage, and display dynamic content blocks in various parts of the theme.
 * This functionality enhances the theme's flexibility, allowing site administrators to tailor their site's appearance
 * and functionality to better suit their needs without direct code changes.
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

class Widgets implements Registrable {
	/**
	 * Registers widget init hook.
	 */
	public function register() {
		add_action( 'widgets_init', [ $this, 'registerSidebars' ] );
	}

	/**
	 * Registers all sidebars using the Bootstrap configuration.
	 */
	public function registerSidebars() {
		if ( ! is_iterable( Bootstrap::$sidebars ) ) {
			return;
		}

		foreach ( Bootstrap::$sidebars as $sidebarId => $config ) {
			$this->registerSidebar( $sidebarId, $config );
		}
	}

	/**
	 * Registers a single sidebar.
	 *
	 * @param string $sidebarId The ID of the sidebar to register.
	 * @param array $config The configuration array for the sidebar.
	 */
	private function registerSidebar( $sidebarId, array $config ) {
		$defaults = [ 
			'description' => '',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => ''
		];

		$config = array_merge( $defaults, $config );

		register_sidebar( [ 
			'id' => $sidebarId,
			'name' => $config['name'],
			'description' => $config['description'],
			'before_widget' => $config['before_widget'],
			'after_widget' => $config['after_widget'],
			'before_title' => $config['before_title'],
			'after_title' => $config['after_title'],
		] );
	}
}
