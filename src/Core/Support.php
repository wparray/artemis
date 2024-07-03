<?php
/**
 * Theme Support Configuration Class
 * -------------------------------------------------------------
 * This class facilitates the setup and configuration of theme support features in a WordPress theme.
 * It manages an array list of theme features such as automatic-feed-links, post-thumbnails, and custom-logo
 * along with specific HTML5 and WooCommerce support. Each feature can be dynamically enabled or configured
 * within this class. It ensures that the theme declares its compatibility and optimal configuration with
 * WordPress core features and advanced functionalities, enhancing the theme's capabilities through a systematic
 * and centralized approach.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

class Support implements Registrable {
	/**
	 * List of theme supports and their specific configurations.
	 *
	 * @var array
	 */
	private $themeSupports = [ 
		'title-tag',
		'automatic-feed-links',
		'post-thumbnails',
		'custom-logo',
		'woocommerce',
		'menus',
		'html5' => [ 
			'navigation-widgets',
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script'
		],
	];

	/**
	 * Registers theme supports.
	 */
	public function register() {
		foreach ( $this->themeSupports as $feature => $config ) {
			if ( is_array( $config ) ) {
				\add_theme_support( $feature, $config );
			} else {
				\add_theme_support( $config );
			}
		}
	}
}
