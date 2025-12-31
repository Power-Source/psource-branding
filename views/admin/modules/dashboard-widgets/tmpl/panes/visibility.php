<script type="text/html" id="tmpl-<?php echo esc_attr( $dialog_id ); ?>-pane-visibility">
<div class="sui-form-field pstoolkit-visibility-site">
	<label for="pstoolkit-visibility-site{{data.id}}" class="sui-label"><?php esc_html_e( 'Webseiten Dashboard', 'ub' ); ?></label>
	<span class="sui-description"><php esc_html_e( 'Wähle aus ob dieses Text-Widget im Webseiten-Dashboard angezeigt werden soll oder nicht.', 'ub' ); ?></span>
	<div class="sui-side-tabs sui-tabs">
		<div class="sui-tabs-menu">
			<label class="sui-tab-item<# if ( 'on' === data.site ) { #> active<# } #>"><input type="radio" name="pstoolkit[site]" value="on" data-name="site" data-tab-menu="pstoolkit-dashboard-widgets-site{{data.id}}-on"<# if ( 'on' === data.site ) { #> checked="checked"<# } #>><?php esc_html_e( 'Anzeigen', 'ub' ); ?></label>
			<label class="sui-tab-item<# if ( 'off' === data.site ) { #> active<# } #>"><input type="radio" name="pstoolkit[site]" value="off" data-name="site" data-tab-menu="pstoolkit-dashboard-widgets-site{{data.id}}-off"<# if ( 'off' === data.site ) { #> checked="checked"<# } #>><?php esc_html_e( 'Ausblenden', 'ub' ); ?></label>
		</div>
	</div>
</div>
<?php if ( $this->is_network && is_network_admin() ) { ?>
<div class="pstoolkit-divider"></div>
<div class="sui-form-field pstoolkit-visibility-network">
	<label for="pstoolkit-visibility-network{{data.id}}" class="sui-label"><?php esc_html_e( 'Netzwerk Dashboard', 'ub' ); ?></label>
	<span class="sui-description"><?php esc_html_e( 'Wähle aus ob dieses Text-Widget im Netzwerk-Dashboard angezeigt werden soll oder nicht.', 'ub' ); ?></span>
	<div class="sui-side-tabs sui-tabs">
		<div class="sui-tabs-menu">
			<label class="sui-tab-item<# if ( 'on' === data.network ) { #> active<# } #>"><input type="radio" name="pstoolkit[network]" value="on" data-name="network" data-tab-menu="pstoolkit-dashboard-widgets-network{{data.id}}-on"<# if ( 'on' === data.network ) { #> checked="checked"<# } #>><?php esc_html_e( 'Anzeigen', 'ub' ); ?></label>
			<label class="sui-tab-item<# if ( 'off' === data.network ) { #> active<# } #>"><input type="radio" name="pstoolkit[network]" value="off" data-name="network" data-tab-menu="pstoolkit-dashboard-widgets-network{{data.id}}-off"<# if ( 'off' === data.network ) { #> checked="checked"<# } #>><?php esc_html_e( 'Ausblenden', 'ub' ); ?></label>
		</div>
	</div>
</div>
<?php } ?>
</script>
