# ThemeKit WordPress Starter Theme

[![GitHub release](https://img.shields.io/github/v/release/pressxco/flex?color=ed64a6)](https://github.com/pressxco/flex/releases) [![license](https://img.shields.io/badge/license-GPL--2.0%2B-orange)](https://github.com/pressxco/flex/blob/master/LICENSE) [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/pressxco/flex/pulls) ![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/pressxco/flex) ![GitHub repo size](https://img.shields.io/github/repo-size/pressxco/flex)

ThemeKit is the simplest WordPress starter theme including full setup for Sass, PostCSS, Autoprefixer, stylelint, Webpack, ESLint, imagemin, Browsersync, etc.

## Getting Started

### 1. Install Dependencies

```bash
composer install
yarn install
```

### 2. Start Dev Environment

```bash
yarn dev
```

## Configuration & Defaults

You can modify the configurations by editing `config` in `webpack.mix.js`.

```javascript
mix.browserSync({
	proxy: "http://localhost:8888",
	open: "external",
	port: 3000,
	files: ["*.php", "src/**/**/*"],
});
```

## Introduction

### Structure

ThemeKit is highly inspired by Laravel and its structure and allows to create WordPress theme in almost like an MVC model.

#### 1. Setting Up

ThemeKit uses a simple yaml file to command WordPress core. All you have to do is changing the few parameters in `src/setup.yaml` as per your requirements.

A default setup.yaml looks like this

```
themekit:
  config:
    theme_name: ThemeKit
    theme_version: 1.0.0
    text_domain: themekit
    load_composer: true
    jquery_support: false
    custom_fields: carbonfields

  dir:
    icon_dir: /build/icons/
    image_dir: /build/images/

  styles:
    main: /build/styles.bundle.css

  scripts:
    main: /build/scripts.bundle.js

  sidebars:
    primary:
      name: Primary Sidebar
      description: Primary Sidebar for the blog area.

  menus:
    primary:
      location: primary
      description: Hello there

  include_files:
    - src/Core/Config
    - src/Core/Local
    - src/Core/Support
    - src/Utils/Security
    - src/Utils/Performance
    - src/Theme/Main/Controllers/Templates
    - src/Theme/Layouts/Controllers/Layouts
    - src/Theme/Page/Controllers/Page

  services:
    - Artemis\Core\Local
    - Artemis\Setup\Widgets
    - Artemis\Setup\Assets
    - Artemis\Setup\NavMenus
    - Theme\Utils\Performance
    - Theme\Utils\Security
    - Theme\Main\Templates
    - Artemis\Core\Layouts
    - Theme\Page\Page

```

You can basically enqueue scripts/styles and create basic functionalities like adding new sidebar/menus with using this simple yaml file. Also all of the inputs can be retrieved by using `Artemis\Core\Bootstrap` class. For example getting the menus, you can use it like this:

`Artemis\Core\Bootstrap::$menus`.

More information can be find out at `vendor/themekit/src/Core/Bootstrap`.

#### 2. Template Structure

Templates can be easily added in `src/Theme/Main/Controllers/Templates.php` file. You can either define your templates and use as legitimate WordPress templates, or you can use WordPress filters to manipulate archive pages, search pages, home page etc...

Here is the default Templates.php file:

```
namespace Theme\Main;

use Artemis\Core\Registrable;
use Artemis\Core\Config;

class Templates implements Registrable {

	public function register() {
		\add_filter( 'theme_page_templates', [ $this, 'register_templates' ], 10 );
		\add_filter( 'page_template', [ $this, 'register_template_paths' ] );

		\add_filter( '404_template', [ $this, 'register_404_template' ] );
		\add_filter( 'home_template', [ $this, 'register_index_template' ] );
	}

	public static function templates() {
		return [
			'404' => [
				'file' => '404.php',
				'name' => '404',
			],
		];
	}

	public function register_templates( array $templates ): array {
		foreach ( Templates::templates() as $template ) {
			$templates[ $template['file'] ] = __( $template['name'] );
		}
		return $templates;
	}

	/**
	 * Retrieve path to our custom defined templates from {@see register_templates()}
	 *
	 * @param string $template_path Path to the template. {@see \locate_template()}.
	 * @return mixed|string
	 *
	 * @see \get_query_template() for filter reference
	 */
	public function register_template_paths( string $template_path ) {
		foreach ( Templates::templates() as $template ) {
			if ( \is_page_template( $template['file'] ) ) {
				return Config::theme_path( 'src/Theme/Page/Static/templates' ) . '/' . $template['file'];
			}
		}
		return $template_path;
	}

	public function register_404_template() {
		if ( file_exists( Config::theme_path( 'src/Theme/Page/Static/templates' ) . '/404.php' ) ) {
			return Config::theme_path( 'src/Theme/Page/Static/templates' ) . '/404.php';
		}
		return;
	}

	public function register_index_template() {
		if ( file_exists( Config::theme_path( 'src/Theme/Page/Static/templates' ) . '/index.php' ) ) {
			return Config::theme_path( 'src/Theme/Page/Static/templates' ) . '/index.php';
		}
	}

}
```

For more information regarding the WordPress template filters, please refer this document: https://developer.wordpress.org/reference/hooks/type_template/

#### 3. Registrable Classes

On ThemeKit, every class using a Registrable implementation so they can be easily called in the setup.yaml. Registrable should contain at least one register() function and that function will be called if that particular class name is added on the setup.yaml.first-letter:

This is a basic Support class to add some WordPress Core Support to the Theme:

```
<?php

namespace Artemis\Core;

class Support implements Registrable {
	public function register() {
		\add_theme_support( 'title-tag' );
		\add_theme_support( 'automatic-feed-links' );
		\add_theme_support( 'post-thumbnails' );
		\add_theme_support( 'custom-logo' );
		\add_theme_support( 'woocommerce' );
		\add_theme_support( 'menus' );
		\add_theme_support( 'html5', [
			'navigation-widgets',
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );
	}
}
```

As you can see, it contains the register class and ready to be called. And now, all you have to do is add that particular file in the `setup.yaml` and call the class like this:

```
  include_files:
    - src/Core/Support

  services:
    - Artemis\Core\Support
```

### Theme Helper Functions

#### Kit::layouts

Gets the layout from your desired location. Can be stacked and you can pass parameters inside the function.

Example usage:

```
Kit::layout(
	'default',
	function () {
		?>

	Your desired HTML...

	<?php


	}
);
```

For more information and other helpful functions check `vendor/themekit/src/Core/Utilities/Helpers.php` file.

---

#### Kit::component

Gets the component from your desired location. You can pass parameters inside the function.

Basic example:

`<?php Kit::component( 'header/head' ); ?>`

Advanced example:

`<?php Kit::component( 'footer/footer', array('myVariable' => 'myString') ); ?>`

For more information and other helpful functions check `vendor/themekit/src/Core/Utilities/Helpers.php` file.

---

#### Kit::icon

Gets the icon from the `build/icons` folder. Appends ".svg" extention for the first input.

Example (for inline SVGs):

`<?php Kit::icon('mylogo', 'inline') ?>`

Example (for SVGs in <img> tag):

`<?php Kit::icon('mylogo', 'tag') ?>`

For more information and other helpful functions check `vendor/themekit/src/Core/Utilities/Helpers.php` file.

---

#### Kit::image

Gets the image from the `build/images` folder. Accepts image type at the end of the file.

Example usage:

`<?php Kit::image('my-image.jpg') ?>`

For more information and other helpful functions check `vendor/themekit/src/Core/Utilities/Helpers.php` file.
