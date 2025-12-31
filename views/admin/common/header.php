<div class="sui-header">
	<h1 class="sui-header-title"><?php echo esc_html( $title ); ?></h1>
	<div class="sui-actions-right">
<?php if ( $documentation_chapter && ! empty( $helps ) ) : ?>
		<a target="_blank" class="sui-button sui-button-ghost"
		   href="https://n3rds.work/docs/psource-wp-toolkit-dokumentation-erste-schritte/#<?php echo esc_attr( $documentation_chapter ); ?>">
			<i class="sui-icon-academy"></i>
			<?php esc_html_e( 'Dokumentation anzeigen', 'ub' ); ?>
		</a>
<?php endif; ?>
	</div>
</div>
