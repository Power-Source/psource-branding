<?php
$id        = empty( $id ) ? '' : $id;
$value     = empty( $value ) ? '' : $value;
$name      = empty( $name ) ? 'pstoolkit[icon]' : $name;
$list      = empty( $list ) ? array() : $list;
$indicator = empty( $indicator ) ? '' : $indicator;
?>
<div class="pstoolkit-general-icon">
	<input id="pstoolkit-general-icon-<?php echo esc_attr( $id ); ?>" type="hidden"
		   name="<?php echo esc_attr( $name ); ?>"
		   value="<?php echo esc_attr( $value ); ?>"/>

	<div class="sui-accordion">
		<div class="sui-accordion-item">
			<div class="sui-accordion-item-header">
				<div class="sui-accordion-col">
					<span>
						<?php
						$is_empty = empty( $value );
						if ( $is_empty ) {
							_e( 'Wählen', 'ub' );
						} else {
							printf(
								'<span class="dashicons dashicons-%s"></span>',
								esc_attr( $value )
							);
						}
						?>
					</span><?php echo $indicator; ?>
				</div>
			</div>
			<div class="sui-accordion-item-body">
				<input class="pstoolkit-general-icon-search sui-form-control" type="text"
					   placeholder="<?php esc_attr_e( 'Tippe um zu suchen', 'ub' ); ?>"/>
				<?php
				$class    = 'hidden';
				$dashicon = '<span class="dashicons"></span>';
				if ( ! $is_empty ) {
					$class    = '';
					$dashicon = sprintf(
						'<span class="dashicons dashicons-%s"></span>',
						esc_attr( $value )
					);
				}
				?>
				<div class="pstoolkit-dashicon-list">
					<div class="pstoolkit-dashicon-selection <?php echo esc_attr( $class ); ?>">
						<div class="sui-row">
							<div class="sui-col"><?php esc_html_e( 'Ausgewählt', 'ub' ); ?></div>
							<div class="sui-col"><a href="#"
													class="pstoolkit-general-icon-clear"><?php esc_html_e( 'Leeren', 'ub' ); ?></a>
							</div>
						</div>
						<span class="pstoolkit-dashicon-preview"><?php echo $dashicon; ?></span>
					</div>
					<?php
					foreach ( $list as $group_id => $group ) {
						echo '<div class="pstoolkit-dashicons">';
						printf(
							'<label class="sui-label">%s</label>',
							$group['title']
						);
						foreach ( $group['icons'] as $code => $class ) {
							printf(
								'<span data-code="%s" class="dashicons dashicons-%s"></span>',
								esc_attr( $class ),
								esc_attr( $class )
							);
						}
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
