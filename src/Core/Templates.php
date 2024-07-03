<?php
/**
 * Templates Class for Theme Customization
 * -------------------------------------------------------------
 * This class is integral to handling the registration and management of custom
 * page templates within the Artemis WordPress theme. It enables the theme to offer
 * unique page designs by registering custom templates that can be selected directly
 * from the WordPress page editor. This flexibility allows theme users to apply different
 * visual styles and layouts to individual pages, enhancing the customizability and
 * functionality of the theme. Moreover, the class provides methods to integrate these templates
 * smoothly with the WordPress core, ensuring compatibility and ease of use.
 *
 * @package Artemis
 * @version 1.0.0
 * @version 1.0.1 Refactored for improved maintainability and performance
 */

namespace Artemis\Core;

/**
 * Handles the registration and retrieval of custom page templates within a WordPress theme.
 */
class Templates implements Registrable {
	public function register() {
		$filters = [ 
			"page_template" => "register_page_template",
			"theme_page_templates" => "register_templates",
			"404_template" => "register_404_template",
			"home_template" => "register_index_template",
			"frontpage_template" => "register_index_template",
			"single_template" => "register_single_template",
			"category_template" => "register_category_template",
			"search_template" => "register_search_template",
		];

		foreach ( $filters as $hook => $method ) {
			\add_filter( $hook, [ $this, $method ] );
		}
	}

	/**
	 * Returns an array of templates with file paths and names
	 *
	 * @return array
	 */
	public static function templates(): array {
		return [ 
			"Home" => [ 
				"file" => "index.php",
				"name" => "Home",
			],
			"404" => [ 
				"file" => "404.php",
				"name" => "404",
			],
		];
	}

	/**
	 * Registers the templates for usage in the theme
	 *
	 * @param array $templates
	 * @return array
	 */
	public function register_templates( array $templates ): array {
		foreach ( self::templates() as $template ) {
			$templates[ $template["file"] ] = __( $template["name"] );
		}

		return $templates;
	}

	/**
	 * Retrieves the path to templates configured in register_templates
	 *
	 * @param string $template_path
	 * @return string
	 */
	public function register_template_paths( string $template_path ): string {
		foreach ( self::templates() as $template ) {
			if ( \is_page_template( $template["file"] ) ) {
				return $this->get_template_path( $template["file"], "Page" );
			}
		}

		return $template_path;
	}

	/**
	 * Registers the custom 404 template path
	 *
	 * @return string
	 */
	public function register_404_template(): string {
		return $this->get_template_path( "404.php", "Page" );
	}

	/**
	 * Registers the custom index template path
	 *
	 * @return string
	 */
	public function register_index_template(): string {
		return $this->get_template_path( "index.php", "Page" );
	}

	/**
	 * Registers the custom single post template path
	 *
	 * @return string
	 */
	public function register_single_template(): string {
		return $this->get_template_path( "single.php", "Post" );
	}

	/**
	 * Registers the custom category template path
	 *
	 * @return string
	 */
	public function register_category_template(): string {
		return $this->get_template_path( "tax-category.php", "Archive" );
	}

	/**
	 * Registers the custom search template path
	 *
	 * @return string
	 */
	public function register_search_template(): string {
		return $this->get_template_path( "search-template.php", "Archive" );
	}

	/**
	 * Registers the custom page template path
	 *
	 * @return string
	 */
	public function register_page_template(): string {
		return $this->get_template_path( "page.php", "Page" );
	}

	/**
	 * Retrieves the template path based on sub-directory and file name
	 *
	 * @param string $file
	 * @param string $sub_dir
	 * @return string
	 */
	private function get_template_path( string $file, string $sub_dir ): string {
		$template_path = Config::themePath(
			"src/Theme/{$sub_dir}/Static/templates/{$file}"
		);

		return file_exists( $template_path ) ? $template_path : "";
	}
}
