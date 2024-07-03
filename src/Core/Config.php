<?php
/**
 *  Configuration Utility Class
 * -------------------------------------------------------------
 *  This class provides methods to manage the theme configuration,
 *  including paths, URLs, environment settings, and asset handling
 *  for a WordPress theme. It facilitates easy management and retrieval
 *  of theme-specific paths, URLs, and other configurations, supporting
 *  an organized structure within the theme development. It includes utility
 *  functions to interact with different types of resources such as images,
 *  JavaScript files, CSS files, and template parts, ensuring that these
 *  resources are efficiently managed and accessed throughout the theme.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

class Config {
	/**
	 * Returns the current WordPress environment (prod|dev).
	 */
	public static function env() {
		return defined( 'WP_ENVIRONMENT_TYPE' ) ? WP_ENVIRONMENT_TYPE : '';
	}

	/**
	 * Returns the full path of the asset from the ViteJS generated manifest.
	 */
	public static function assetPath( string $fileKey ) {
		static $manifest = null;
		if ( is_null( $manifest ) ) {
			$manifestPath    = static::buildPath( 'manifest.json' );
			$manifestContent = file_get_contents( $manifestPath );
			$manifest        = json_decode( $manifestContent, true );
		}

		return $manifest[ $fileKey ] ?? '';
	}

	/**
	 * Constructs a path relative to the root theme directory.
	 */
	public static function themePath( string $relativePath = '' ) {
		return get_stylesheet_directory() . DIRECTORY_SEPARATOR . $relativePath;
	}

	/**
	 * Constructs a URL relative to the root theme URL.
	 */
	public static function themeUrl( string $relativePath = '' ) {
		return get_stylesheet_directory_uri() . '/' . $relativePath;
	}

	/**
	 * Constructs a path to a resource in a specific src subdirectory.
	 */
	public static function srcPath( string $subdir, string $file ) {
		return static::themePath( "src/{$subdir}/Static/{$file}" );
	}

	/**
	 * Constructs a URL to a resource in a specific src subdirectory.
	 */
	private static function srcUrl( string $subdir, string $file ) {
		return static::themeUrl( "src/{$subdir}/Static/{$file}" );
	}

	// Public methods for accessing specific types of paths and URLs.
	public static function templatePath( string $path, string $template ) {
		return static::srcPath( $path, "templates/{$template}" );
	}

	public static function imagePath( string $path, string $file ) {
		return static::srcPath( $path, "images/{$file}" );
	}

	public static function jsPath( string $path, string $file ) {
		return static::srcPath( $path, "js/{$file}" );
	}

	public static function cssPath( string $path, string $file ) {
		return static::srcPath( $path, "css/{$file}" );
	}

	public static function imageUrl( string $path, string $file ) {
		return static::srcUrl( $path, "images/{$file}" );
	}

	public static function jsUrl( string $path, string $file ) {
		return static::srcUrl( $path, "js/{$file}" );
	}

	public static function cssUrl( string $path, string $file ) {
		return static::srcUrl( $path, "css/{$file}" );
	}

	public static function buildPath( string $relativePath = '' ) {
		return static::themePath( "build/{$relativePath}" );
	}

	public static function buildUrl( string $relativePath = '' ) {
		return static::themeUrl( "build/{$relativePath}" );
	}

	// Utility methods to generate prefixed slugs or identifiers.
	public static function slugify( $relative = '' ) {
		return static::slug() . '-' . sanitize_title( $relative );
	}

	public static function underscore( $relative = '' ) {
		return static::slug() . '_' . $relative;
	}

	private static function slug() {
		return 'artemis'; // This can be dynamic based on context or a setting.
	}
}
