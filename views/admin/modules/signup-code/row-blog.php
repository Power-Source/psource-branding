<div class="sui-box">
	<div class="sui-row">
		<div class="sui-col-lg-6">
			<input type="text" class="sui-form-control" value="<?php echo esc_attr( $code ); ?>" placeholder="<?php esc_attr_e( 'Anmeldecode', 'ub' ); ?>" name="simple_options[blog][<?php echo esc_attr( $id ); ?>][code]" />
		</div>
		<div class="sui-col-lg-4">
			<label class="sui-checkbox">
				<input type="checkbox" name="simple_options[blog][<?php echo esc_attr( $id ); ?>][case]" <?php checked( $case, 'sensitive' ); ?> />
				<span aria-hidden="true"></span>
				<span><?php esc_html_e( 'Groß- und Kleinschreibung beachten', 'ub' ); ?></span>
			</label>
		</div>
		<div class="sui-col-lg-2">
			<div class="sui-button-icon sui-button-red">
				<i class="sui-icon-trash" aria-hidden="true"></i>
				<span class="sui-screen-reader-text"><?php esc_html_e( 'Element entfernen', 'ub' ); ?></span>
			</div>
		</div>
	</div>
</div>
