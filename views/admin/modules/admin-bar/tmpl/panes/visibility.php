<script type="text/html" id="tmpl-<?php echo esc_attr( $dialog_id ); ?>-pane-visibility">
<div class="sui-form-field pstoolkit-visibility-roles">
	<label for="pstoolkit-visibility-roles-{{data.id}}" class="sui-label"><?php esc_html_e( 'Benutzerregeln', 'ub' ); ?></label>
	<span class="sui-description"><?php esc_html_e( 'Wähle die Benutzerrollen aus, die dieses Menü anzeigen dürfen.', 'ub' ); ?></span>
<#
var i = 0;
var columns = 6;
_.each( data.available_roles, function( value, key, obj ) {
	if ( 0 === i % ( 12 / columns ) ) {
		if ( 0 < i ) {
			#></div><#
		}
		#><div class="sui-row"><#
	}
#>
		<div class="sui-col-md-{{columns}}">
			<label class="sui-checkbox">
				<input
					type="checkbox"
					name="pstoolkit[roles][{{key}}]"
					value="{{key}}"
					<# if ( 'undefined' !== typeof data.roles[key] ) { #>checked="checked"<# } #>
				>
				<span></span>
				<span>{{value}}</span>
			</label>
		</div>
<#
	i++;
});
if ( 0 !== i % ( 12 / columns ) ) {
	#></div><#
}
#>
</div>
<div class="sui-form-field pstoolkit-visibility-mobile<# if ( '' === data.icon ) { #> hidden<# } #>">
	<label for="pstoolkit-visibility-mobile-{{data.id}}" class="sui-label"><?php esc_html_e( 'Auf Handy anzeigen', 'ub' ); ?></label>
	<span class="sui-description"><?php esc_html_e( 'Menüelement-Symbol auf dem Handy anzeigen.', 'ub' ); ?></span>
	<div class="sui-side-tabs sui-tabs">
		<div class="sui-tabs-menu">
			<label class="sui-tab-item<# if ( 'show' === data.mobile ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[mobile]" value="show" data-name="mobile" data-tab-menu="pstoolkit-admin-bar-mobile-{{data.id}}-show" data-default="current"<# if ( 'show' === data.mobile ) { #> checked="checked"<# } #>><?php esc_html_e( 'Anzeigen', 'ub' ); ?></label>
			<label class="sui-tab-item<# if ( 'hide' === data.mobile ) { #> active<# } #>">
				<input type="radio" name="pstoolkit[mobile]" value="hide" data-name="mobile" data-tab-menu="pstoolkit-admin-bar-mobile-{{data.id}}-hide" data-default="hide"<# if ( 'hide' === data.mobile ) { #> checked="checked"<# } #>><?php esc_html_e( 'Ausblenden', 'ub' ); ?></label>
		</div>
		<div class="sui-tabs-content">
			<div class="sui-tab-boxed <# if ( 'show' === data.mobile ) { #>active<# } #>" data-tab-content="pstoolkit-admin-bar-mobile-{{{data.id}}}-show">
				<?php
				echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__( 'Stelle sicher dass Du auf der Registerkarte ALLGEMEIN ein Symbol für diesen Menüpunkt festgelegt hast, da auf Mobilgeräten nur das Menüsymbol angezeigt wird.', 'ub' ),
					'default'
				);
				?>
			</div>
		</div>
	</div>
</div>
</script>
