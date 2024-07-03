<?php
/**
 *
 * The structure of the page that contains the front page and it's content.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

use Artemis\Utils\Helpers as Kit;

?>

<?php

Kit::layout(
	'default',
	function () {
		?>

	<div class="flex flex-col gap-2 text-center">

		<h1 class="text-5xl font-semibold tracking-[-0.015em] text-gray-900">
			<?php esc_html_e( 'Ready to start.', 'artemis' ); ?>
		</h1>

	</div>

	<?php


	}
);
