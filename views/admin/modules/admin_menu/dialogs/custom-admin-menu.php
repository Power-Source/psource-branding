<script type="text/html" id="tmpl-custom-admin-menu">
	<div class="pstoolkit-custom-admin-menu pstoolkit-custom-admin-menu-{{ data.menu_key }}">
		<div class="pstoolkit-custom-admin-menu-builder-fields">
		</div>

		<div class="sui-box-footer">
			<button class="sui-button sui-button-ghost pstoolkit-discard-admin-menu-changes"
					type="button">
				<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>

				<span class="sui-loading-text">
					<i class="sui-icon-refresh" aria-hidden="true"></i>
					<?php esc_html_e( 'Alle Änderungen verwerfen', 'ub' ); ?>
				</span>
			</button>

			<button class="sui-button pstoolkit-apply-admin-menu-changes"
					type="button">
				<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>

				<span class="sui-loading-text">
					<i class="sui-icon-check" aria-hidden="true"></i>
					<?php esc_html_e( 'Anwenden', 'ub' ); ?>
				</span>
			</button>
		</div>
	</div>
</script>
