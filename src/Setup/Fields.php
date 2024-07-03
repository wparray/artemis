<?php
/**
 * Fields Registration Class
 * -------------------------------------------------------------
 * This class serves as a hub for registering custom fields within the Artemis WordPress theme,
 * facilitating the integration of third-party libraries such as Carbon Fields or Advanced Custom Fields (ACF).
 * Specifically designed to streamline the addition of customizable, dynamic fields to various parts
 * of the WordPress admin, it plays a crucial role in enhancing the theme's flexibility and functionality.
 * By providing a centralized approach to field management, this class ensures a cohesive integration
 * and a more robust content management strategy, allowing developers to tailor the admin experience
 * and data handling to specific needs of the theme or website.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Setup;

use Artemis\Core\Registrable;
use \Carbon_Fields\Container;
use \Carbon_Fields\Field;

/**
 * Class Fields to register and manage custom fields using Carbon Fields.
 */
class Fields implements Registrable {
	/**
	 * Registers the actions and hooks required for setting up Carbon Fields.
	 */
	public function register() {
		// Register the theme options field panel on the 'carbon_fields_register_fields' action hook.
		add_action( 'carbon_fields_register_fields', [ $this, 'cbf_theme_options' ] );

		// Initialize Carbon Fields after the theme is setup.
		add_action( 'after_setup_theme', [ $this, 'cbf_setup' ] );
	}

	/**
	 * Boot Carbon Fields.
	 * This method initializes Carbon Fields after the theme setup.
	 */
	public function cbf_setup() {
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Register theme options fields.
	 * This method adds a theme options page and a text field using Carbon Fields.
	 */
	public function cbf_theme_options() {
		// Create a new theme options container.
		Container::make( 'theme_options', __( 'Theme Options', 'crb' ) )
			// Add fields to the theme options container.
			->add_fields( [ 
				Field::make( 'text', 'crb_text', 'Text Field' )
			] );
	}
}
