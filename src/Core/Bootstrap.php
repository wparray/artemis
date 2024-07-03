<?php
/**
 *  Bootstrap Class
 * -------------------------------------------------------------
 *  The Bootstrap class is responsible for initializing and managing
 *  the core functionalities and configurations of the Artemis Starter Theme.
 *  It sets up theme-specific details, registers styles, scripts, menus,
 *  and sidebars, and oversees the integration of various services such as
 *  templates, localization, and various utility functions. By employing
 *  a singleton pattern, it ensures that the class instance is created once
 *  and accessible globally.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

use Artemis\Core\Registrable;

class Bootstrap {
	/**
	 * Theme configuration data.
	 *
	 * @var array
	 */
	public static $config = [ 
		'name' => 'Artemis Starter Theme',
		'version' => 'v1.0.0',
		'text_domain' => 'artemis',
		'jquery' => false,
		'custom_fields' => false,
		'icon_dir' => '/build/icons/',
		'image_dir' => '/build/images/'
	];

	/**
	 * Styles.
	 *
	 * @var array
	 */
	public static $styles = [ 
		'artemis-style' => '/build/styles.bundle.css'
	];

	/**
	 * Scripts
	 *
	 * @var array
	 */
	public static $scripts = [ 
		'artemis-scripts' => '/build/scripts.bundle.js'
	];

	/**
	 * Sidebar configuration.
	 *
	 * @var array
	 */
	public static $sidebars = [ 
		'primary' => [ 
			'name' => 'Primary Sidebar',
			'id' => 'primary',
			'description' => 'Primary Sidebar',
			'class' => 'primary-sidebar',
		]
	];

	/**
	 * Menu configuration.
	 *
	 * @var array
	 */
	public static $menus = [ 
		'primary' => [ 
			'location' => 'primary',
			'description' => 'Primary Menu',
		]
	];

	/**
	 * Singleton instance of the class.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Returns singleton instance of the class.
	 *
	 * @return self
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance->run();
	}

	/**
	 * Initializes the application setup.
	 */
	public function run() {
		$this->registerServices();
	}

	/**
	 * Registers all the services defined in the services container.
	 */
	private function registerServices() {
		foreach ( $this->servicesContainer() as $service ) {
			if ( ( new $service ) instanceof Registrable ) {
				( new $service )->register();
			}
		}
	}

	/**
	 * Contains all the service classes.
	 *
	 * @return array
	 */
	private function servicesContainer() {
		return [ 

			// Core.
			'Artemis\Core\Templates',
			'Artemis\Core\Local',
			'Artemis\Core\Support',

			// Setup.
			'Artemis\Setup\Menus',
			'Artemis\Setup\Assets',
			'Artemis\Setup\Widgets',
			'Artemis\Setup\Fields',

			// Utils.
			'Artemis\Utils\Performance',
			'Artemis\Utils\Security',

			// Blocks.
			'Artemis\Blocks\Blocks'
		];
	}
}
