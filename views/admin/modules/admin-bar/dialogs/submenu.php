<div class="sui-accordion-item ui-sortable-handle" id="pstoolkit-admin-bar-submenu-{{{data.id}}}">
	<div class="sui-accordion-item-header">
		<div class="sui-accordion-item-title sui-accordion-item-action">
			<i class="sui-icon-drag" aria-hidden="true"></i>{{{data.title}}}</div>
			<button class="sui-button-red sui-button-icon sui-accordion-item-action pstoolkit-admin-bar-submenu-delete" type="button"><i class="sui-icon-trash"></i></button>
			<span class="pstoolkit-action-divider"></span>
			<div class="sui-accordion-col-auto">
				<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_attr_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
			</div>
	</div>
	<div class="sui-accordion-item-body">
		<div class="sui-row">
			<div class="sui-col">
				<div class="sui-form-field pstoolkit-submenu-title pstoolkit-admin-bar-submenu-title">
					<label for="pstoolkit-submenu-title-{{{data.id}}}" class="sui-label"><?php esc_html_e( 'Titel', 'ub' ); ?></label>
					<input id="pstoolkit-submenu-title-{{{data.id}}}" type="text" name="pstoolkit[submenu][{{{data.id}}}][title]" value="{{{data.title}}}" data-default="" data-required="required" aria-describedby="input-description" class="sui-form-control" />
					<span class="hidden"><?php esc_html_e( 'Dieses Feld kann nicht leer sein!', 'ub' ); ?></span>
				</div>
			</div>
			<div class="sui-col">
				<div class="sui-form-field pstoolkit-submenu-target">
					<label for="pstoolkit-submenu-target-{{{data.id}}}" class="sui-label"><?php esc_html_e( 'Link öffnen in', 'ub' ); ?></label>
					<div class="sui-side-tabs sui-tabs">
						<div class="sui-tabs-menu">
							<label class="sui-tab-item <# if ( 'new' === data.target ) { #>active<# } #>"><input type="radio" name="pstoolkit[submenu][{{{data.id}}}][target]" value="new" data-name="" data-tab-menu="" <# if ( 'new' === data.target ) { #>checked="checked"<# } #> /><?php esc_html_e( 'neuer Registerkarte', 'ub' ); ?></label>
							<label class="sui-tab-item <# if ( 'current' === data.target ) { #>active<# } #>"><input type="radio" name="pstoolkit[submenu][{{{data.id}}}][target]" value="current" data-name="" data-default="" data-tab-menu="" <# if ( 'current' === data.target ) { #>checked="checked"<# } #> /><?php esc_html_e( 'gleicher Registerkarte', 'ub' ); ?></label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sui-form-field">
			<label for="pstoolkit-submenu-url-{{{data.id}}}" class="sui-label"></label>
			<div class="sui-side-tabs sui-tabs">
				<div class="sui-tabs-menu">
					<label class="sui-tab-item <# if ( 'admin' === data.url ) { #>active<# } #>"><input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="admin" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-admin" <# if ( 'admin' === data.url ) { #>checked="checked"<# } #>  />Admin Page</label>
					<label class="sui-tab-item <# if ( 'site' === data.url ) { #>active<# } #>"><input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="site" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-site" <# if ( 'site' === data.url ) { #>checked="checked"<# } #> />Site Page</label>
					<label class="sui-tab-item <# if ( 'custom' === data.url ) { #>active<# } #>"><input type="radio" name="pstoolkit[submenu][{{{data.id}}}][url]" value="custom" data-name="submenu-url-{{{data.id}}}" data-tab-menu="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-custom" <# if ( 'custom' === data.url ) { #>checked="checked"<# } #> />External</label>
				</div>
				<div class="sui-tabs-content">
					<div class="sui-tab-boxed <# if ( 'admin' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-admin">
						<label class="sui-label"><?php esc_html_e( 'URL', 'ub' ); ?></label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'z.B. media.php', 'ub' ); ?>" name="pstoolkit[submenu][{{{data.id}}}][url_admin]" value="{{{data.url_admin}}}" data-default="" />
						<p class="sui-tab-boxed">
						<?php
						printf(
							__( 'URL ist relativ zu %s', 'ub' ),
							sprintf( '<b>%s</b>', admin_url() )
						);
						?>
						</p>
					</div>
					<div class="sui-tab-boxed <# if ( 'site' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-site">
						<label class="sui-label"><?php esc_html_e( 'URL', 'ub' ); ?></label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'z.B. http://example.com', 'ub' ); ?>" name="pstoolkit[submenu][{{{data.id}}}][url_site]" value="{{{data.url_site}}}" data-default="" />
					</div>
					<div class="sui-tab-boxed <# if ( 'custom' === data.url ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-submenu-url-{{{data.id}}}-custom">
						<label class="sui-label"><?php esc_html_e( 'URL', 'ub' ); ?></label>
						<input type="text" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'z.B. http://example.com', 'ub' ); ?>" name="pstoolkit[submenu][{{{data.id}}}][url_custom]" value="{{{data.url_custom}}}" data-default="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
