<?php
/**
 * Local Environment Configuration Class
 * -------------------------------------------------------------
 * This class is designed to handle specific functions and configurations
 * for development in a local environment. It can be used to set up or override
 * configurations that are only meant for local development, such as debugging
 * tools, error reporting levels, and environment-specific endpoints or parameters.
 * This helps in maintaining a clear separation between production and local
 * development settings, ensuring smoother transitions and fewer configuration conflicts.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

class Local implements Registrable {
	public function register() {
	}
}
