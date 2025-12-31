<?php
if ( ! empty( $footer_text ) ) {
	printf(
		'<div class="sui-footer">%s</div>',
		$footer_text
	);
}
if ( PSToolkit_Helper::is_member() ) {
	if ( ! $hide_footer ) { ?>
<ul class="sui-footer-nav">
	<li><a href="https://n3rds.work/hub/" target="_blank"><?php esc_html_e( 'The Hub', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/projects/category/plugins/" target="_blank"><?php esc_html_e( 'Plugins', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/roadmap/" target="_blank"><?php esc_html_e( 'Roadmap', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/hub/support/" target="_blank"><?php esc_html_e( 'Support', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/docs/" target="_blank"><?php esc_html_e( 'Docs', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/hub/community/" target="_blank"><?php esc_html_e( 'Community', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/academy/" target="_blank"><?php esc_html_e( 'Academy', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/terms-of-service/" target="_blank"><?php esc_html_e( 'Terms of Service', 'ub' ); ?></a></li>
	<li><a href="https://incsub.com/privacy-policy/" target="_blank"><?php esc_html_e( 'Privacy Policy', 'ub' ); ?></a></li>
</ul>
		<?php
	}
} else {
	?>
<ul class="sui-footer-nav">
	<li><a href="https://profiles.classicpress.org/psource#content-plugins" target="_blank"><?php esc_html_e( 'Free Plugins', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/features/" target="_blank"><?php esc_html_e( 'Membership', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/roadmap/" target="_blank"><?php esc_html_e( 'Roadmap', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/docs/" target="_blank"><?php esc_html_e( 'Docs', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/hub-welcome/" target="_blank"><?php esc_html_e( 'The Hub', 'ub' ); ?></a></li>
	<li><a href="https://n3rds.work/terms-of-service/" target="_blank"><?php esc_html_e( 'Terms of Service', 'ub' ); ?></a></li>
	<li><a href="https://incsub.com/privacy-policy/" target="_blank"><?php esc_html_e( 'Privacy Policy', 'ub' ); ?></a></li>
</ul>
	<?php
}
if ( ! $hide_footer ) {
	?>
<ul class="sui-footer-social">
	<li><a href="https://www.facebook.com/psource" target="_blank"><i class="sui-icon-social-facebook" aria-hidden="true"></i><span class="sui-screen-reader-text">Facebook</span></a></li>
	<li><a href="https://twitter.com/psource" target="_blank"><i class="sui-icon-social-twitter" aria-hidden="true"></i></a><span class="sui-screen-reader-text">Twitter</span></li>
	<li><a href="https://www.instagram.com/wpmu_dev/" target="_blank"><i class="sui-icon-instagram" aria-hidden="true"></i><span class="sui-screen-reader-text">Instagram</span></a></li>
</ul>
	<?php
}
$this->render( 'admin/common/dialogs/reset' );
