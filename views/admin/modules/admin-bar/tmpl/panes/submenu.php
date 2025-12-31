<script type="text/html" id="tmpl-<?php echo esc_attr( $dialog_id ); ?>-pane-submenu">
<div class="sui-form-field pstoolkit-submenu-items">
	<span class="sui-description"><?php esc_html_e( 'Ordne die Untermenüelemente durch Ziehen und Ablegen nach Bedarf neu an.', 'ub' ); ?></span>
	<div class="sui-box-builder">
		<div class="sui-box-builder-body">
			<div class="sui-accordion pstoolkit-sui-accordion-sortable">
			</div>
			<div class="pstoolkit-admin-bar-no-submenu">
				<button class="sui-button sui-button-dashed pstoolkit-admin-bar-submenu-add" data-template="pstoolkit-admin-bar-submenu-add-template" type="button">
					<span class="sui-loading-text">
						<i class="sui-icon-plus"></i><?php esc_html_e( 'Element hinzufügen', 'ub' ); ?>
					</span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>
				<span class="sui-box-builder-message"><?php esc_html_e( 'Es wurde noch kein Untermenüelement hinzugefügt. Klicke auf "+Element hinzufügen", um ein Untermenüelement hinzuzufügen', 'ub' ); ?></span>
			</div>
		</div>
	</div>
	<div class="sui-row">
		<div class="sui-actions-left">
			<button class="sui-button sui-button-blue pstoolkit-admin-bar-submenu-add" data-template="pstoolkit-admin-bar-submenu-add-template" type="button">
				<span class="sui-loading-text">
					<i class="sui-icon-plus"></i><?php esc_html_e( 'Element hinzufügen', 'ub' ); ?>
				</span>
				<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</div>
</script>
<script type="text/html" id="tmpl-pstoolkit-admin-bar-submenu-add-template">
	<div class="sui-accordion-item ui-sortable-handle" id="pstoolkit-admin-bar-submenu-{{{data.id}}}">
	<div class="sui-accordion-item-header">
		<div class="sui-accordion-item-title sui-accordion-item-action">
			<i class="sui-icon-drag" aria-hidden="true">
</i>{{{data.title}}}</div>
			<button class="sui-button-red sui-button-icon sui-accordion-item-action pstoolkit-admin-bar-submenu-delete" type="button">
<i class="sui-icon-trash">
</i>
</button>
			<span class="pstoolkit-action-divider">
</span>
			<div class="sui-accordion-col-auto">
				<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_attr_e( 'Öffne Element', 'ub' ); ?>">
<i class="sui-icon-chevron-down" aria-hidden="true">
</i>
</button>
			</div>
	</div>
	<div class="sui-accordion-item-body">
		<div class="sui-row">
			<div class="sui-col">
				<div class="sui-form-field pstoolkit-submenu-title pstoolkit-admin-bar-submenu-title">
					<label for="pstoolkit-submenu-title-{{{data.id}}}" class="sui-label">Titel</label>
					<input id="pstoolkit-submenu-title-{{{data.id}}}" type="text" name="pstoolkit[submenu][{{{data.id}}}][title]" value="{{{data.title}}}" data-default="" data-required="required" aria-describedby="input-description" class="sui-form-control" />
					<span class="hidden"><?php esc_html_e( 'Dieses Feld kann nicht leer sein!', 'ub' ); ?></span>
				</div>
			</div>
			<div class="sui-col">
				<div class="sui-form-field pstoolkit-submenu-target">
					<label for="pstoolkit-submenu-target-{{{data.id}}}" class="sui-label"><?php esc_html_e( 'Link öffnen in', 'ub' ); ?></label>
					<div class="sui-side-tabs sui-tabs">
						<div class="sui-tabs-menu">
							<label class="sui-tab-item <# if ( 'new' === data.target ) { #>active<# } #>">
<input type="radio" name="pstoolkit[submenu][{{{data.id}}}][target]" value="new" data-name="" data-tab-menu="" <# if ( 'new' === data.target ) { #>checked="checked"<# } #> /><?php esc_html_e( 'neuer Registerkarte', 'ub' ); ?></label>
							<label class="sui-tab-item <# if ( 'current' === data.target ) { #>active<# } #>">
<input type="radio" name="pstoolkit[submenu][{{{data.id}}}][target]" value="current" data-name="" data-default="" data-tab-menu="" <# if ( 'current' === data.target ) { #>checked="checked"<# } #> /><?php esc_html_e( 'gleiche Registerkarte', 'ub' ); ?></label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sui-form-field">
			<label for="pstoolkit-submenu-url-{{{data.id}}}" class="sui-label">
</label>
			<div class="sui-side-tabs sui-tabs">
				<div class="sui-tabs-menu">
					<label class="sui-tab-item <# if ( 'admin' === data.url ) { #>active<# } #>">
<input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="admin" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-admin" <# if ( 'admin' === data.url ) { #>checked="checked"<# } #>  /><?php esc_html_e( 'Administrator Seite', 'ub' ); ?></label>
					<label class="sui-tab-item <# if ( 'site' === data.url ) { #>active<# } #>">
<input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="site" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-site" <# if ( 'site' === data.url ) { #>checked="checked"<# } #> /><?php esc_html_e( 'Webseite-Seite', 'ub' ); ?></label>
					<label class="sui-tab-item <# if ( 'custom' === data.url ) { #>active<# } #>">
<input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="custom" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-custom" <# if ( 'custom' === data.url ) { #>checked="checked"<# } #> /><?php esc_html_e( 'Extern', 'ub' ); ?></label>
				</div>
				<div class="sui-tabs-content">
					<div class="sui-tab-boxed <# if ( 'admin' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-admin">
						<label class="sui-label">URL</label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="E.g. media.php" name="pstoolkit[submenu][{{{data.id}}}][url_admin]" value="{{{data.url_admin}}}" data-default="" />
						<p class="sui-tab-boxed"><?php echo sprintf( esc_html( __( 'URL ist relativ zu %s', 'ub' ) ), sprintf( '<b>%s</b>', esc_url( admin_url() ) ) ); ?>
</p>
					</div>
					<div class="sui-tab-boxed <# if ( 'site' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-site">
						<label class="sui-label">URL</label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="E.g. http://example.com" name="pstoolkit[submenu][{{{data.id}}}][url_site]" value="{{{data.url_site}}}" data-default="" />
					</div>
					<div class="sui-tab-boxed <# if ( 'custom' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-custom">
						<label class="sui-label">URL</label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="E.g. http://example.com" name="pstoolkit[submenu][{{{data.id}}}][url_custom]" value="{{{data.url_custom}}}" data-default="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
