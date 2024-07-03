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

		<?php the_content(); ?>

	</div>

	<?php


	}
);
