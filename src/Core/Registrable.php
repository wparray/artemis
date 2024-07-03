<?php
/**
 * Registrable Interface
 * -------------------------------------------------------------
 * Defines a consistent contract for classes where registration of
 * components or functionalities with certain systems (like hooks, filters,
 * services, etc.) is required. Classes implementing Registrable should provide
 * their specific logic to the register method, which will be called usually
 * during system initialization or plugin/theme setup. This interface ensures
 * that all registrable components follow a uniform approach to being integrated
 * and activated within the Artemis framework or any other similar systems.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Core;

interface Registrable {
	public function register();
}
