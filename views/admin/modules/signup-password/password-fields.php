<p class="pstoolkit-password">
	<label for="password"><?php _e( 'Passwort', 'ub' ); ?>:</label>
<?php
if ( ! empty( $error ) ) {
	echo '<p class="error">' . $error . '</p>';
}
?>
	<input name="password_1" type="password" id="password_1" value="" autocomplete="off" maxlength="20" class="input"/><br />
	<span><?php _e( 'Lasse die Felder leer, damit ein zufälliges Passwort generiert wird.', 'ub' ); ?></span>
</p>
<p class="pstoolkit-password">
	<label for="password"><?php _e( 'Passwort bestätigen', 'ub' ); ?>:</label>
	<input name="password_2" type="password" id="password_2" value="" autocomplete="off" maxlength="20" class="input" /><br />
	<span><?php _e( 'Gib Dein neues Passwort erneut ein.', 'ub' ); ?></span>
</p>
