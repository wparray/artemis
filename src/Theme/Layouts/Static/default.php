<?php
use Artemis\Utils\Helpers as Kit;

Kit::component( 'header/header' );
?>

<div id="layout-<?php esc_attr_e( $layout_name ); ?>" class="flex items-center justify-center h-full h-screen max-w-6xl mx-auto">

	<?php $layout_content(); ?>

</div>

<?php
Kit::component( 'footer/footer' );
