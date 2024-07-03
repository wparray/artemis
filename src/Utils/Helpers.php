<?php
/**
 * Utility Helpers Class
 * -------------------------------------------------------------
 * This class provides a collection of utility methods designed to assist in various aspects of Artemis
 * theme enhancement and functionality. It handles everything from fetching template parts, managing layouts,
 * displaying icons, images, and buttons, to debugging. Each method is built to streamline specific tasks
 * within the theme, offering a straightforward interface for implementing complex features, thereby contributing
 * to maintaining a cleaner, more organized codebase. This significantly eases the development process, ensuring
 * that common tasks can be performed with minimal effort and high efficiency.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Utils;

use Artemis\Core\Bootstrap;

class Helpers {

	/**
	 * Get Icon.
	 *
	 * Simple icon grabber and parser.
	 *
	 * @param  string $icon Icon name.
	 * @see Kit::icon();
	 * @since 1.0.0
	 * @return $icon
	 */
	public static function icon( $icon = '', $type = 'inline' ) {

		if ( $type === 'inline' ) {
			echo file_contents( esc_attr( Bootstrap::$icon_dir ) . esc_attr( $icon ) . '.svg' ); // phpcs:ignore
		} else {
			echo '<img src="' . esc_attr( Bootstrap::$icon_dir ) . esc_attr( $icon ) . '.svg">'; // phpcs:ignore
		}
	}

	/**
	 * Get Layout.
	 *
	 * Simple content wrapper with the specific layout.
	 * $layout_content will be parsed inside the layout template.
	 *
	 * @param  string $layout_name The layout name.
	 * @param  callable $layout_content The layout content.
	 * @param  array  $layout_args The layout args.
	 * @see  Kit::layout();
	 * @since  1.0.0
	 * @return void
	 */
	public static function layout( $layout_name, $layout_content, $layout_args = array() ) {
		// Ensure the layout file exists before including it.
		$file_path = get_template_directory() . "/src/Theme/Layouts/Static/$layout_name.php";

		if ( file_exists( $file_path ) ) {
			// Make $layout_args available within the layout file.
			extract( $layout_args );

			// Include the layout file.
			require $file_path;

			// Check if $layout_content is callable and then call it.
			if ( is_callable( $layout_content ) ) {
				call_user_func( $layout_content, $layout_args );
			} else {
				// Handle the case where $layout_content is not callable.
				echo $layout_content;
			}
		} else {
			// Handle the case where the layout file does not exist.
			echo "Layout file not found: $layout_name";
		}

	}

	/**
	 * Get Debugger.
	 *
	 * This is a simple debugger method where it passes the $code
	 * in a way more readable way.
	 *
	 * @param  mixed $code Code.
	 * @see Kit::debug();
	 * @since  1.0.0
	 * @return void
	 */
	public static function debugger( $code ) {

		echo '<pre>' . esc_html( var_dump( $code ) ) . '</pre>';

	}

	/**
	 * Get Template.
	 * Calling the template with arguments.
	 *
	 * This method can be used for various ways from calling simple
	 * templates to calling loops with arguments.
	 *
	 * @param  string $template The template.
	 * @param  array  $args The arguments.
	 * @see Kit::template();
	 * @since  1.0.0
	 * @return $template.
	 */
	public static function component( $template, $args = array(), $type = 'Page' ) {

		return \get_template_part( 'src/Theme/' . $type . '/Static/components/' . $template, '', $args );

	}

	/**
	 * Get Button.
	 *
	 * @param  string $content Button content.
	 * @param  string $link Button link.
	 * @param  string $class Button class.
	 * @param  string $style Button styles.
	 * @see Kit::button();
	 * @since  1.0.0
	 * @return void
	 */
	public static function button( $content, $link = '#', $class = '', $style = '' ) {

		echo '<a class="' . esc_attr( $class ) . '" href="' . esc_attr( $link ) . '" style="' . esc_attr( $style ) . '">' . esc_html( $content ) . '</a>';

	}

	/**
	 * Get Image.
	 *
	 * @param  string $image Image name.
	 * @param  string $alt Image alt tag.
	 * @param  string $class Image class.
	 * @see Kit::image();
	 * @since 1.0.0
	 * @return void
	 */
	public static function image( $image, $type = 'tag', $alt = '', $class = '' ) {

		if ( $type === 'tag' ) {
			echo '<img class="' . esc_attr( $class ) . ' lazyload" src="' . esc_attr( Bootstrap::$image_dir ) . esc_attr( $image ) . '" alt="' . esc_attr( $alt ) . '">';
		}

		if ( $type === 'url' ) {
			echo esc_attr( Bootstrap::$image_dir ) . esc_attr( $image );
		}

	}
}
