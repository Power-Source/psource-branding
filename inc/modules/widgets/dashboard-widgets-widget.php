<?php
/**
 * PSToolkit Dashboard Widgets class.
 *
 * @package PSToolkit
 * @subpackage Widgets
 */
if ( ! class_exists( 'PSToolkit_Dashboard_Widgets_Widget' ) ) {
	class PSToolkit_Dashboard_Widgets_Widget {
		var $widget_id;
		var $widget_options;

		public function init( $options_set = '', $options = array() ) {
			if ( empty( $options_set ) ) {
				return; }
			if ( empty( $options ) ) {
				return; }
			if ( strlen( $options_set ) ) {
				$this->widget_id   = $options['pstoolkit_id'];
				$options['number'] = $options_set;
			}
			$this->widget_options = $options;
			wp_add_dashboard_widget(
				$this->widget_id,
				stripslashes( $this->widget_options['title'] ),
				array( $this, 'wp_dashboard_widget_display' )
			);
		}

		public function wp_dashboard_widget_display() {
			$content = $this->widget_options['content'];
			if ( isset( $this->widget_options['content_meta'] ) ) {
				$content = $this->widget_options['content_meta'];
			}
			printf( '<div class="pstoolkit-widget">%s</div>', stripslashes( $content ) );
		}

		public function wp_dashboard_widget_controls() {
			wp_widget_rss_form( $this->widget_options );
		}
	}
}
