<?php
/**
 * Layout Customization Class
 * -------------------------------------------------------------
 * This class enhances the theme's presentation by dynamically adding custom classes to the HTML body tag.
 * Useful for styling and responsive design adjustments, it interacts with WordPress hooks to inject
 * classes based on specific page types, user roles, or other conditional checks. The class uses
 * helper functions to build a list of custom classes, promoting cleaner and more maintainable code.
 * It also supports debugging and theming efforts, as it can modify the appearance or behavior based on
 * the added classes within different contexts across the site.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

use Artemis\Utils\Helpers;

class Layouts implements Registrable {

	/**
	 * Registers necessary WordPress hooks.
	 */
	public function register() {
		add_filter( 'body_class', [ $this, 'addClasses' ] );
	}

	/**
	 * Adds custom classes to the body tag.
	 *
	 * @param array $classes Existing body classes.
	 * @return array Modified array of classes including custom classes.
	 */
	public function addClasses( array $classes ) {
		return array_merge( $classes, Helpers::customClasses() );
	}
}
