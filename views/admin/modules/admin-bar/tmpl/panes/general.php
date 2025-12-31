<script type="text/html" id="tmpl-<?php echo esc_attr( $dialog_id ); ?>-pane-general">
<div class="sui-row">
	<div class="sui-col">
		<div class="sui-form-field pstoolkit-general-title">
			<label for="pstoolkit-general-title-{{data.id}}" class="sui-label"><?php esc_html_e( 'Titel', 'ub' ); ?></label>
			<input id="pstoolkit-general-title-{{data.id}}" type="text" name="pstoolkit[title]" value="{{data.title}}" data-default="" data-required="required" aria-describedby="input-description" class="sui-form-control">
			<span class="hidden"><?php esc_html_e( 'Dieses Feld kann nicht leer sein!', 'ub' ); ?></span>
			<span class="sui-description"><?php esc_html_e( 'Du kannst anstelle des Texttitels auch die vollständige URL eines Bildes einfügen. Z.B. http://example.com/img.png', 'ub' ); ?></span>
		</div>
	</div>
	<div class="sui-col">
		<div class="sui-form-field">
			<label for="pstoolkit-general-icon-{{data.id}}" class="sui-label"><?php esc_html_e( 'Symbol', 'ub' ); ?></label>
<?php echo $icons; ?>
			<span class="sui-description"><?php esc_html_e( 'Wähle ein Symbol für Deinen benutzerdefinierten Menüpunkt.', 'ub' ); ?></span>
		</div>
	</div>
</div>
<div class="sui-form-field pstoolkit-general-url">
	<label for="pstoolkit-general-url-{{data.id}}" class="sui-label"><?php esc_html_e( 'Link zu', 'ub' ); ?></label>
	<div class="sui-side-tabs sui-tabs">
		<div class="sui-tabs-menu">
			<label class="sui-tab-item<# if ( 'none' === data.url ) { #> active<# } #>"><input type="radio" name="pstoolkit[url]" value="none" data-name="url" data-tab-menu="pstoolkit-admin-bar-url-{{data.id}}-none" data-default="none"<# if ( 'none' === data.url ) { #> checked="checked"<# } #>><?php esc_html_e( 'Keiner', 'ub' ); ?></label>
			<label class="sui-tab-item<# if ( 'main' === data.url ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[url]" value="main" data-name="url" data-tab-menu="pstoolkit-admin-bar-url-{{data.id}}-main" data-default="none"<# if ( 'main' === data.url ) { #> checked="checked"<# } #>><?php esc_html_e( 'Hauptseite', 'ub' ); ?>
			</label>
<# if ( data.is_network ) { #>
			<label class="sui-tab-item<# if ( 'current' === data.url ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[url]" value="current" data-name="url" data-tab-menu="pstoolkit-admin-bar-url-{{data.id}}-current" data-default="none"<# if ( 'current' === data.url ) { #> checked="checked"<# } #>><?php esc_html_e( 'Aktuelle Seite', 'ub' ); ?>
			</label>
<# } #>
			<label class="sui-tab-item<# if ( 'wp-admin' === data.url ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[url]" value="wp-admin" data-name="url" data-tab-menu="pstoolkit-admin-bar-url-{{data.id}}-wp-admin" data-default="none"<# if ( 'wp-admin' === data.url ) { #> checked="checked"<# } #>><?php esc_html_e( 'Admin-Bereich', 'ub' ); ?>
			</label>
			<label class="sui-tab-item<# if ( 'custom' === data.url ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[url]" value="custom" data-name="url" data-tab-menu="pstoolkit-admin-bar-url-{{data.id}}-custom" data-default="none"<# if ( 'custom' === data.url ) { #> checked="checked"<# } #>><?php esc_html_e( 'Eigene URL', 'ub' ); ?>
			</label>
		</div>
	</div>
</div>
<div class="sui-border-frame pstoolkit-admin-bar-url-options<# if ( 'none' === data.url ) { #> hidden<# } #>">
	<div class="sui-form-field pstoolkit-general-custom<# if ( 'custom' !== data.url ) {#> hidden<# } #>">
		<label for="pstoolkit-general-custom-{{data.id}}" class="sui-label"><?php esc_html_e( 'URL', 'ub' ); ?></label>
		<input id="pstoolkit-general-custom-{{data.id}}" type="text" name="pstoolkit[custom]" value="{{data.custom}}" data-default="" data-required="no" placeholder="<?php esc_attr_e( 'E.g. http://example.com', 'ub' ); ?>" aria-describedby="input-description" class="sui-form-control">
	</div>
	<div class="sui-form-field pstoolkit-general-target">
		<label for="pstoolkit-general-target-{{data.id}}" class="sui-label"><?php esc_html_e( 'Link öffnen in', 'ub' ); ?></label>
		<div class="sui-side-tabs sui-tabs">
			<div class="sui-tabs-menu">
				<label class="sui-tab-item<# if ( 'new' === data.target ) { #> active<# } #>">
					<input type="radio" name="pstoolkit[target]" value="new" data-name="target" data-tab-menu="pstoolkit-admin-bar-target-{{data.id}}-new" data-default="current"<# if ( 'new' === data.target ) { #> checked="checked"<# } #>><?php esc_html_e( 'Neue Registerkarte', 'ub' ); ?></label>
				<label class="sui-tab-item<# if ( 'current' === data.target ) { #> active<# } #>">
					<input type="radio" name="pstoolkit[target]" value="current" data-name="target" data-tab-menu="pstoolkit-admin-bar-target-{{data.id}}-current" data-default="current"<# if ( 'current' === data.target ) { #> checked="checked"<# } #>><?php esc_html_e( 'Gleiche Registerkarte', 'ub' ); ?></label>
			</div>
		</div>
	</div>
</div>
</script>
