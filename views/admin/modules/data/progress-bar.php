<span class="sui-description"><?php esc_html_e( 'Möchtest Du die Daten aller Unterwebseiten löschen? Verwende diese Option, um Daten von allen Unterwebseiten manuell zu löschen.', 'ub' ); ?></span>
<div class="sui-progress-block">
	<div class="sui-progress">
		<span class="sui-progress-icon" aria-hidden="true">
			<i class="sui-icon-loader sui-loading"></i>
		</span>
		<span class="sui-progress-text">
			<span></span>
		</span>
		<div class="sui-progress-bar" aria-hidden="true">
			<span style="width: 0"></span>
		</div>
	</div>
	<button class="sui-button-icon sui-tooltip"
		 data-tooltip="<?php echo esc_attr( _x( 'Abbrechen', 'Beende das Löschen von Unterwebseiten-Daten', 'ub' ) ); ?>">
		 <i class="sui-icon-close" aria-hidden="true"></i>
	</button>
</div>
<div class="sui-progress-state">
	<span></span>
</div>
