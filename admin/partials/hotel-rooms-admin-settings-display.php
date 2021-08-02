<?php

?>
<div class="wrap">
    <h2><?php _e( "Plugin Configuration", HR_PLUGIN_SLUG ) ?></h2>
	<?php settings_errors(); ?>
    <form method="POST" action="options.php">
		<?php
		settings_fields( 'hotel_rooms_general_settings' );
		do_settings_sections( 'hotel_rooms_general_settings' );
		?>
		<?php submit_button(); ?>
    </form>
</div>
